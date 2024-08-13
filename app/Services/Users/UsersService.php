<?php

namespace App\Services\Users;


use App\Helpers\JsonHelper;
use App\Mail\ResetPassword;
use App\Models\AchievementMode;
use App\Models\AchievementTypeCategory;
use App\Models\InviteCode;
use App\Services\Departments\Repositories\DepartmentRepositoryInterface;
use App\Services\InviteCodes\Repositories\InviteCodeRepositoryInterface;
use App\Services\Organizations\Repositories\OrganizationRepositoryInterface;
use App\Services\OrganizationsYears\Repositories\OrganizationYearRepositoryInterface;
use App\Services\Roles\Repositories\RoleRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Error;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UsersService extends Services
{
    private UserRepositoryInterface $_repository;

    private RoleRepositoryInterface $roleRepository;

    private OrganizationYearRepositoryInterface $yearRepository;

    private DepartmentRepositoryInterface $departmentRepository;

    private InviteCodeRepositoryInterface $inviteCodeRepository;


    private OrganizationRepositoryInterface $organizationRepository;


    public function __construct(UserRepositoryInterface         $userRepository, RoleRepositoryInterface $roleRepository,
                                DepartmentRepositoryInterface   $departmentRepository, InviteCodeRepositoryInterface $inviteCodeRepository,
                                OrganizationRepositoryInterface $organizationRepository, OrganizationYearRepositoryInterface $yearRepository)
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
        $you = Auth::user();
        $id = $you->id;
        $codeId =(int )Cookie::get('invite_code_id');
        $code = $this->inviteCodeRepository->find($codeId);
        if($code and $code->id)
        {
            $data['organization_id'] = $code->organization_id;
            $data['login'] = $data['email'];
            if (!is_numeric($data['organization_id'])) {
                return self::sendJsonResponse(false, [
                    'title' => 'Ошибка',
                    'message' => 'У вас некорректно задан id организации'
                ]);
            }
            $result = $this->_repository->update($id,$data);
            if($result)
            {
                $user = $this->_repository->find($id);
                if ($user and $user->id) {
                    $userId = $user->id;

                    $code->delete();

                    if (isset($data['departments_ids'])) {
                        $departmentsIds = $data['departments_ids'];
                        foreach ($departmentsIds as $id) {
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
                Log::debug('role = ' . $data['role']);
                $role = $this->roleRepository->find($data['role']);
                Log::debug('role eloquent = ' . $role);
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

    public function search(array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ]);
        }

        $users = $this->_repository->search($data)->except([]);
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

    public function loginByCode(int $codeId, int $code)
    {
        Log::debug('1 code id = '.$codeId);
        if ($this->inviteCodeRepository->login($codeId, $code)) {
            $code = $this->inviteCodeRepository->find($codeId);
            if($code and $code->id)
            {
                $organizationId = $code->organization_id;
                $data = [
                    'organization_id' => $organizationId
                ];
                if($code->type==1)
                {
                    $data['role'] = 'user';
                }
                else
                {
                    $data['role'] = 'teacher';
                }
                $user = $this->_repository->create($data);
                if ($user and $user->id) {
                    if (isset($data['role']))
                    {
                        Log::debug('role = ' . $data['role']);
                        $role = $this->roleRepository->find($data['role']);
                        Log::debug('role eloquent = ' . $role);
                    } else
                    {
                        $role = $this->roleRepository->find('user');
                    }
                    $user->attachRole($role);
                    Auth::login($user);
                    return redirect('/registration/by-code')->withCookie(Cookie::make('invite_code_id',$codeId));
                }
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
            $avatar = $data['avatar'];
            $extension = $avatar->extension();
            $avatarFileName = $id.'.'.$extension;
            $avatar->storeAs('public/avatars',$avatarFileName);
            $data['avatar_path'] = 'storage/avatars/'.$avatarFileName;
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

    public function registerByCodeView(int $codeId)
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

    public function get(array $roles): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $users = $this->_repository->get($organizationId, $roles)->except(['id' => $you->id]);
        //Сюда можно добавить ещё какую-нибудь инфу
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'users' => $users
        ]);
    }

    public function getPaginate(array $data)
    {
        $you = Auth::user();
        $data['organization_id'] = $you->organization_id;
        $users = $this->_repository->getPaginate($data);
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
        $users = $this->_repository->get($organizationId,$roles);
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
        $users = $this->_repository->get($organizationId,$roles);
        return view('templates.dashboard.portfolios.students',['years' => $years,'users' => $users]);
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
        $users = $this->_repository->get($organizationId,$roles);
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


}
