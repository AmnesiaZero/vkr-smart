<?php

namespace App\Services\Organizations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrganizationRepositoryInterface
{


    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * @param int $id
     * @return bool
     */
    public function exist(int $id): bool;

    /**
     * @param array $data
     * @return Collection|LengthAwarePaginator
     */
    public function get(array $data):Collection|LengthAwarePaginator;

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id,array $data);
}
