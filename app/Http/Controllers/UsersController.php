<?php

namespace App\Http\Controllers;

use App\Helpers\ValidatorHelper;
use App\Services\Users\UsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public UsersService $usersService;


    protected $fillable = [
        'name',
        'role',
        'roles',
        'page',
        'email',
        'gender',
        'login',
        'password',
        'organization_id',
        'faculty_id',
        'year_id',
        'departments_ids',
        'department_id',
        'specialty_id',
        'phone',
        'group',
        'specialty_id',
        'date_of_birth',
        'is_active',
        'departments_ids',
        'roles',
        'role',
        'is_active',
        'selected_years',
        'selected_departments',
        'avatar',
        'page',
        'paginate'
    ];

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index(Request $request)
    {
        $data = $request->only($this->fillable);
        return $this->usersService->index($data);
    }

    public function addView()
    {
        return $this->usersService->addView();
    }



    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', Rule::exists('users', 'login')],
            'password' => 'required'
        ]);
        $remember = $request->has('remember');

        if (Auth::attempt($credentials,$remember)) {
            $user = Auth::user();
            //Надо будет изменить
            if ($user->is_active == 0)
            {
                return back()->withErrors(['Вы заблокированы']);
            }
            $request->session()->regenerate();

            if($user->hasRole('admin'))
            {
                return redirect('/dashboard/settings/organizations-structure');
            }
            else if ($user->hasRole('employee'))
            {
                return redirect('/dashboard/profile');
            }
            else if($user->hasRole('inspector'))
            {
                return redirect('/dashboard/works/employees');
            }
            else if($user->hasRole('platformadmin'))
            {
                return redirect('/dashboard/platform');
            }
            else
            {
                return redirect('/dashboard/personal-cabinet');
            }
        }
        return back()->withErrors(['Предоставленные данные были некорректными']);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }

    public function loginByCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $fullCode = $request->code;
        $codeArray = explode('-', $fullCode);
        $codeId = $codeArray[0];
        $code = $codeArray[1];
        return $this->usersService->loginByCode($codeId, $code);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::exists('users', 'email')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $email = $request->email;
        return $this->usersService->resetPassword($email);
    }

    public function registerByCodeView()
    {
        $inviteCodeId = Cookie::get('invite_code_id');

        Log::debug('organization id in view = '.$inviteCodeId);

        return $this->usersService->registerByCodeView($inviteCodeId);
    }

    public function registerByCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|max:255',
            'gender' => 'required|integer',
            'departments_ids.*' => ['integer',Rule::exists('departments','id')],
            'department_id' => ['integer',Rule::exists('departments','id')],
            'specialty_id' => ['integer',Rule::exists('programs_specialties','id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->usersService->register($data);
    }

    public function personalCabinetView()
    {
        return $this->usersService->personalCabinetView();
    }

    public function profileView()
    {
        return $this->usersService->profileView();
    }




    public function you(): JsonResponse
    {
        return $this->usersService->you();
    }


    public function newPassword(Request $request)
    {
        $credentials = $request->validate([
            'password' => 'required'
        ]);
        $password = $credentials['password'];
        $token = $request->token;
        return $this->usersService->newPassword($password, $token);
    }


    public function get(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'roles.*' => ['required', Rule::exists('roles', 'slug')],
            'page' => 'integer',
            'selected_departments.*' => ['integer',Rule::exists('departments','id')],
            'paginate' => 'bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        return $this->usersService->get($data);
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|max:255',
            'gender' => 'required|integer',
            'faculty_id' => ['integer',Rule::exists('faculties','id')],
            'year_id' => ['integer',Rule::exists('organizations_years','id')],
            'is_active' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $data = $request->only($this->fillable);
        Log::debug('request data =' . print_r($data, true));

        $you = Auth::user();
        $organizationId = $you->organization_id;
        $data['organization_id'] = $organizationId;
        return $this->usersService->create($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $data = $request->only($this->fillable);
        return $this->usersService->store($data);
    }

    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->usersService->delete($id);
    }

    public function destroy(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->usersService->destroy($id);
    }

    public function restore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->usersService->restore($id);
    }

    public function find(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->usersService->find($id);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
            'name' => 'string|max:255',
            'login' => 'string|max:255',
            'email' => 'string|email|max:255',
            'password' => 'max:255',
            'gender' => 'integer',
            'is_active' => 'integer',
            'departments_ids.*' => ['integer',Rule::exists('departments','id')],
            'role' => [Rule::exists('roles', 'slug')],
            'avatar' => 'file'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        $data = $request->only($this->fillable);
        return $this->usersService->update($id, $data);
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->usersService->updateStatus($id);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
            'name' => 'string|max:255',
            'login' => 'string|max:255',
            'email' => 'string|email|max:255',
            'password' => 'max:255',
            'gender' => 'integer',
            'is_active' => 'integer',
            'departments_ids.*' => ['integer',Rule::exists('departments','id')],
            'role' => [Rule::exists('roles', 'slug')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        $data = $request->only($this->fillable);
        $data =array_filter($data, function ($value) {
            return !is_null($value);
        });
        return $this->usersService->edit($id, $data);
    }

    public function editView(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required','integer',Rule::exists('users','id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        return $this->usersService->editView($id);
    }

    public function addDepartment(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'departments_ids' => ['required', 'array'],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $userId = $request->user_id;
        $departmentsIds = $request->departments_ids;
        return $this->usersService->addDepartment($userId, $departmentsIds);
    }

    public function filter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => ['max:250'],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $data = $request->only($this->fillable);
        return $this->usersService->filter($data);
    }

    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'where_in.*' => ['integer', Rule::exists('users', 'id')],
            'email' => ['max:250'],
            'group' => 'max:250',
            'role' => [Rule::exists('roles', 'slug')],
            'is_active' => 'integer:in:0,1',
            'selected_departments.*' => ['integer', Rule::exists('departments', 'id')],
            'selected_years.*' => ['integer', Rule::exists('organizations_years', 'id')],
            'page' => 'integer',
            'paginate' => 'bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $you = Auth::user();
        $data = $request->only($this->fillable);
        Log::debug('request data = ' . print_r($data, true));
        $data['organization_id'] = $you->organization_id;

        return $this->usersService->search($data);
    }


    public function configureDepartments(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')],
            'departments_ids' => ['required', 'array'],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $userId = $request->user_id;
        $departmentsIds = $request->departments_ids;
        return $this->usersService->configureDepartments($userId, $departmentsIds);
    }


    public function userManagement()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        return $this->usersService->userManagement($organizationId);
    }

    public function generateApiKey(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'integer', Rule::exists('users', 'id')],
            'api_key' => 'required',
            'secret_key' => ['required', Rule::exists('users', 'secret_key')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        $apiKey = $request->api_key;
        $secretKey = $request->secret_key;
        return $this->usersService->generateApiKey($id, $apiKey, $secretKey);
    }

    public function apiView()
    {
        return $this->usersService->apiView();
    }

    public function teachersPortfoliosView()
    {
        return $this->usersService->teachersPortfoliosView();
    }

    public function studentsPortfoliosView()
    {
        return $this->usersService->studentsPortfoliosView();
    }


    public function teacherDepartmentsView()
    {
        return $this->usersService->teacherDepartmentsView();
    }

    public function mainPlatformView()
    {
        return $this->usersService->mainPlatformView();
    }

    public function openPortfolio(int $id)
    {
        Log::debug('Вошёл в openPortfolio');
        $validator = Validator::make(['id' => $id],[
            'id' => ['integer',Rule::exists('users','id')]
        ]);
        if($validator->fails())
        {
            return ValidatorHelper::redirectError($validator);
        }
        return $this->usersService->openPortfolio($id);

    }



}
