<?php

namespace App\Services;

use App\Services\Decorations\Repositories\DecorationRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Services
{

    private DecorationRepositoryInterface $decorationRepository;

    public function __construct(DecorationRepositoryInterface $decorationRepository)
    {
        $this->decorationRepository = $decorationRepository;
    }


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

    public function view()
    {
        $you = Auth::user();
        $organizationId = $you->organization_id;
        $decoration = $this->decorationRepository->get($organizationId);

    }

}
