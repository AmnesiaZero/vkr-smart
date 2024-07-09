<?php

namespace App\Services\AchievementsRecords\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AchievementRecordRepositoryInterface
{
    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data):Model;

    /**
     * @param int $achievementId
     * @return Collection
     */
    public function get(int $achievementId):Collection;

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id,array $data);

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id):Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool;

}
