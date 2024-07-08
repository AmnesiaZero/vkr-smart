<?php

namespace App\Services\Careers\Repositories;

use App\Models\Career;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentCareerRepository implements CareerRepositoryInterface
{
    public function create(array $data): Model
    {
        return Career::query()->create($data);
    }

    public function get(int $userId): Collection
    {
        return Career::query()->where('user_id','=',$userId)->get();
    }

    public function delete(int $id): bool
    {
        return Career::query()->find($id)->delete();
    }
}
