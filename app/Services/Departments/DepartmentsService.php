<?php

namespace App\Services\Departments;

use App\Helpers\JsonHelper;
use App\Models\Department;
use App\Models\Organization;
use App\Services\Departments\Repositories\DepartmentRepositoryInterface;
use App\Services\Faculties\Repositories\FacultyRepositoryInterface;
use App\Services\OrganizationsYears\Repositories\OrganizationYearRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DepartmentsService extends Services
{
    public DepartmentRepositoryInterface $departmentRepository;

    public FacultyRepositoryInterface $facultyRepository;

    public OrganizationYearRepositoryInterface $yearRepository;

    public UserRepositoryInterface $userRepository;


    public function __construct(
        DepartmentRepositoryInterface       $departmentRepository,
        FacultyRepositoryInterface          $facultyRepository,
        UserRepositoryInterface             $userRepository,
        OrganizationYearRepositoryInterface $yearRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->facultyRepository = $facultyRepository;
        $this->userRepository = $userRepository;
        $this->yearRepository = $yearRepository;
    }

    public function create(array $data): JsonResponse
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        if(!isset($data['organization_id']))
        {
            $data['organization_id'] = $user->organization_id;
        }
        if (!isset($data['faculty_id'])) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'При создании кафедры не указан id факультета'
            ]);
        }
        $yearId = $this->facultyRepository->getYearId($data['faculty_id']);
        $data = array_merge($data, ['year_id' => $yearId]);
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ]);
        }
        $department = $this->departmentRepository->create($data);
        Log::debug('department = ' . $department);
        if ($department and $department->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Кафедра успешно создана',
                'department' => $department
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При сохранении данных произошла  ошибка'
        ], 403);
    }


    public function get(array $data): JsonResponse
    {
        $departments = $this->departmentRepository->get($data);
        Log::debug('departments = ' . $departments);
        return self::sendJsonResponse(true, [
            'title' => 'Успешно получены кафедры',
            'departments' => $departments
        ]);
    }

    public function getByYearId(int $yearId): Collection
    {
        return $this->departmentRepository->getByYearId($yearId);
    }

    public function update(int $id, array $data): JsonResponse
    {
        if (empty($data)) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Пустой массив данных'
            ]);
        }

        $result = $this->departmentRepository->update($id, $data);

        if ($result) {
            $department = $this->departmentRepository->find($id);
            return self::sendJsonResponse(true, [
                'title' => 'Успех',
                'message' => 'Информация успешно сохранена',
                'department' => $department
            ]);
        }
        else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'При сохранении данных произошла ошибка',
                'id' => $result->id
            ]);
        }
    }

    public function edit(int $id, array $data)
    {
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }

        $result = $this->departmentRepository->update($id,$data);
        if($result)
        {
            $you = Auth::user();
            if(isset($data['redirect']))
            {
                return redirect('/dashboard/platform/organizations/departments');
            }
            $department = $this->departmentRepository->find($id);
            return view('templates.dashboard.platform.organization.departments.edit',[
                'department' => $department,
                'user' => $you
            ]);
        }
        return back()->withErrors(['Ошибка при обновлении подразделения']);
    }

    public function find(int $id): JsonResponse
    {
        $department = $this->departmentRepository->find($id);
        if($department and $department->id)
        {
            return self::sendJsonResponse(true, [
                'title' => 'Успех',
                'department' => $department
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Данного подразделения не существует'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $result = $this->departmentRepository->delete($id);


        if ($result) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Кафедра удалена успешно'
            ]);
        } else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Ошибка при удалении из базы данных'
            ]);
        }
    }

    public function getByUserId(int $userId): JsonResponse
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Некорректный пользователь'
            ]);
        }
        $departments = $user->departments;
        return self::sendJsonResponse(true, [
            'title' => 'Успешно',
            'departments' => $departments
        ]);
    }

    public function getProgramSpecialties(int $id): JsonResponse
    {
        $programSpecialties = $this->departmentRepository->getProgramSpecialties($id);
        if ($programSpecialties) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'program_specialties' => $programSpecialties,
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При получении специальностей произошла ошибка',
        ]);
    }

    public function view()
    {
        $you = Auth::user();
        $organizations = Organization::all();
        $departments = Department::all();
        return view('templates.dashboard.platform.organization.departments.index',[
            'user' => $you,
            'organizations' => $organizations,
            'departments' => $departments
        ]);
    }

    public function all(): JsonResponse
    {
        $departments = Department::all();
        if($departments and is_iterable($departments))
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'departments' => $departments
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении подразделений'
        ]);
    }

    public function editView(int $id)
    {
        $department = $this->departmentRepository->find($id);
        $you = Auth::user();
        if($department and $department->id)
        {
            return view('templates.dashboard.platform.organization.departments.edit',[
                'department' => $department,
                'user' => $you
            ]);
        }
        return back()->withErrors(['Возникла ошибка при получении данного подразделения']);
    }

    public function search(array $data): JsonResponse
    {
        $departments = $this->departmentRepository->search($data);
        if($departments and is_iterable($departments))
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'departments' => $departments
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске подразделений'
        ]);
    }

    public function addView()
    {
        $you = Auth::user();
        $organizations = Organization::all();
        return view('templates.dashboard.platform.organization.departments.create',[
            'user' => $you,
            'organizations' => $organizations
        ]);
    }

    public function store(array $data)
    {
        $you = Auth::user();
        $data['user_id'] = $you->id;
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }
        $department = $this->departmentRepository->create($data);
        if ($department and $department->id) {

            if(isset($data['redirect']))
            {
                return redirect('/dashboard/platform/departments');
            }
            return view('templates.dashboard.platform.organization.departments.create',[
                'department' => $department,
                'user' => $you
            ]);
        }
        return back()->withErrors(['Ошибка при создании департамента']);
    }


}
