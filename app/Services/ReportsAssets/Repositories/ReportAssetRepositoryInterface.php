<?php

namespace App\Services\ReportsAssets\Repositories;

interface ReportAssetRepositoryInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

}
