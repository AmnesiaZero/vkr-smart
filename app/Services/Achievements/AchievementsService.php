<?php

namespace App\Services\Achievements;

use App\Helpers\JsonHelper;
use App\Services\Achievements\Repositories\AchievementRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AchievementsService
{
    private AchievementRepositoryInterface $achievementRepository;

    public function __construct(AchievementRepositoryInterface $achievementRepository)
    {
        $this->achievementRepository = $achievementRepository;
    }

    public function create(array $data): JsonResponse
    {
        $achievement = $this->achievementRepository->create($data);
        if($achievement and $achievement->id)
        {
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
}
