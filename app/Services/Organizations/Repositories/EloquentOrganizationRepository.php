<?php

namespace App\Services\Organizations\Repositories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentOrganizationRepository implements OrganizationRepositoryInterface
{

    public function exist(int $id): bool
    {
        return Organization::query()->find($id)->exists();
    }

    public function find(int $id): Model
    {
        return Organization::query()->find($id);
    }

    public function get(array $data=[]): Collection|LengthAwarePaginator
    {
        $query = Organization::query();
        return $query->get();
    }

    public function update(int $id,array $data)
    {
        return $this->find($id)->update($data);
    }

    public function parents(int $organizationId): Collection
    {
        return Organization::query()->where('id','!=',$organizationId)->get();
    }

    public function create(array $data):Model
    {
        return Organization::query()->create($data);
    }
}
