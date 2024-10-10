<?php

namespace App\Services\Achievements;

use App\Models\AchievementMode;
use App\Models\AchievementTypeCategory;
use App\Services\Achievements\Repositories\AchievementRepositoryInterface;
use App\Services\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AchievementsService extends Services
{
    private AchievementRepositoryInterface $achievementRepository;

    public function __construct(AchievementRepositoryInterface $achievementRepository)
    {
        $this->achievementRepository = $achievementRepository;
    }


    public function youAchievementsView()
    {
        $modes = AchievementMode::all();
        $categories = AchievementTypeCategory::with('achievementsTypes')->get();
        return view('templates.dashboard.portfolios.you', [
            'categories' => $categories,
            'modes' => $modes
        ]);
    }

    public function get(int $userId): JsonResponse
    {
        $achievements = $this->achievementRepository->get($userId);
        if ($achievements and is_iterable($achievements)) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'achievements' => $achievements
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении достижений'
        ]);
    }

    public function view()
    {
        $modes = AchievementMode::all();
        $categories = AchievementTypeCategory::with('achievementsTypes')->get();
        return view('templates.dashboard.portfolios.achievements', [
            'categories' => $categories,
            'modes' => $modes
        ]);
    }

    public function create(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        if (isset($organizationId) and is_numeric($organizationId)) {
            $data['organization_id'] = $organizationId;
        }
        $achievement = $this->achievementRepository->create($data);
        if ($achievement and $achievement->id) {
            $achievement = $achievement->load('mode');
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'achievement' => $achievement
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при создании достижения'
        ]);
    }


    public function find(int $id): JsonResponse
    {
        $achievement = $this->achievementRepository->find($id);
        if ($achievement and $achievement->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'achievement' => $achievement
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске достижения'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->achievementRepository->delete($id);
        if ($flag) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Достижение было успешно удалено'
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при поиске достижения'
        ]);
    }

    public function search(array $data): JsonResponse
    {
        $achievements = $this->achievementRepository->search($data);
        if ($achievements and is_iterable($achievements)) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'achievements' => $achievements
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при поиске достижений'
        ]);
    }

}
