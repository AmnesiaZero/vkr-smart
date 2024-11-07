<?php

namespace App\Services\Reports;

use App\Models\CustomRole;
use App\Models\User;
use App\Services\Decorations\Repositories\DecorationRepositoryInterface;
use App\Services\Years\Repositories\YearRepositoryInterface;
use App\Services\Services;
use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\Works\Repositories\WorkRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;

class ReportsService extends Services
{
    private YearRepositoryInterface $yearRepository;

    private UserRepositoryInterface $userRepository;

    private WorkRepositoryInterface $workRepository;


    public function __construct(YearRepositoryInterface $yearRepository,
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
        return view('templates.dashboard.report', [
            'years' => $years
        ]);
    }

    public function get(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;

        // Запрос на получение пользователей, связанных с ролями, удовлетворяющих условиям фильтрации
        $usersQuery = User::query()
            ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
            ->whereIn('roles.slug', ['teacher', 'admin', 'employee', 'user', 'inspector'])
            ->where('users.organization_id', '=', $organizationId)
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'users.id as user_id',
                'users.name as user_name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id',
                'roles.slug as slug',
                DB::raw('COUNT(DISTINCT users.id) as users_count'),
            )->groupBy(
                'roles.id',
                'roles.name',
                'users.id',
                'users.name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id',
                'roles.slug',
            );

        if (isset($data['year_id'])) {
            $usersQuery->where('users.year_id', '=', $data['year_id']);
        }
        if (isset($data['faculty_id'])) {
            $usersQuery->where('users.faculty_id', '=', $data['faculty_id']);
        }
        if (isset($data['department_id'])) {
            $usersQuery->where('users.department_id', '=', $data['department_id']);
        }

        $results = $usersQuery->get();

        // Группировка пользователей по ролям
        $rolesUsers = [];

        $rolesUsers['all_users'] = 0;

        foreach ($results as $result) {
            if (!isset($rolesUsers[$result->role_id])) {
                $rolesUsers[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'slug' => $result->slug,
                    'users_count' => 0
                ];
            }
            $rolesUsers[$result->role_id]['users_count'] += $result->users_count;

            $rolesUsers['all_users'] += $result->users_count;
        }
        $rolesUsers = array_values($rolesUsers);

        $query = Role::query()->whereIn('slug', ['teacher', 'admin', 'employee', 'user']); //Здесь подгружаем у работ всю инфу для фильтрации
        $worksQuery = $query
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->where('works.organization_id', '=', $organizationId)
            ->join('works', 'users.id', '=', 'works.user_id')
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'roles.slug as slug',
                'works.organization_id',
                'works.year_id',
                'works.faculty_id',
                'works.department_id',
                'works.work_status as work_status',
                DB::raw('COUNT(DISTINCT works.id) as works_count'),
            )
            ->groupBy(
                'roles.id',
                'roles.slug',
                'roles.name',
                'works.organization_id',
                'works.year_id',
                'works.faculty_id',
                'works.department_id',
                'works.work_status',
            );

        if (isset($data['year_id'])) {
            $worksQuery->where('works.year_id', '=', $data['year_id']);
        }
        if (isset($data['faculty_id'])) {
            $worksQuery->where('works.faculty_id', '=', $data['faculty_id']);
        }
        if (isset($data['department_id'])) {
            $worksQuery->where('works.department_id', '=', $data['department_id']);
        }

        $results = $worksQuery->get();
        $rolesWorks = [];

        $rolesWorks['all_works'] = 0;
        foreach ($results as $result) {
            if (!isset($rolesWorks[$result->role_id])) {
                $rolesWorks[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'slug' => $result->slug,
                    'works_count' => 0,
                    'work_wait' => 0,
                    'work_approved' => 0,
                    'work_denied' => 0
                ];
            }
            $array = [
                0 => 'work_wait',
                1 => 'work_approved',
                2 => 'work_denied',
            ];
            foreach ($array as $key => $value) {
                if ($result->slug == 'user' and $result->work_status == $key) {
                    $rolesWorks[$result->role_id][$value] += $result->works_count;
                }
            }
            $rolesWorks[$result->role_id]['works_count'] += $result->works_count;
            $rolesWorks['all_works'] += $result->works_count;;


        }


// Преобразование в массив для более удобного использования
        $rolesWorks = array_values($rolesWorks);


        $query = Role::query()->whereIn('slug', ['teacher', 'admin', 'employee', 'user']);
        $achievementsQuery = $query
            ->leftJoin('role_user', 'roles.id', '=', 'role_user.role_id')
            ->leftJoin('users', 'role_user.user_id', '=', 'users.id')
            ->where('users.organization_id', '=', $organizationId)
            ->leftJoin('achievements', 'users.id', '=', 'achievements.user_id')
            ->leftJoin('achievements_records', 'achievements.id', '=', 'achievements_records.achievement_id')  // изменено соединение
            ->select(
                'roles.id as role_id',
                'roles.name as role_name',
                'roles.slug as slug',
                'users.id as user_id',
                'users.name as user_name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id',
                DB::raw('COUNT(DISTINCT achievements.id) as achievements_count'),
                DB::raw('COUNT(achievements_records.id) as records_count')
            )->groupBy(
                'roles.id',
                'roles.slug',
                'roles.name',
                'users.id',
                'users.name',
                'users.organization_id',
                'users.year_id',
                'users.faculty_id',
                'users.department_id'
            );
        if (isset($data['year_id'])) {
            $query->where('year_id', '=', $data['year_id']);
        }
        if (isset($data['faculty_id'])) {
            $query->where('faculty_id', '=', $data['faculty_id']);
        }
        if (isset($data['department_id'])) {
            $query->where('department_id', '=', $data['department_id']);
        }

        $results = $achievementsQuery->get();


        // Группировка пользователей по ролям
        $rolesAchievements = [];

        foreach ($results as $result) {
            if (!isset($rolesAchievements[$result->role_id])) {
                $rolesAchievements[$result->role_id] = [
                    'role_id' => $result->role_id,
                    'role_name' => $result->role_name,
                    'slug' => $result->slug,
                    'achievements_count' => 0,
                    'records_count' => 0
                ];
            }

            // Увеличиваем количество достижений и записей
            $rolesAchievements[$result->role_id]['achievements_count'] += $result->achievements_count;
            $rolesAchievements[$result->role_id]['records_count'] += $result->records_count;
        }


        $rolesAchievements = array_values($rolesAchievements);

        return self::sendJsonResponse(true, [
            'title' => 'Успешно получена статистика',
            'roles_users' => $rolesUsers,
            'roles_works' => $rolesWorks,
            'roles_achievements' => $rolesAchievements,
        ]);


//        if($rolesUsers and $rolesWorks and $rolesAchievements)
//        {
//            return self::sendJsonResponse(true,[
//                'title' => 'Успешно получена статистика',
//                'roles_users' => $rolesUsers,
//                'roles_works' => $rolesWorks,
//                'roles_achievements' => $rolesAchievements,
//            ]);
//        }
//        return self::sendJsonResponse(false,[
//            'title' => 'Ошибка',
//            'message' => 'При получении статистики произошла ошибка'
//        ]);
    }

}




