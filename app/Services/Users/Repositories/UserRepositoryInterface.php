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
     * @param array $data
     * @return Collection|LengthAwarePaginator
     */
    public function get(array $data): Collection|LengthAwarePaginator;


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
     * @param array $data
     * @return int
     */
    public function update(int $id, array $data): int;


    /**
     * @param array $data
     * @param array $relations
     * @return Collection|LengthAwarePaginator
     */
    public function search(array $data, array $relations = ['roles', 'departments', 'works']): Collection|LengthAwarePaginator;


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
