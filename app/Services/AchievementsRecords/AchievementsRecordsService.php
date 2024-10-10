<?php

namespace App\Services\AchievementsRecords;

use App\Services\AchievementsRecords\Repositories\AchievementRecordRepositoryInterface;
use App\Services\Services;
use App\Services\Works\Repositories\WorkRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AchievementsRecordsService extends Services
{

    private AchievementRecordRepositoryInterface $achievementRecordRepository;

    private WorkRepositoryInterface $workRepository;


    public function __construct(AchievementRecordRepositoryInterface $achievementRecordRepository, WorkRepositoryInterface $workRepository)
    {
        $this->achievementRecordRepository = $achievementRecordRepository;
        $this->workRepository = $workRepository;

    }

    public function create(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $data['organization_id'] = $organizationId;
        $achievementRecord = $this->achievementRecordRepository->create($data);
        if ($achievementRecord and $achievementRecord->id) {
            Log::debug('Вошёл в условие create');
            $additionalData = [];
            $id = $achievementRecord->id;
            if (isset($data['achievement_file'])) {
                Log::debug('Вошёл в условие file');
                $file = $data['achievement_file'];
                $directoryNumber = ceil($id / 1000);
                $directory = 'achievements_records/' . $directoryNumber;
                Storage::makeDirectory($directory);
                $fileName = $id . '.' . $file->extension();
                $path = $file->storeAs($directory, $fileName);
                $additionalData['content'] = $path;
            }
            if (isset($data['work_id'])) {
                Log::debug('Вошёл в условие work_id');
                $work = $this->workRepository->find($id);
                if ($work and $work->id) {
                    $path = $work->path;
                    Log::debug('path = ' . $path);
                    if (isset($path) and Storage::exists($path)) {
                        $name = $work->name;
                        $additionalData = array_merge($additionalData, [
                            'name' => $name,
                            'content' => $path
                        ]);
                    } else {
                        return self::sendJsonResponse(false, [
                            'title' => 'Ошибка',
                            'message' => 'Файл работы не найден'
                        ]);
                    }
                } else {
                    return self::sendJsonResponse(false, [
                        'title' => 'Ошибка',
                        'message' => 'Запись работы не найдена'
                    ]);
                }
            }
            $result = $this->achievementRecordRepository->update($id, $additionalData);
            $updatedAchievementRecord = $this->achievementRecordRepository->find($id);
            if ($result and $updatedAchievementRecord and $updatedAchievementRecord->id) {
                return self::sendJsonResponse(true, [
                    'title' => 'Успешно',
                    'achievement_record' => $updatedAchievementRecord
                ]);
            }
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при создании записи'
        ]);
    }

    public function find(int $id): JsonResponse
    {
        $achievementRecord = $this->achievementRecordRepository->find($id);
        if ($achievementRecord and $achievementRecord->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'achievement_record' => $achievementRecord
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении записи достижения'
        ]);
    }

    public function get(int $achievementId): JsonResponse
    {
        $achievementsRecords = $this->achievementRecordRepository->get($achievementId);
        if ($achievementsRecords and is_iterable($achievementsRecords)) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'achievements_records' => $achievementsRecords
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении записей достижений'
        ]);
    }

    public function download(int $id)
    {
        $achievementRecord = $this->achievementRecordRepository->find($id);
        if ($achievementRecord and $achievementRecord->id) {
            $path = $achievementRecord->content;
            if (Storage::exists($path)) {
                return Storage::download($path);
            }
        }
        return back()->withErrors(['Файл не найден']);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->achievementRecordRepository->delete($id);
        if ($flag) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Запись достижения успешно удалена'
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при удалении записи достижения'
        ]);
    }
}
