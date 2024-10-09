<?php

namespace App\Services\Careers\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CareerRepositoryInterface
{
    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param int $userId
     * @return Collection
     */
    public function get(int $userId): Collection;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
