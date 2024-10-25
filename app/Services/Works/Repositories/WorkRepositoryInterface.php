<?php

namespace App\Services\Works\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpParser\Node\Expr\AssignOp\Mod;

interface WorkRepositoryInterface
{
    /**
     * @param int $organizationId
     * @return Collection
     */
    public function get(int $organizationId): Collection;

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getPaginate(array $data): LengthAwarePaginator;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * @param array $data
     * @return LengthAwarePaginator|Collection
     */
    public function search(array $data): LengthAwarePaginator|Collection;


    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function copy(int $id);

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
    public function restore(int $id);

    /**
     * @param int $reportId
     * @return mixed
     */
    public function updateReportStatus(int $reportId, array $data);




    /**
     * @param int $reportId
     * @return Model
     */
    public function findByReportId(int $reportId): Model;

    /**
     * @param int $userId
     * @param int $pageNumber
     * @return Collection
     */
    public function getUserWorks(int $userId, int $pageNumber): LengthAwarePaginator;

    /**
     * Проверяет, существует ли работа с данным id
     * @param int $workId
     * @return bool
     */
    public function exist(int $workId):bool;

}
