<?php

namespace App\Services\Users\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{

    /**
     * Получить по email
     * @param string $email
     * @return Model
     */
    public function getByEmail(string $email): Model;


    /**
     * Проверить, есть ли этот email
     * @param string $email
     * @return bool
     */
    public function emailExist(string $email): bool;


    /**
     * Получить список пользователей по их организации
     * @param int $organizationId
     * @param array $roles
     * @return Collection
     */
    public function get(int $organizationId, array $roles): Collection;

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getPaginate(array $data):LengthAwarePaginator;

    /**
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update(int $id, array $data): int;

    /**
     * Поиск по пользователям
     * @param array $data
     * @param array $relations
     * @return LengthAwarePaginator
     */
    public function search(array $data,array $relations=['roles', 'departments','works']): LengthAwarePaginator;


    /**
     * @param Collection $users
     * @param array $data
     * @return Collection
     */
    public function filterUsers(Collection $users, array $data): Collection;

    /**
     * @param int $id
     * @return bool
     */
    public function exists(int $id): bool;


}
