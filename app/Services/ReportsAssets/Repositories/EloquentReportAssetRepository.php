<?php

namespace App\Services\ReportsAssets\Repositories;

use App\Models\ReportAsset;

class EloquentReportAssetRepository implements ReportAssetRepositoryInterface
{

    public function create(array $data)
    {
        return ReportAsset::query()->create($data);
    }
}
