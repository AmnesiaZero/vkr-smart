<?php

namespace App\Services\Achievements\Repositories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentAchievementRepository implements AchievementRepositoryInterface
{

    public function create(array $data): Model
    {
        return Achievement::with('mode')->create($data);
    }

    public function get(int $userId): Collection
    {
        return Achievement::with('mode')->where('user_id','=',$userId)->get();
    }

    public function find(int $id): Model
    {
        return Achievement::query()->find($id);
    }

    public function delete(int $id): bool
    {
        return Achievement::query()->find($id)->delete();
    }
}
