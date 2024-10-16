<?php

namespace App\Services\News\Repositories;

use App\Models\News;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EloquentNewsRepository implements NewsRepositoryInterface
{
    /**
     * Получить полный список ресурсов (за исключением удаленных) без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllWithoutPaginationWithoutTrashed(string $orderByColumn, string $direction): Collection
    {
        return News::query()->orderBy($orderByColumn, $direction)->get();
    }

    /**
     * Получить полный список ресурсов (включая удаленные) без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllWithoutPaginationWithTrashed(string $orderByColumn, string $direction): Collection
    {
        return News::withTrashed()->orderBy($orderByColumn, $direction)->get();
    }

    /**
     * Получить список всех ресурсов (за исключением удаленных) с пагинацией
     * @param string $orderByColumn
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginationWithoutTrashed(string $orderByColumn, string $direction): LengthAwarePaginator
    {
        return News::query()->orderBy($orderByColumn, $direction)->paginate(20);
    }

    /**
     * Получить список всех ресурсов (включая удаленные) с пагинацией
     * @param string $orderByColumn
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginationWithTrashed(string $orderByColumn, string $direction): LengthAwarePaginator
    {
        return News::withTrashed()->orderBy($orderByColumn, $direction)->paginate(20);
    }

    /**
     * Получить опубликованные ресурсы с пагинацией
     * @param string|array $orderByColumn
     * @param string $direction
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllPublishedWithPagination($orderByColumn, string $direction, int $limit): LengthAwarePaginator
    {
        $query = News::withTrashed();

        if (is_array($orderByColumn)) {
            foreach ($orderByColumn as $column) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy($orderByColumn, $direction);
        }
//        $query->orderBy('started_at', 'DESC');
//        $query->orderBy('id', 'DESC');
        $query->where('published', '=', 1);
        return $query->paginate($limit);

    }

    /**
     * Получить опубликованные ресурсы с пагинацией
     * @param string|array $orderByColumn
     * @param string $direction
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllUnpublishedWithPagination($orderByColumn, string $direction, int $limit): LengthAwarePaginator
    {
        $query = News::withTrashed();

        if (is_array($orderByColumn)) {
            foreach ($orderByColumn as $column) {
                $query->orderBy($column, $direction);
            }
        } else {
            $query->orderBy($orderByColumn, $direction);
        }
//        $query->orderBy('started_at', 'DESC');
//        $query->orderBy('id', 'DESC');
        $query->where('published', '=', 0);
        return $query->paginate($limit);

    }

    /**
     * Получить опубликованные ресурсы без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllPublishedWithoutPagination(string $orderByColumn, string $direction): Collection
    {
        return News::query()
            ->where('published', '=', 1)
            ->orderBy($orderByColumn, $direction)
            ->get();
    }

    /**
     * Получить список новостей через ajax для отображения на сайте (через JQ Template)
     * @param string $action
     * @param int $page
     * @param int $perPage
     * @return Collection|int
     */
    public function getAjaxNews(string $action = '', int $page = 1, int $perPage = 9)
    {
        $query = News::query();
        $query->where('published', '=', 1);
        $query->orderBy('id', 'DESC');

        switch ($action) {
            case 'getTotalRows':
                return $query->get()->count();
                break;
            default:
                if ($page > 1) {
                    $query->offset(($page - 1) * $perPage);
                }
                $query->limit($perPage);
                return $query->get();
                break;
        }
    }

    /**
     * Получить полный список ресурсов (за исключением удаленных) без пагинации
     *
     * @return Collection
     */
    public function get_full_list(): Collection
    {
        return News::all();
    }

    /**
     * Получить полный список ресурсов (включая удаленные) без пагинации
     *
     * @return Collection
     */
    public function get_full_list_with_trashed(): Collection
    {
        return News::withTrashed()->all();
    }

    /**
     * Получить список всех ресурсов (за исключением удаленных) с пагинацией
     *
     * @return LengthAwarePaginator
     */
    public function get_all(): LengthAwarePaginator
    {
        return News::query()->paginate(20);
    }

    /**
     * Получить список всех ресурсов (включая удаленные) с пагинацией
     *
     * @return LengthAwarePaginator
     */
    public function get_all_with_trashed(): LengthAwarePaginator
    {
        return News::withTrashed()->paginate(20);
    }

    /**
     * Получить список новостей с отложенной датой публикации
     * @return LengthAwarePaginator
     */
    public function get_future_news(): LengthAwarePaginator
    {
        return News::query()->withTrashed()->where('started_at', '>', time())->orderBy('id', 'DESC')->paginate(20);
    }

    /**
     * Получить список опубликованных (по дате) новостей
     * @return LengthAwarePaginator
     */
    public function get_past_news(): LengthAwarePaginator
    {
        return News::query()->withTrashed()->where('started_at', '<=', time())->orderBy('id', 'DESC')->paginate(20);
    }

    /**
     * Поиск только опубликованного ресурса по его идентификатору (ID)
     *
     * @param int $id
     * @return ?Model|null
     */
    public function findOnlyPublished(int $id): ?Model
    {
        return News::query()
            ->where('published', '=', 1)
            ->where('id', '=', $id)
            ->first();
    }

    /**
     * Поиск ресурсов по заданным параметрам
     *
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function search(array $filter): LengthAwarePaginator
    {
        $query = News::query();
        if (!empty($filter)) {
            if ($filter['title']) {
                $query->where('title', 'like', '%' . $filter['title'] . '%');
            }
        }
        $query->orderBy('title', 'ASC');
        return $query->paginate(20);
    }

    /**
     * Фильтрация новостей в панели управления
     * @param array #filter;
     * @return LengthAwarePaginator
     */
    public function filter(array $filter): LengthAwarePaginator
    {
        $query = News::query();
        if (!empty($filter)) {
            if (isset($filter['title'])) {
                $query->where('title', 'like', '%' . $filter['title'] . '%');
            }
            if (isset($filter['published'])) {
                $query->where('published', 'like', '%' . $filter['published'] . '%');
            }
        }
        $query->groupBy('id');
        $query->orderBy('id', 'DESC');

        return $query->paginate(20);
    }

    /**
     * Создание нового ресурса в хранилище
     *
     * @param array $data
     * @return bool|int
     */
    public function create(array $data)
    {
        return News::query()->create($data);
    }

    /**
     * Мягкое удаление ресурса
     *
     * @param int $id
     * @return bool|int
     */
    public function destroy(int $id)
    {
        return News::withTrashed()->where('id', $id)->forceDelete();
    }

    /**
     * Восстановление удаленного ресурса
     *
     * @param int $id
     * @return bool|int
     */
    public function restore(int $id)
    {
        return News::query()->where('id', $id)->restore();
    }

    /**
     * Удаление ресурса из хранилища (восстановлению не подлежит)
     *
     * @param int $id
     * @return bool|int
     */
    public function delete(int $id)
    {
        return News::query()->where('id', $id)->delete();
    }

    /**
     * Изменение статуса публикации ресурса
     *
     * @param array $data
     * @param News|resource $item
     * @return bool|int
     */
    public function updateStatus(array $data, $item)
    {
        return $item->update($data);
    }

    /**
     * Обновление ресурса в хранилище
     *
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update(array $data, int $id): int
    {
        return $this->find($id)->update($data);
    }

    /**
     * Поиск ресурса по его идентификатору (ID)
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return News::query()->find($id);
    }

    /**
     * Снять ресурс с публикации
     *
     * @param int $id
     * @return bool
     */
    public function unpublished(int $id): bool
    {
        return News::query()->where('id', $id)->update(['published' => 0]);
    }

    /**
     * Получить cnt последних новостей
     *
     * @param int $cnt
     * @return Collection
     */
    public function get_last_news(int $cnt): Collection
    {
        $query = News::query();
        $query->where('started_at', '<=', time());
        $query->where('published', '=', 1);
        $query->limit($cnt);
        $query->orderBy('id', 'DESC');

        return $query->get();
    }
}
