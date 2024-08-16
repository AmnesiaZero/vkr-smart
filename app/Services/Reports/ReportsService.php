<?php

namespace App\Services\Reports;

use App\Models\CustomRole;
use App\Models\User;
use App\Models\Work;
use App\Services\Decorations\Repositories\DecorationRepositoryInterface;
use App\Services\OrganizationsYears\Repositories\OrganizationYearRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\Works\Repositories\WorkRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;
use function Symfony\Component\Translation\t;

class ReportsService extends Services
{
    private OrganizationYearRepositoryInterface $yearRepository;

    private UserRepositoryInterface $userRepository;

    private WorkRepositoryInterface $workRepository;



    public function __construct(OrganizationYearRepositoryInterface $yearRepository,
                                UserRepositoryInterface $userRepository, WorkRepositoryInterface $workRepository
       )
    {
        $this->yearRepository = $yearRepository;
        $this->userRepository = $userRepository;
        $this->workRepository = $workRepository;
    }

    public function pqgeView()
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
        $users = User::with($relations);

        $query = Role::query()->whereNotIn('slug',['default']);
        $roles = $query->get();

        // Запрос на получение пользователей, связанных с ролями, удовлетворяющих условиям фильтрации
        $usersQuery = User::with('achievements.records')
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
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
        if (isset($data['year_id'])) {
            $usersQuery =   $usersQuery->where('users.year_id', $data['year_id']);
            $users =  $users->where('users.year_id', $data['year_id']);
        }
        if (isset($data['faculty_id'])) {
            $usersQuery =  $usersQuery->where('users.faculty_id','=', $data['faculty_id']);
            $users = $users->where('users.faculty_id','=', $data['faculty_id']);
        }
        if (isset($data['department_id'])) {
            $usersQuery =  $usersQuery->where('users.department_id','=', $data['department_id']);
            $users = $users->where('users.department_id','=', $data['department_id']);
        }
        $users = $users->get();

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

        $query = Role::query()->whereIn('slug',['teacher','admin','employee','user']); //Здесь подгружаем у работ всю работу для фильтрации
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
                'works.department_id',
                'works.work_status'
            );

// Применение фильтров
//        if (isset($data['organization_id'])) {
//            $worksQuery->where('works.organization_id', $data['organization_id']);
//        }


        if (isset($data['year_id'])) {
            $worksQuery->where('works.year_id','=', $data['year_id']);
        }
        if (isset($data['faculty_id'])) {
            $worksQuery->where('works.faculty_id','=', $data['faculty_id']);
        }
        if (isset($data['department_id'])) {
            $worksQuery->where('works.department_id','=', $data['department_id']);
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
                'work_status' => $result->work_status
            ];
        }


// Преобразование в массив для более удобного использования
        $rolesWorks = array_values($rolesWorks);




        $query = Role::query()->whereIn('slug',['teacher','admin','employee','user']);
        $achievementsQuery = $query
            ->leftJoin('role_user', 'roles.id', '=', 'role_user.role_id')
            ->leftJoin('users', 'role_user.user_id', '=', 'users.id')
            ->where('users.organization_id', '=', $organizationId)
            ->leftJoin('achievements','users.id','=','achievements.user_id')
            ->leftJoin('achievements_records', 'achievements.id', '=', 'achievements_records.achievement_id')  // изменено соединение
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'users.id as user_id',
                'users.name as user_name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id',
//                'achievements.id as achievement_id',
//                'achievements_records.id as record_id',
                DB::raw('COUNT(DISTINCT achievements.id) as achievements_count'),
                DB::raw('COUNT(achievements_records.id) as records_count')
            ) ->groupBy(
                'roles.id',
                'roles.name',
                'users.id',
                'users.name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id'
            );;
        if (isset($data['year_id'])) {
                $query->where('year_id','=',$data['year_id']);
        }
        if (isset($data['faculty_id'])) {
            $query->where('faculty_id','=',$data['faculty_id']);
        }
        if (isset($data['department_id'])) {
            $query->where('department_id','=',$data['department_id']);
        }

        $results = $achievementsQuery->get();

        Log::debug('achievements results = '.print_r($results,true));

        // Группировка пользователей по ролям
        $rolesAchievements = [];
        foreach ($results as $result) {
            if (!isset($rolesAchievements[$result->role_id])) {
                $rolesAchievements[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'achievements_count' => 0,
                    'records_count' => 0
                ];
            }

            // Увеличиваем количество достижений и записей
            $rolesAchievements[$result->role_id]['achievements_count'] += $result->achievements_count;
            $rolesAchievements[$result->role_id]['records_count'] += $result->records_count;
        }


        $rolesAchievements = array_values($rolesAchievements);



        $worksQuery = Work::query();

        if(isset($data['organization_id']))
        {
            $worksQuery = $worksQuery->where('organization_id','=',$organizationId);
        }
        if(isset($data['year_id']))
        {
            $worksQuery = $worksQuery->where('year_id','=',$data['year_id']);
        }
        if(isset($data['faculty_id']))
        {
            $worksQuery = $worksQuery->where('faculty_id','=',$data['faculty_id']);
        }
        if(isset($data['department_id']))
        {
            $worksQuery = $worksQuery->where('department_id','=',$data['department_id']);
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




