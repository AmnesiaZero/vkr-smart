<?php

namespace App\Services\AchievementsRecords\Repositories;

use App\Models\AchievementRecord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentAchievementRecordRepository implements AchievementRecordRepositoryInterface
{

    public function create(array $data): Model
    {
        return AchievementRecord::query()->create($data);
    }

    public function get(int $achievementId): Collection
    {
        return AchievementRecord::with('type.category')->where('achievement_id','=',$achievementId)->get();
    }

    public function update(int $id, array $data)
    {
        return AchievementRecord::query()->find($id)->update($data);
    }

    public function find(int $id): Model
    {
        return AchievementRecord::with('type.category')->find($id);
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }
}
