<?php

namespace App\Services\AchievementsRecords;

use App\Helpers\JsonHelper;
use App\Services\AchievementsRecords\Repositories\AchievementRecordRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                Log::debug('Вошёл в условие file');
                $file = $data['file'];
                $directoryNumber = ceil($id/1000);
                $directory = 'achievements_records/'.$directoryNumber;
                Storage::makeDirectory($directory);
                $fileName = $id.'.'.$file->extension();
                $path = $file->storeAs($directory,$fileName);
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

    public function find(int $id): JsonResponse
    {
        $achievementRecord = $this->achievementRecordRepository->find($id);
        if($achievementRecord and $achievementRecord->id)
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'achievement_record' => $achievementRecord
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении записи достижения'
        ]);
    }
}
