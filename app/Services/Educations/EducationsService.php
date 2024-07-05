<?php

namespace App\Services\Educations;

use App\Helpers\JsonHelper;
use App\Services\Educations\Repositories\EducationRepositoryInterface;
use Illuminate\Http\JsonResponse;

class EducationsService
{
   private EducationRepositoryInterface $educationRepository;

   public function __construct(EducationRepositoryInterface $educationRepository)
   {
       $this->educationRepository = $educationRepository;
   }

   public function create(array $data): JsonResponse
   {
       $education = $this->educationRepository->create($data);
       if($education and $education->id)
       {
           return JsonHelper::sendJsonResponse(true,[
               'title' => 'Успешно',
               'message' => 'Успешно создано образование'
           ]);
       }
       return JsonHelper::sendJsonResponse(false,[
           'title' => 'Ошибка',
           'message' => 'Ошибка при создании образования'
       ]);
   }

    public function get(int $userId): JsonResponse
    {
        $educations = $this->educationRepository->get($userId);
        if($educations and is_iterable($educations))
        {
            return JsonHelper::sendJsonResponse(true,[
                'title' => 'Успешно',
                'educations' => $educations
            ]);
        }
        return JsonHelper::sendJsonResponse(false,[
            'title' => 'Ошибка',
            'message' => 'Возникла ошибка при получении образований'
        ]);
    }
}
