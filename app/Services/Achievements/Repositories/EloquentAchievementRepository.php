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

    public function search(array $data): Collection
    {
        $query = Achievement::with('mode');

        if(isset($data['user_id']))
        {
            $query = $query->where('user_id','=',$data['user_id']);
        }
        if(isset($data['name']))
        {
            $query = $query->where('name','=',$data['name']);
        }
        if(isset($data['achievement_mode_id']))
        {
            $query = $query->where('achievement_mode_id','=',$data['achievement_mode_id']);
        }

        return $query->get();


    }
}
