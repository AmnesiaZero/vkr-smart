<?php

namespace App\Services\Educations;

use App\Services\Educations\Repositories\EducationRepositoryInterface;
use App\Services\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EducationsService extends Services
{
    private EducationRepositoryInterface $educationRepository;

    public function __construct(EducationRepositoryInterface $educationRepository)
    {
        $this->educationRepository = $educationRepository;
    }

    public function create(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $data['organization_id'] = $organizationId;
        $education = $this->educationRepository->create($data);
        if ($education and $education->id) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Успешно создано образование',
                'education' => $education
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Ошибка при создании образования'
        ]);
    }

    public function get(int $userId): JsonResponse
    {
        $educations = $this->educationRepository->get($userId);
        if ($educations and is_iterable($educations)) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'educations' => $educations
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при получении образований'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->educationRepository->delete($id);
        if ($flag) {
            return self::sendJsonResponse(true, [
                'title' => 'Успешно',
                'message' => 'Образование было успешно удалено'
            ]);
        }
        return self::sendJsonResponse(false, [
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при удалении образования'
        ]);
    }
}
