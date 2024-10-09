<?php

namespace App\Services\News\Repositories;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface NewsRepositoryInterface
{
    /**
     * Получить полный список ресурсов (за исключением удаленных) без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllWithoutPaginationWithoutTrashed(string $orderByColumn, string $direction): Collection;

    /**
     * Получить полный список ресурсов (включая удаленные) без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllWithoutPaginationWithTrashed(string $orderByColumn, string $direction): Collection;

    /**
     * Получить список всех ресурсов (за исключением удаленных) с пагинацией
     * @param string $orderByColumn
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginationWithoutTrashed(string $orderByColumn, string $direction): LengthAwarePaginator;

    /**
     * Получить список всех ресурсов (включая удаленные) с пагинацией
     * @param string $orderByColumn
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginationWithTrashed(string $orderByColumn, string $direction): LengthAwarePaginator;

    /**
     * Получить опубликованные ресурсы с пагинацией
     * @param string|array $orderByColumn
     * @param string $direction
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllPublishedWithPagination($orderByColumn, string $direction, int $limit): LengthAwarePaginator;


    /**
     * @param $orderByColumn
     * @param string $direction
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllUnpublishedWithPagination($orderByColumn, string $direction, int $limit): LengthAwarePaginator;


    /**
     * Получить опубликованные ресурсы без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllPublishedWithoutPagination(string $orderByColumn, string $direction): Collection;

    /**
     * Получить список новостей через ajax для отображения на сайте (через JQ Template)
     * @param string $action
     * @param int $page
     * @param int $perPage
     * @return Collection|int
     */
    public function getAjaxNews(string $action = '', int $page = 1, int $perPage = 9);

    /**
     * Получить полный список ресурсов (за исключением удаленных) без пагинации
     *
     * @return Collection
     */
    public function get_full_list(): Collection;

    /**
     * Получить полный список ресурсов (включая удаленные) без пагинации
     *
     * @return Collection
     */
    public function get_full_list_with_trashed(): Collection;

    /**
     * Получить список всех ресурсов (за исключением удаленных) с пагинацией
     *
     * @return LengthAwarePaginator
     */
    public function get_all(): LengthAwarePaginator;

    /**
     * Получить список всех ресурсов (включая удаленные) с пагинацией
     *
     * @return LengthAwarePaginator
     */
    public function get_all_with_trashed(): LengthAwarePaginator;

    /**
     * Получить список новостей с отложенной датой публикации
     * @return LengthAwarePaginator
     */
    public function get_future_news(): LengthAwarePaginator;

    /**
     * Получить список опубликованных (по дате) новостей
     * @return LengthAwarePaginator
     */
    public function get_past_news(): LengthAwarePaginator;

    /**
     * Поиск ресурса по его идентификатору (ID)
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * Поиск только опубликованного ресурса по его идентификатору (ID)
     *
     * @param int $id
     * @return Model|null
     */
    public function findOnlyPublished(int $id): ?Model;

    /**
     * Поиск ресурсов по заданным параметрам
     *
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function search(array $filter): LengthAwarePaginator;

    /**
     * Создание нового ресурса в хранилище
     *
     * @param array $data
     * @return bool|integer
     */
    public function create(array $data);

    /**
     * Обновление ресурса в хранилище
     *
     * @param array $data
     * @param int $id
     * @return bool|integer
     */
    public function update(array $data, int $id);

    /**
     * Мягкое удаление ресурса
     *
     * @param int $id
     * @return bool|integer
     */
    public function destroy(int $id);

    /**
     * Восстановление удаленного ресурса
     *
     * @param int $id
     * @return bool|integer
     */
    public function restore(int $id);

    /**
     * Удаление ресурса из хранилища (восстановлению не подлежит)
     *
     * @param int $id
     * @return bool|integer
     */
    public function delete(int $id);

    /**
     * Изменение статуса публикации ресурса
     *
     * @param array $data
     * @param News|resource $item
     * @return bool|integer
     */
    public function updateStatus(array $data, News $item);

    /**
     * Снять ресурс с публикации
     *
     * @param int $id
     * @return bool|integer
     */
    public function unpublished(int $id);

    /**
     * Получить cnt последних новостей
     *
     * @param int $cnt
     * @return Collection
     */
    public function get_last_news(int $cnt): Collection;
}
