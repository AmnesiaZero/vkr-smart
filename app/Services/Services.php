<?php

namespace App\Services;

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

}
