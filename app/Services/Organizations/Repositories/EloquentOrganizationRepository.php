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

    public function update(int $id, array $data)
    {
        return $this->find($id)->update($data);
    }

    public function parents(int $organizationId): Collection
    {
        return Organization::query()->where('id', '!=', $organizationId)->get();
    }

    public function get(array $data = []): Collection|LengthAwarePaginator
    {
        if (isset($data['with_trashed'])) {
            $query = Organization::withTrashed();
        } else {
            $query = Organization::query();
        }
        if (isset($data['paginate']) and $data['paginate']) {
            return $query->paginate(config('pagination.per_page'), '*', 'page', $data['page']);
        }
        return $query->get();
    }

    public function create(array $data): Model
    {
        return Organization::query()->create($data);
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }


    public function destroy(int $id): bool
    {
        return Organization::withTrashed()->find($id)->forceDelete();
    }

    public function restore(int $id): bool
    {
        return Organization::withTrashed()->where('id', '=', $id)->first()->restore();
    }
}
