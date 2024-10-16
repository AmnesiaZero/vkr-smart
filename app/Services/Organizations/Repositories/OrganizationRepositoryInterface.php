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
    public function get(array $data): Collection|LengthAwarePaginator;

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param int $organizationId
     * @return Collection
     */
    public function parents(int $organizationId): Collection;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;


    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * @param int $id
     * @return mixed
     */
    public function restore(int $id): bool;


}
