<?php

namespace App\Services;

use App\Services\Decorations\DecorationsService;
use App\Services\Decorations\Repositories\DecorationRepositoryInterface;
use Illuminate\Http\JsonResponse;

class Services
{


    /**
     * @param bool $success
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public static function sendJsonResponse(bool $success, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'data' => $data
        ], $status);
    }

//    public static function view(string $name,array $data = [])
//    {
//        $you = Auth::user();
//        $decorationRepository = app(DecorationRepositoryInterface::class);
//        $decorationService = new DecorationsService($decorationRepository);
//        $organizationId = $you->organization_id;
//        $decoration = $decorationService->get($organizationId);
//        if($decoration)
//        {
//            $data = array_merge($data,['decoration' => $decoration]);
//            return view($name,$data);
//        }
//        return back()->withErrors(['Ошибка - оформление не найдено']);
//
//
//    }

}
