<?php

namespace App\Services\Users;


use App\Helpers\FilesHelper;
use App\Helpers\JsonHelper;
use App\Mail\ResetPassword;
use App\Models\AchievementMode;
use App\Models\AchievementTypeCategory;
use App\Models\InviteCode;
use App\Models\Organization;
use App\Services\Departments\Repositories\DepartmentRepositoryInterface;
use App\Services\InviteCodes\Repositories\InviteCodeRepositoryInterface;
use App\Services\Organizations\Repositories\OrganizationRepositoryInterface;
use App\Services\Years\Repositories\YearRepositoryInterface;
use App\Services\Roles\Repositories\RoleRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Error;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersService extends Services
{
    private UserRepositoryInterface $_repository;

    private RoleRepositoryInterface $roleRepository;

    private YearRepositoryInterface $yearRepository;

    private DepartmentRepositoryInterface $departmentRepository;

    private InviteCodeRepositoryInterface $inviteCodeRepository;


    private OrganizationRepositoryInterface $organizationRepository;


    public function __construct(UserRepositoryInterface         $userRepository, RoleRepositoryInterface $roleRepository,
                                DepartmentRepositoryInterface   $departmentRepository, InviteCodeRepositoryInterface $inviteCodeRepository,
                                OrganizationRepositoryInterface $organizationRepository, YearRepositoryInterface $yearRepository)
    {
        $this->_repository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->departmentRepository = $departmentRepository;
        $this->inviteCodeRepository = $inviteCodeRepository;
        $this->organizationRepository = $organizationRepository;
        $this->yearRepository = $yearRepository;
    }

    public function register(array $data)
    {
        $codeId =(int )Cookie::get('invite_code_id');
        Log::debug('code id = '.$codeId);
        $code = $this->inviteCodeRepository->find($codeId);
        if($code and $code->id)
        {
            $organizationId = $code->organization_id;
            if (isset($organizationId) and is_numeric($organizationId) and $this->organizationRepository->exist($organizationId))
            {
                $data['organization_id'] = $organizationId;
                if($code->type==1)
                {
                    $data['role'] = 'user';
                }
                else
                {
                    $data['role'] = 'teacher';
                }
                $data['login'] = $data['email'];

                $user = $this->_repository->create($data);
                if($user and $user->id)
                {
                    $userId = $user->id;

                    $code->delete();

                    if (isset($data['departments_ids'])) {
                        $departmentsIds = $data['departments_ids'];
                        foreach ($departmentsIds as $id) {
                            $user->departments()->attach($id);
                        }
                    }
                    if(isset($data['role']))
                    {
                        $slug = $data['role'];
                        $role = $this->roleRepository->find($slug);
                        $user->attachRole($role);
                    }
                    $updatedUser = $this->_repository->find($userId);
                    return self::sendJsonResponse(true, [
                        'title' => 'Успешно',
                        'message' => 'Пользователь успешно создан',
                        'user' => $updatedUser
                    ]);
                }
            }
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При сохранении данных произошла  ошибка'
        ]);
    }

    public function create(array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ]);
        }
        if (!is_numeric($data['organization_id'])) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'У вас неккоректно задан id организации'
            ]);
        }
        $data['secret_key'] = Str::random(10);
        $user = $this->_repository->create($data);
        if ($user and $user->id) {
            $userId = $user->id;
            if (isset($data['role'])) {
                $role = $this->roleRepository->find($data['role']);
            } else {
                $role = $this->roleRepository->find('user');
            }
            $user->attachRole($role);

            if (isset($data['departments_ids'])) {
                $departmentsIds = $data['departments_ids'];
                foreach ($departmentsIds as $id) {
                    Log::debug('department id = ' . $id);
                    $user->departments()->attach($id);
                }
            }
            $updatedUser = $this->_repository->find($userId);
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Пользователь успешно создан',
                'user' => $updatedUser
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При сохранении данных произошла  ошибка'
        ]);
    }

    public function find(int $id): JsonResponse
    {
        $user = $this->_repository->find($id);
        if ($user and $user->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'user' => $user
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при поиске пользователя'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->_repository->delete($id);
        if ($result) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Пользователь удален успешно'
            ]);
        } else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при удалении из базы данных'
            ]);
        }
    }

    public function addDepartment(int $userId, array $departmentsIds): JsonResponse
    {
        $user = $this->_repository->find($userId);
        if ($user and $user->id) {
            foreach ($departmentsIds as $departmentId) {
                if ($this->departmentRepository->exist($departmentId)) {
                    $user->departments()->attach($departmentId);
                }
            }
            $updatedUser = $this->_repository->find($userId);
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Кафедра успешно привязана',
                'user' => $updatedUser
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При получении пользователя произошла ошибка'
        ]);

    }

    public function filter(array $data)
    {
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }
        $data['paginate'] = true;

        if(!isset($data['page']))
        {
            $data['page'] = 1;
        }
        $you = Auth::user();
        $organizations = Organization::all();
        $users = $this->_repository->search($data);
        return view('templates.dashboard.platform.users.index',[
            'you' => $you,
            'users' => $users,
            'organizations' => $organizations
        ]);
    }

    public function search(array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ]);
        }

        $users = $this->_repository->search($data);
        return self::sendJsonResponse(true, [
            'title' => 'Успех',
            'message' => 'Пользователи успешно найдены',
            'users' => $users
        ]);
    }

    public function configureDepartments(int $userId, array $departmentsIds): JsonResponse
    {
        $user = $this->_repository->find($userId);
        if ($user and $user->id) {
            $user->departments()->sync($departmentsIds);
            $updatedUser = $this->_repository->find($userId);
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Направления успешно привязаны',
                'user' => $updatedUser
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При получении пользователя произошла ошибка'
        ]);
    }

    public function you(): JsonResponse
    {
        $you = Auth::user();
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'you' => $you
        ]);
    }

    public function resetPassword(string $email)
    {
        $user = $this->_repository->getByEmail($email);
        $userId = $user->id;
        $payload = [
            'exp' => time() + config('jwt.exp'),
            'user_id' => $userId
        ];
        try {
            $token = JWT::encode($payload, config('jwt.key'), config('jwt.alg'));
        } catch (Error $error) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при кодировании токена'
            ]);
        }
        $resetLink = config('app.url') . '/password/new?token=' . $token;
        try {
            Mail::to($email)->queue(new ResetPassword($resetLink));
        } catch (Error $error) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при отправке сообщения на почту'
            ]);
        }
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'message' => 'Ссылка на сброс пароля была успешно отправлена на почту'
        ]);
    }

    public function getByEmail(string $email): Model|JsonResponse
    {
        if (!$this->_repository->emailExist($email)) {
            return self::sendJsonResponse(true, [
                'title' => 'Ошибка при верификации email',
                'message' => 'Такого email не существует'
            ]);
        }
        return $this->_repository->getByEmail($email);
    }

    public function newPassword(string $newPassword, string $token)
    {
        list($headersB64, $payloadB64, $sig) = explode('.', $token);
        $decoded = json_decode(base64_decode($payloadB64), true);
        $userId = (int)$decoded['user_id'];
        $user = $this->_repository->find($userId);
        $user->password = Hash::make($newPassword);
        $user->save();
        return redirect('home');
    }



    public function registerRedirect(int $codeId, int $code)
    {
        Log::debug('1 code id = '.$codeId);
        if ($this->inviteCodeRepository->login($codeId, $code)) {
            $code = $this->inviteCodeRepository->find($codeId);
            if($code and $code->id)
            {
                return redirect('/registration/by-code')->withCookie(Cookie::make('invite_code_id',$codeId));
            }
        }
        return back()->withErrors(['Данный регистрационный код некорректен']);

    }

    public function update(int $id, array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ]);
        }
        if(isset($data['avatar']))
        {
            if(FilesHelper::acceptableImage($data['avatar']))
            {
                $directory = ceil($id/1000);
                $directoryPath = 'public/avatars/'.$directory;
                $avatar = $data['avatar'];
                $extension = $avatar->extension();
                $avatarFileName = $id.'.'.$extension;
                $avatar->storeAs($directoryPath,$avatarFileName);
                $data['avatar_path'] = 'storage/avatars/'.$directory.'/'.$avatarFileName;
            }
            else
            {
                return self::sendJsonResponse(false,[
                    'title' => 'Ошибка',
                    'message' => 'Загруженное изображение должно быть формата jpeg,png,webp'
                ]);
            }
        }


        $result = $this->_repository->update($id, $data);

        if ($result) {
            $user = $this->_repository->find($id);
            if (isset($data['role'])) {
                $roleSlug = $data['role'];
                $role = $this->roleRepository->find($roleSlug);
                $roleId = $role->id;
                $user->syncRoles([$roleId]);
            }
            return self::sendJsonResponse(true, [
                'title' => 'Успех',
                'message' => 'Информация успешно сохранена',
                'user' => $user
            ]);
        } else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'При сохранении данных произошла ошибка',
                'id' => $result->id
            ]);
        }
    }

    public function registerView(int $codeId)
    {
        $code = $this->inviteCodeRepository->find($codeId);
        if($code and $code->id)
        {
            $organizationId = $code->organization_id;
            $organization = $this->organizationRepository->find($organizationId);
            if ($organization and $organization->id) {
                $organizationName = $organization->name;
                return view('templates.site.auth.code-registration', [
                    'code' => $code,
                    'organization_name' => $organizationName
                ]);
            }
        }
        return redirect('login')->withErrors(['К вашему коду привязана неккоректная организация']);
    }

    public function userManagement($organizationId): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $years = $this->yearRepository->get($organizationId);
        return view('templates.dashboard.settings.user_management', ['years' => $years]);
    }


    public function get(array $data): JsonResponse
    {
        $you = Auth::user();
        $data['organization_id'] = $you->organization_id;
        $users = $this->_repository->get($data);
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'users' => $users
        ]);
    }


    public function generateApiKey(int $id, string $apiKey, string $secretKey): JsonResponse
    {
        if (config('jwt.api_key') != $apiKey) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Неккоректный API ключ'
            ]);
        }
        $you = Auth::user();
        if ($you->secret_key != $secretKey) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Неккоректный secret key'
            ]);
        }
        $payload = [
            'user_id' => $id,
            'expires_at' => time() + config('jwt.ex')
        ];
        $token = JWT::encode($payload, $secretKey, config('jwt.alg'));
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'token' => $token
        ]);
    }

    public function teachersPortfoliosView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $years = $this->yearRepository->get($organizationId);
        $roles = ['teacher'];
        $data = [
            'organization_id' => $organizationId,
            'roles' => $roles,
            'paginate' => false
        ];
        $users = $this->_repository->get($data);
        return view('templates.dashboard.portfolios.teachers',['years' => $years,'users' => $users]);
    }

    public function openPortfolio(int $id)
    {
        $user = $this->_repository->find($id);
        if($user and $user->id)
        {
            return view('templates.dashboard.portfolios.portfolio',['user' => $user]);
        }
        return back()->withErrors(['Возникла ошибка при поиске пользователя с данным id']);
    }

    public function studentsPortfoliosView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $years = $this->yearRepository->get($organizationId);
        $roles = ['user'];
        $data = [
            'organization_id' => $organizationId,
            'roles' => $roles,
            'paginate' => false
        ];
        $users = $this->_repository->get($data);
        return view('templates.dashboard.portfolios.students',[
            'years' => $years,
            'users' => $users]
        );
    }

    public function teacherPersonalCabinetView()
    {
        $you = Auth::user();
        return view('templates.dashboard.personal-cabinet',['user' => $you]);
    }

    public function teacherStudentsView()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $years = $this->yearRepository->get($organizationId);
        $roles = ['user'];
        $data = [
            'organization_id' => $organizationId,
            'roles' => $roles,
            'paginate' => false
        ];
        $users = $this->_repository->get($data);
        return view('templates.dashboard.portfolios.students',['years' => $years,'users' => $users]);

    }

    public function teacherDepartmentsView()
    {
        $user = Auth::user();
        $departmentsIds = $user->departments()->pluck('departments.id')->toArray();
        $organizationId = $user->organization_id;
        $years = $this->yearRepository->get($organizationId);
        return view('templates.dashboard.settings.departments',['years' => $years,'departments_ids' => $departmentsIds]);
    }

    public function personalCabinetView()
    {
        $you = Auth::user();
        return view('templates.dashboard.personal-cabinet',['user' => $you]);
    }

    public function profileView()
    {
        $you = Auth::user();
        return view('templates.dashboard.profile',['user' => $you]);
    }

    public function mainPlatformView(array $data)
    {
        $additionalData = [
            'role' => 'admin',
            'paginate' => true
        ];
        if(!isset($data['page']))
        {
            $data['page'] = 1;
        }
        $data = array_merge($data,$additionalData);
        $you = Auth::user();
        $users = $this->_repository->search($data);
        return view('templates.dashboard.platform.index',[
            'users' => $users,
            'you' => $you
            ]
        );
    }

    public function apiView()
    {
        $you = Auth::user();
        $apiKey = config('jwt.api_key');
        $organizationId = $you->organization_id;
        $organization = $this->organizationRepository->find($organizationId);
        if($organization and $organization->id)
        {
            return view('templates.dashboard.settings.api', [
                'you' => $you,
                'api_key' => $apiKey,
                'organization' => $organization
            ]);
        }
        return back()->withErrors(['Ошибка при поиске привязанной организации']);
    }

    public function index(array $data)
    {
        $you = Auth::user();
        $organizations = Organization::all();
        $additionalData = [
            'with_trashed' => true,
            'paginate' => true,
        ];
        if(!isset($data['page']))
        {
            $data['page'] = 1;
        }
        $data = array_merge($data,$additionalData);
        $users = $this->_repository->get($data);
        if($users)
        {
            return view('templates.dashboard.platform.users.index',[
                'you' => $you,
                'users' => $users,
                'organizations' => $organizations
            ]);
        }
        return back()->withErrors(['Ошибка при получении пользователей']);
    }

    public function store(array $data)
    {
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }
        if (!is_numeric($data['organization_id'])) {
            return back()->withErrors(['Не указана организация']);
        }
        $data['secret_key'] = Str::random(10);
        $user = $this->_repository->create($data);
        if ($user and $user->id) {
            $id = $user->id;
            if(isset($data['avatar']) and is_file($data['avatar']) and FilesHelper::acceptableImage($data['avatar']))
            {
                $directory = ceil($id/1000);
                $avatarFile = $data['avatar'];
                $avatarDirectory = 'public/avatars/'.$directory;
                Storage::makeDirectory($avatarDirectory);
                $avatarFileName = $id.'.'.$avatarFile->extension();
                $avatarFile->storeAs($avatarDirectory,$avatarFileName);
                $updatedData['avatar_path'] = 'storage/avatars/'.$directory.'/'.$avatarFileName;

                $updatedData['avatar_file_name'] = $avatarFile->getClientOriginalName();
            }
            else
            {
                return back()->withErrors(['Некорректный файл логотипа. Проверьте расширение файла. Допустимые расширения : jpeg,png,webp,jpg']);
            }

            $result = $this->_repository->update($id,$updatedData);

            if($result)
            {
                if (isset($data['role'])) {
                    $role = $this->roleRepository->find($data['role']);
                }
                else {
                    $role = $this->roleRepository->find('user');
                }
                $user->attachRole($role);

                $you = Auth::user();
                $updatedUser = $this->_repository->find($id);
                if(isset($data['redirect']))
                {
                    return redirect('/dashboard/users/index');
                }
                return view('templates.dashboard.platform.users.index', [
                    'user' => $updatedUser,
                    'you' => $you
                ]);
            }
        }
        return back()->withErrors(['Возникла ошибка при создании пользователя']);
    }

    public function editView(int $id)
    {
        $user = $this->_repository->find($id);
        if($user and $user->id)
        {
            $you = Auth::user();
            $organizations = Organization::all();
            $roles = Role::all();
            return view('templates.dashboard.platform.users.edit',[
                'user' => $user,
                'you'  => $you,
                'organizations' => $organizations,
                'roles' => $roles
            ]);
        }
        return back()->withErrors(['Возникла ошибка при получении пользователей']);
    }


    public function addView()
    {
        $you = Auth::user();
        $organizations = Organization::all();
        $roles = Role::all();
        return view('templates.dashboard.platform.users.create',[
            'you' => $you,
            'organizations' => $organizations,
            'roles' => $roles
        ]);
    }

    public function edit(int $id, array $data)
    {
        if(isset($data['avatar']))
        {
            if(is_file($data['avatar']) and FilesHelper::acceptableImage($data['avatar']))
            {
                $avatarFile = $data['avatar'];
                $directory = ceil($id/1000);
                $avatarDirectory = 'public/avatars/'.$directory;
                Storage::makeDirectory($avatarDirectory);
                $avatarFileName = $id.'.'.$avatarFile->extension();
                $avatarFile->storeAs($avatarDirectory,$avatarFileName);
                $data['avatar_path'] ='storage/avatars/'.$directory.'/'.$avatarFileName;
                $data['avatar_file_name'] = $avatarFile->getClientOriginalName();
            }
            else
            {
                return back()->withErrors(['Некорректный файл логотипа. Проверьте расширение файла. Допустимые расширения : jpeg,png,webp,jpg']);
            }
        }
        $result = $this->_repository->update($id,$data);
        if($result)
        {
            $user = $this->_repository->find($id);
            $you = Auth::user();
            if(isset($data['redirect']))
            {
                return redirect('/dashboard/users/index');
            }
            $organization = $this->_repository->find($id);
            return view('templates.dashboard.platform.users.edit',[
                'organization' => $organization,
                'you' => $you,
                'user' => $user
            ]);
        }
        return back()->withErrors(['Ошибка при обновлении организации']);
    }

    public function destroy(int $id): JsonResponse
    {
        $result = $this->_repository->destroy($id);
        if ($result)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно удален'
            ]);
        }
        else
        {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при удалении пользователя из базы данных'
            ]);
        }
    }

    public function restore(int $id): JsonResponse
    {
        $flag = $this->_repository->restore($id);
        if($flag)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно восстановлен'
            ]);
        }
        else
        {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при восстановлении'
            ]);
        }
    }

    public function updateStatus(int $id)
    {
        $user = $this->_repository->find($id);
        if($user and $user->id)
        {
            $isActive = $user->is_active;
            if($isActive==0)
            {
                $user->is_active = 1;
            }
            else
            {
                $user->is_active = 0;
            }
            $user->save();
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'user' => $user
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении статуса пользователя'
        ]);
    }


}
