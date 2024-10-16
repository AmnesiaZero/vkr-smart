<?php

namespace App\Services\Departments;

use App\Models\Department;
use App\Models\Organization;
use App\Services\Departments\Repositories\DepartmentRepositoryInterface;
use App\Services\Faculties\Repositories\FacultyRepositoryInterface;
use App\Services\Organizations\Repositories\OrganizationRepositoryInterface;
use App\Services\Years\Repositories\YearRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DepartmentsService extends Services
{

    public OrganizationRepositoryInterface $organizationRepository;

    public DepartmentRepositoryInterface $departmentRepository;

    public FacultyRepositoryInterface $facultyRepository;

    public YearRepositoryInterface $yearRepository;

    public UserRepositoryInterface $userRepository;


    public function __construct(
        DepartmentRepositoryInterface   $departmentRepository,
        FacultyRepositoryInterface      $facultyRepository,
        UserRepositoryInterface         $userRepository,
        YearRepositoryInterface         $yearRepository,
        OrganizationRepositoryInterface $organizationRepository
    )
    {
        $this->departmentRepository = $departmentRepository;
        $this->facultyRepository = $facultyRepository;
        $this->userRepository = $userRepository;
        $this->yearRepository = $yearRepository;
        $this->organizationRepository = $organizationRepository;
    }

    public function getByYearId(int $yearId): Collection
    {
        return $this->departmentRepository->getByYearId($yearId);
    }

    public function edit(int $id, array $data)
    {
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }

        $result = $this->departmentRepository->update($id, $data);
        if ($result) {
            $you = Auth::user();
            if (isset($data['redirect'])) {
                return redirect('/dashboard/platform/organizations/departments');
            }
            $department = $this->departmentRepository->find($id);
            return view('templates.dashboard.platform.organization.departments.edit', [
                'department' => $department,
                'you' => $you
            ]);
        }
        return back()->withErrors(['Ошибка при обновлении подразделения']);
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
        if ($department and $department->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успех',
                'department' => $department
            ]);
        }
        return self::sendJsonResponse(false, [
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

    public function view(array $data)
    {
        $you = Auth::user();
        $organizations = $this->organizationRepository->get($data);
        $additionalData = [
            'with_trashed' => true,
            'paginate' => true,
        ];
        $data = array_merge($data, $additionalData);
        if (!isset($data['page'])) {
            $data['page'] = 1;
        }
        $departments = $this->departmentRepository->get($data);
        if ($organizations and $departments) {
            return view('templates.dashboard.platform.organization.departments.index', [

                'organizations' => $organizations,
                'departments' => $departments
            ]);
        }
        return back()->withErrors(['Возникла ошибка при получении организаций и департаментов']);
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

    public function editView(int $id)
    {
        $department = $this->departmentRepository->find($id);
        $you = Auth::user();
        if ($department and $department->id) {
            return view('templates.dashboard.platform.organization.departments.edit', [
                'department' => $department,
                'you' => $you
            ]);
        }
        return back()->withErrors(['Возникла ошибка при получении данного подразделения']);
    }

    public function search(array $data): JsonResponse
    {
        $departments = $this->departmentRepository->search($data);
        if ($departments and is_iterable($departments)) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'departments' => $departments
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске подразделений'
        ]);
    }

    public function addView()
    {
        $you = Auth::user();
        $organizations = Organization::all();
        return view('templates.dashboard.platform.organization.departments.create', [

            'organizations' => $organizations
        ]);
    }

    public function all(): JsonResponse
    {
        $departments = Department::all();
        if ($departments and is_iterable($departments)) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'departments' => $departments
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении подразделений'
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

            if (isset($data['redirect'])) {
                return redirect('/dashboard/platform/organizations/departments');
            }
            return view('templates.dashboard.platform.organization.departments.create', [
                'department' => $department,
                'you' => $you
            ]);
        }
        return back()->withErrors(['Ошибка при создании департамента']);
    }

    public function create(array $data): JsonResponse
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        if (!isset($data['organization_id'])) {
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

    public function updateStatus(int $id): JsonResponse
    {
        $department = $this->departmentRepository->find($id);
        if ($department and $department->id) {
            $isBlocked = $department->is_blocked;
            if ($isBlocked == 0) {
                $department->is_blocked = 1;
            } else {
                $department->is_blocked = 0;
            }
            $department->save();
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'department' => $department
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при обновлении статуса подразделения'
        ]);
    }


    public function destroy(int $id): JsonResponse
    {
        $result = $this->departmentRepository->destroy($id);
        if ($result) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно удален'
            ]);
        } else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при удалении департамента из базы данных'
            ]);
        }
    }

    public function restore(int $id): JsonResponse
    {
        $result = $this->departmentRepository->restore($id);
        if ($result) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Данный элемент был успешно восстановлен'
            ]);
        } else {
            return self::sendJsonResponse(false, [
                'title' => 'Ошибка',
                'message' => 'Возникла ошибка при восстановлении'
            ]);
        }
    }


}
