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
        $facultyDepartment = $this->departmentRepository->create($data);
        Log::debug('department = ' . $facultyDepartment);
        if ($facultyDepartment and $facultyDepartment->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Кафедра успешно создана',
                'department' => $facultyDepartment
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'При сохранении данных произошла  ошибка'
        ], 403);
    }

    public function getModels(int $facultyId): Collection
    {
        return $this->departmentRepository->get($facultyId);

    }

    public function get(int $facultyId): JsonResponse
    {
        $facultyDepartments = $this->departmentRepository->get($facultyId);
        Log::debug('departments = ' . $facultyDepartments);
        return self::sendJsonResponse(true, [
            'title' => 'Успешно получены кафедры',
            'departments' => $facultyDepartments
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
            $facultyDepartment = Department::query()->find($id);
            return self::sendJsonResponse(true, [
                'title' => 'Успех',
                'message' => 'Информация успешно сохранена',
                'department' => $facultyDepartment
            ]);
        } else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'При сохранении данных произошла ошибка',
                'id' => $result->id
            ]);
        }
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

    public function updateView(int $id)
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


}
