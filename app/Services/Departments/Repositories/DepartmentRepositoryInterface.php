<?php

namespace App\Services\Departments\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface DepartmentRepositoryInterface
{
    /**
     * Создать новый факультет для организации
     * @param array $data
     * @return mixed
     */
    public function create(array $data): Model;

    /**
     * Получить кафедры по id факультета
     * @param array $data
     * @return Collection|LengthAwarePaginator
     */
    public function get(array $data): Collection|LengthAwarePaginator;

    /**
     * Получить по году
     * @param int $yearId
     * @return Collection
     */
    public function getByYearId(int $yearId): Collection;


    /**
     * Обновить данные
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update(int $id, array $data): int;

    /**
     * Мягкое удаление
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
     * @return bool
     */
    public function restore(int $id): bool;



    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * @param int $id
     * @return bool
     */
    public function exist(int $id): bool;

    /**
     * @param int $id
     * @return mixed
     */
    public function getProgramSpecialties(int $id);

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data):LengthAwarePaginator;


}
