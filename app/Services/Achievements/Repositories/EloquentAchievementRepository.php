<?php

namespace App\Services\Achievements\Repositories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentAchievementRepository implements AchievementRepositoryInterface
{

    public function create(array $data): Model
    {
        return Achievement::query()->create($data);
    }

    public function get(int $userId): Collection
    {
        return Achievement::query()->where('user_id','=',$userId)->get();
    }
}
