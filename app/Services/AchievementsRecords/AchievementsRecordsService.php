<?php

namespace App\Services\AchievementsRecords;

use App\Helpers\JsonHelper;
use App\Services\AchievementsRecords\Repositories\AchievementRecordRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AchievementsRecordsService
{

    private AchievementRecordRepositoryInterface $achievementRecordRepository;

    public function __construct(AchievementRecordRepositoryInterface $achievementRecordRepository)
    {
        $this->achievementRecordRepository = $achievementRecordRepository;
    }

    public function create(array $data):JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $data['organization_id'] = $organizationId;
        $achievementRecord = $this->achievementRecordRepository->create($data);
        if($achievementRecord and $achievementRecord->id)
        {
            $additionalData = [];
            $id = $achievementRecord->id;
            if(isset($data['file']))
            {
                $file = $data['file'];
                $directory = ceil($id/1000);
                $path = 'achievements_records/'.$directory;
                Storage::makeDirectory($path);
                Storage::put($path,$file);
                $additionalData['content'] = $path;
            }
            $result = $this->achievementRecordRepository->update($id,$additionalData);
            $updatedAchievementRecord = $this->achievementRecordRepository->find($id);
            if($result and $updatedAchievementRecord and $updatedAchievementRecord->id)
            {
                return JsonHelper::sendJsonResponse(true,[
                    'title' => 'Успешно',
                    'achievement_record' => $updatedAchievementRecord
                ]);
            }
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при создании записи'
        ]);
    }

    public function get(int $achievementId): JsonResponse
    {
        $achievementsRecords = $this->achievementRecordRepository->get($achievementId);
        if($achievementsRecords and is_iterable($achievementsRecords))
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'achievements_records' => $achievementsRecords
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении записей достижений'
        ]);
    }
}
