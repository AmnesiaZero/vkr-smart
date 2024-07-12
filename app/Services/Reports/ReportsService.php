<?php

namespace App\Services\Reports;

use App\Models\CustomRole;
use App\Models\User;
use App\Models\Work;
use App\Services\OrganizationsYears\Repositories\OrganizationYearRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\Works\Repositories\WorkRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;
use function Symfony\Component\Translation\t;

class ReportsService extends Services
{
    private OrganizationYearRepositoryInterface $yearRepository;

    private UserRepositoryInterface $userRepository;

    private WorkRepositoryInterface $workRepository;


    public function __construct(OrganizationYearRepositoryInterface $yearRepository,
                                UserRepositoryInterface $userRepository,WorkRepositoryInterface $workRepository)
    {
        $this->yearRepository = $yearRepository;
        $this->userRepository = $userRepository;
        $this->workRepository = $workRepository;
    }

    public function view()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $years = $this->yearRepository->get($organizationId);
        return view('templates.dashboard.report',[
            'years' => $years
        ]);
    }

    public function get(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $data['organization_id'] = $organizationId;
        $relations = ['works','achievements'];
        $users = $this->userRepository->search($data,$relations);
        $query = Role::query()->whereIn('slug',['teacher','admin','employee','user']);
        $roles = $query->get();

        // Запрос на получение пользователей, связанных с ролями, удовлетворяющих условиям фильтрации
        $usersQuery = User::with('achievements.records')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->whereIn('roles.slug', ['teacher', 'admin', 'employee', 'user'])
            ->where('users.organization_id', '=', $organizationId)
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'users.id as user_id',
                'users.name as user_name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id'
            );

        // Применение фильтров
        if (isset($data['selected_years'])) {
            $usersQuery->whereIn('users.year_id', $data['selected_years']);
        }
        if (isset($data['selected_faculties'])) {
            $usersQuery->whereIn('users.faculty_id', $data['selected_faculties']);
        }
        if (isset($data['selected_departments'])) {
            $usersQuery->whereIn('users.department_id', $data['selected_departments']);
        }

        $results = $usersQuery->get();

        // Группировка пользователей по ролям
        $rolesUsers = [];
        foreach ($results as $result) {
            if (!isset($rolesUsers[$result->role_id])) {
                $rolesUsers[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'users' => []
                ];
            }
            $rolesUsers[$result->role_id]['users'][] = [
                'user_id' => $result->user_id,
                'user_name' => $result->user_name,
                'organization_id' => $result->organization_id,
                'year_id' => $result->year_id,
                'faculty_id' => $result->faculty_id,
                'department_id' => $result->department_id,
            ];
        }
        $rolesUsers = array_values($rolesUsers);

        $query = Role::query()->whereIn('slug',['teacher','admin','employee','user']);
        $worksQuery = $query
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->where('works.organization_id','=',$organizationId)
            ->join('works', 'users.id', '=', 'works.user_id')
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'users.id as user_id',
                'users.name as user_name',
                'works.id as work_id',
                'works.organization_id',
                'works.year_id',
                'works.faculty_id',
                'works.department_id'
            );

// Применение фильтров
//        if (isset($data['organization_id'])) {
//            $worksQuery->where('works.organization_id', $data['organization_id']);
//        }


        if (isset($data['selected_years'])) {
            $worksQuery->whereIn('works.year_id', $data['selected_years']);
        }
        if (isset($data['selected_faculties'])) {
            $worksQuery->whereIn('works.faculty_id', $data['selected_faculties']);
        }
        if (isset($data['selected_departments'])) {
            $worksQuery->whereIn('works.department_id', $data['selected_departments']);
        }

        $results = $worksQuery->get();
        $rolesWorks = [];
        foreach ($results as $result) {
            if (!isset($rolesWorks[$result->role_id])) {
                $rolesWorks[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'works' => []
                ];
            }
            $rolesWorks[$result->role_id]['works'][] = [
                'work_id' => $result->work_id,
                'organization_id' => $result->organization_id,
                'year_id' => $result->year_id,
                'faculty_id' => $result->faculty_id,
                'department_id' => $result->department_id,
            ];
        }


// Преобразование в массив для более удобного использования
        $rolesWorks = array_values($rolesWorks);







        // Запрос на получение пользователей, связанных с ролями, удовлетворяющих условиям фильтрации
        $achievementsQuery = User::query()
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->whereIn('roles.slug', ['teacher', 'admin', 'employee', 'user'])
            ->where('users.organization_id', '=', $organizationId)
            ->join('achievements','user_id','=','achievements.user_id')
            ->join('achievements_records','achievement_id','=','achievements_records.achievement_id')
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'users.id as user_id',
                'users.name as user_name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id',
                'achievements.id',
                'achievements_records.id'
            );

        // Применение фильтров
        if (isset($data['selected_years'])) {
            $achievementsQuery->whereIn('achievements.year_id', $data['selected_years']);
        }
        if (isset($data['selected_faculties'])) {
            $achievementsQuery->whereIn('achievements.faculty_id', $data['selected_faculties']);
        }
        if (isset($data['selected_departments'])) {
            $achievementsQuery->whereIn('achievements.department_id', $data['selected_departments']);
        }

        $results = $achievementsQuery->get();

        // Группировка пользователей по ролям
        $rolesAchievements = [];
        foreach ($results as $result) {
            if (!isset($rolesAchievements[$result->role_id])) {
                $rolesAchievements[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'achievements' => []
                ];
            }
            $rolesAchievements[$result->role_id]['achievements'][] = [
                'user_id' => $result->user_id,
                'user_name' => $result->user_name,
                'organization_id' => $result->organization_id,
                'year_id' => $result->year_id,
                'faculty_id' => $result->faculty_id,
                'department_id' => $result->department_id,
                'achievement_id' => $result->achievement_id,
                'achievement_record_id'=> $result->achievement_record_id
            ];
        }
        $rolesAchievements = array_values($rolesAchievements);






























        $worksQuery = Work::query();

        Log::debug('roles works = '.print_r($rolesWorks,true));

        if(isset($data['organization_id']))
        {
            $worksQuery = $worksQuery->where('organization_id','=',$organizationId);
        }
        if(isset($data['selected_years']))
        {
            $worksQuery = $worksQuery->whereIn('year_id',$data['selected_years']);
        }
        if(isset($data['selected_faculties']))
        {
            $worksQuery = $worksQuery->whereIn('faculty_id',$data['selected_faculties']);
        }
        if(isset($data['selected_departments']))
        {
            $worksQuery = $worksQuery->whereIn('department_id',$data['selected_departments']);
        }
        $works = $worksQuery->get();
        if($users and is_iterable($users) and $roles and is_iterable($roles))
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно получена статистика',
                'users' => $users,
                'roles_users' => $rolesUsers,
                'roles_works' => $rolesWorks,
                'roles_achievements' => $rolesAchievements,
                'works' => $works
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'При получении статистики произошла ошибка'
        ]);
    }

}




