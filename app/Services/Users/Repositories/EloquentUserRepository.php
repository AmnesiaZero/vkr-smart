<?php

namespace App\Services\Users\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getByEmail(string $email): Model
    {
        return User::query()->where('email', '=', $email)->first();
    }

    public function emailExist(string $email): bool
    {
        return User::query()->where('email', '=', $email)->exists();
    }

    public function create(array $data): Model
    {
        return User::with(['roles', 'departments'])->create($data);
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }

    public function find(int $id): Model
    {
        return User::with(['roles', 'departments', 'organization','works','educations','careers','achievements.mode'])->find($id);
    }

    public function update(int $id, array $data): int
    {
        if(isset($data['departments_ids']))
        {
            $user = $this->find($id);
            $user->departments()->sync($data['departments_ids']);
        }
        return $this->find($id)->update($data);
    }

    public function search(array $data,array $relations=['roles', 'departments','works']): Collection
    {
        $query = User::with($relations);
        if (isset($data['organization_id'])) {
            $query = $query->where('organization_id', '=', $data['organization_id']);
        }
        if (isset($data['name'])) {
            $query = $query->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['where_in'])) {
            $values = $data['where_in'];
            $query = $query->whereIn('id', $values);
        }
        if (isset($data['email'])) {
            $query = $query->where('email', 'like', '%' . $data['email'] . '%');
        }
        if (isset($data['is_active'])) {
            $query = $query->where('is_active', '=', $data['is_active']);
        }
        if (isset($data['group'])) {
            $query = $query->where('group', 'like', '%' . $data['group'] . '%');
        }
        if (isset($data['selected_years']) and count($data['selected_years'])>0) {
            $yearsIds = $data['selected_years'];
            $query = $query->whereHas('year', function ($query) use ($yearsIds) {
                $query->whereIn('id', $yearsIds);
            });
        }
        if (isset($data['selected_faculties']) and count($data['selected_faculties'])>0) {
            $facultiesIds = $data['selected_faculties'];
            $query = $query->whereHas('faculty', function ($query) use ($facultiesIds) {
                $query->whereIn('id', $facultiesIds);
            });
        }
        $users = $query->get();



        if (isset($data['roles'])) {
            $roles = $data['roles'];
            $users = $users->filter(function ($user) use ($roles) {
                return $user->roles->whereIn('slug', $roles)->isNotEmpty();
            });
        }
        if (isset($data['role'])) {
            $role = $data['role'];
            $users = $users->filter(function ($user) use ($role) {
                return $user->roles->where('slug', '=', $role)->isNotEmpty();
            });
        }

        if (isset($data['selected_departments']) and count($data['selected_departments'])>0) {
            Log::debug('Вошёл в условие');
            $departmentsIds = $data['selected_departments'];
            $users = $users->filter(function ($user) use ($departmentsIds) {
                return $user->departments->whereIn('id', $departmentsIds)->isNotEmpty();
            });
        }
        return $users;
    }

    public function get(int $organizationId, array $roles = []): Collection
    {
        $users =  User::with(['roles', 'departments','works'])->where('organization_id', '=', $organizationId);
        if(isset($roles))
        {
            return $users->get()->filter(function ($user) use ($roles) {
                return $user->roles->whereIn('slug', $roles)->isNotEmpty();
            })->values();
        }
        return $users->get();
    }

    public function getPaginate(array $data):LengthAwarePaginator
    {
        $query =  User::with(['roles', 'departments','works'])->where('organization_id', '=', $data['organization_id']);
        $roles = $data['roles'];
        $query->whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('slug', $roles);
        });
        if(isset($data['selected_departments']))
        {
            $departmentsIds = $data['selected_departments'];
            if($roles[0]=='student')
            {
                Log::debug('Условие where in');
                $query = $query->whereIn('department_id',$departmentsIds);
            }
            else
            {
                Log::debug('Условие has');
                $query = $query->whereHas('departments',function (Builder $builder) use ($departmentsIds) {
                    $builder->whereIn('departments.id', $departmentsIds);
                });
            }
        }
        return $query->paginate(config('paginate.per_page'),'*','page',$data['page']);

    }

    public function filterUsers(Collection $users, array $data): Collection
    {
        if (isset($data['organization_id'])) {
            $users = $users->where('organization_id', '=', $data['organization_id']);
        }
        if (isset($data['name'])) {
            $users = $users->where('name', 'like', '%' . $data['name'] . '%');
        }
        if (isset($data['where_in'])) {
            $values = $data['where_in'];
            $users = $users->whereIn('id', $values);
        }
        return $users;
    }

    public function exists(int $id): bool
    {
        return User::query()->where('id','=',$id)->exists();
    }
}
