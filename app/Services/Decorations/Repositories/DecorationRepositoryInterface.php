<?php

namespace App\Services\Decorations\Repositories;

use Illuminate\Database\Eloquent\Model;

interface DecorationRepositoryInterface
{
    /**
     * @param int $organizationId
     * @return Model
     */
    public function get(int $organizationId):Model;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data):Model;
}
