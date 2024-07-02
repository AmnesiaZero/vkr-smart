<?php

namespace App\Services\Achievements;

use App\Helpers\JsonHelper;
use App\Services\Achievements\Repositories\AchievementRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AchievementsService
{
    private AchievementRepositoryInterface $achievementRepository;

    public function __construct(AchievementRepositoryInterface $achievementRepository)
    {
        $this->achievementRepository = $achievementRepository;
    }

    public function get(int $userId): JsonResponse
    {
        $achievements = $this->achievementRepository->get($userId);
        if($achievements and is_iterable($achievements))
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'achievements' => $achievements
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении достижений'
        ]);
    }

    public function create(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        if(isset($organizationId) and is_numeric($organizationId))
        {
            $data['organization_id'] = $organizationId;
        }
        $achievement = $this->achievementRepository->create($data);
        if($achievement and $achievement->id)
        {
            $achievement =  $achievement->load('mode');
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'achievement' => $achievement
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при создании достижения'
        ]);
    }

    public function view(int $userId)
    {
        $achievements = $this->achievementRepository->get($userId);
        if($achievements and is_iterable($achievements))
        {
            return view('templates.dashboard.portfolio.achievements',['achievements' => $achievements]);
        }
        return back()->withErrors('Ошибка при получении достижений');
    }

    public function find(int $id): JsonResponse
    {
        $achievement = $this->achievementRepository->find($id);
        if($achievement and $achievement->id)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'achievement' => $achievement
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске достижения'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->achievementRepository->delete($id);
        if($flag)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Достижение было успешно удалено'
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске достижения'
        ]);
    }
}
