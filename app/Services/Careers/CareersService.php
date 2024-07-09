<?php

namespace App\Services\Careers;

use App\Helpers\JsonHelper;
use App\Services\Careers\Repositories\CareerRepositoryInterface;
use App\Services\Services;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CareersService extends Services
{

    private CareerRepositoryInterface $careerRepository;

    public function __construct(CareerRepositoryInterface $careerRepository)
    {
        $this->careerRepository = $careerRepository;
    }

    public function create(array $data): JsonResponse
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $data['organization_id'] = $organizationId;
        $career = $this->careerRepository->create($data);
        if($career and $career->id)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'career' => $career
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при создании карьеры'
        ]);
    }

    public function get(int $userId): JsonResponse
    {
        $careers = $this->careerRepository->get($userId);
        if($careers and is_iterable($careers))
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'careers' => $careers
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Ошибка при получении карьер'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $flag = $this->careerRepository->delete($id);
        if($flag)
        {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно',
                'message' => 'Карьера успешно удалена'
            ]);
        }
        return self::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при удалении работы'
        ]);
    }

}
