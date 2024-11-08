<?php

namespace App\Services\News;

use App\Helpers\DateHelper;
use App\Helpers\FilesHelper;
use App\Services\News\Repositories\NewsRepositoryInterface;
use App\Services\Services;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsService extends Services
{
    private $_repository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->_repository = $newsRepository;
    }

    public function index()
    {
        $you = Auth::user();
        $orderBy = 'title';
        $direction = 'asc';
        $limit = 500;
        $publishedNews = $this->_repository->getAllPublishedWithPagination($orderBy, $direction, $limit);
        $unpublishedNews = $this->_repository->getAllUnpublishedWithPagination($orderBy, $direction, $limit);
        if ($publishedNews and $unpublishedNews) {
            return view('templates.dashboard.platform.news.index', [
                'published_news' => $publishedNews,
                'unpublished_news' => $unpublishedNews,
                'you' => $you
            ]);
        }
        return back()->withErrors(['Ошибка при подгрузке нововстей']);
    }

    /**
     * Получить опубликованные ресурсы с пагинацией
     * @param string|array $orderByColumn
     * @param string $direction
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllPublishedWithPagination($orderByColumn = 'id', string $direction = 'ASC', int $limit = 20): LengthAwarePaginator
    {
        return $this->_repository->getAllPublishedWithPagination($orderByColumn, $direction, $limit);
    }

    /**
     * Получить полный список ресурсов (за исключением удаленных) без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllWithoutPaginationWithoutTrashed(string $orderByColumn = 'id', string $direction = 'ASC'): Collection
    {
        return $this->_repository->getAllWithoutPaginationWithoutTrashed($orderByColumn, $direction);
    }

    /**
     * Получить полный список ресурсов (включая удаленные) без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllWithoutPaginationWithTrashed(string $orderByColumn = 'id', string $direction = 'ASC'): Collection
    {
        return $this->_repository->getAllWithoutPaginationWithTrashed($orderByColumn, $direction);
    }

    /**
     * Получить список всех ресурсов (за исключением удаленных) с пагинацией
     * @param string $orderByColumn
     * @param string $direction
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginationWithoutTrashed(string $orderByColumn = 'id', string $direction = 'ASC'): LengthAwarePaginator
    {
        return $this->_repository->getAllWithPaginationWithoutTrashed($orderByColumn, $direction);
    }

    /**
     * Получить полный список ресурсов (включая удаленные) с пагинацией
     * @param string $orderByColumn
     * @param string $direction
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginationWithTrashed(string $orderByColumn = 'id', string $direction = 'ASC', int $limit = 20): LengthAwarePaginator
    {
        return $this->_repository->getAllWithPaginationWithTrashed($orderByColumn, $direction, $limit);
    }

    /**
     * Получить опубликованные ресурсы без пагинации
     * @param string $orderByColumn
     * @param string $direction
     * @return Collection
     */
    public function getAllPublishedWithoutPagination(string $orderByColumn = 'id', string $direction = 'ASC'): Collection
    {
        return $this->_repository->getAllPublishedWithoutPagination($orderByColumn, $direction);
    }

    /**
     * Получить список новостей через ajax для отображения на сайте (через JQ Template)
     * @param string $action
     * @param int $page
     * @param int $perPage
     * @return JsonResponse
     */
    public function getAjaxNews(string $action = '', int $page = 1, int $perPage = 9): JsonResponse
    {
        $items = $this->_repository->getAjaxNews($action, $page, $perPage);

        if ($page == 1) {
            $total = $this->_repository->getAjaxNews('getTotalRows', $page, $perPage);
        }

        foreach ($items as $item) {
            $item->previewImage = $item->preview_image ?? '/images/news-default.jpg';
            $item->startedAt = DateHelper::format('d.m.Y', $item->publication_date);
        }

        return response()->json([
            'data' => $items,
            'total' => $total ?? '',
        ]);
    }

    /**
     * Получить полный список ресурсов (за исключением удаленных) без пагинации
     *
     * @return Collection
     */
    public function get_full_list(): Collection
    {
        return $this->_repository->get_full_list();
    }

    /**
     * Получить полный список ресурсов (включая удаленные) без пагинации
     *
     * @return Collection
     */
    public function get_full_list_with_trashed(): Collection
    {
        return $this->_repository->get_full_list_with_trashed();
    }

    /**
     * Получить список всех ресурсов (за исключением удаленных) с пагинацией
     *
     * @return LengthAwarePaginator
     */
    public function get_all(): LengthAwarePaginator
    {
        return $this->_repository->get_all();
    }

    /**
     * Получить полный список ресурсов (включая удаленные) с пагинацией
     *
     * @return array
     */
    public function get_all_with_trashed(): array
    {
        $items = $this->_repository->get_all_with_trashed();

        $deferred_items = array();
        $published_items = array();

        foreach ($items as $item) {
            if ($item['publication_date'] && strtotime($item['publication_date']) >= strtotime(date('Y-m-d H:i:s'))) {
                $deferred_items[$item['id']] = $item;
            } else {
                $published_items[$item['id']] = $item;
            }
        }

        return [
            'deferred' => $deferred_items,
            'published' => $published_items,
        ];

    }

    /**
     * Получить список новостей с отложенной датой публикации
     * @return LengthAwarePaginator
     */
    public function get_future_news(): LengthAwarePaginator
    {
        return $this->_repository->get_future_news();
    }

    /**
     * Получить список опубликованных (по дате) новостей
     * @return LengthAwarePaginator
     */
    public function get_past_news(): LengthAwarePaginator
    {
        return $this->_repository->get_past_news();
    }

    /**
     * Поиск только опубликованного ресурса по его идентификатору (ID)
     *
     * @param int $id
     * @return ?Model|null
     */
    public function findOnlyPublished(int $id): ?Model
    {
        return $this->_repository->findOnlyPublished($id);
    }

    /**
     * Поиск ресурсов по заданным параметрам
     *
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function search(array $filter): LengthAwarePaginator
    {
        return $this->_repository->search($filter);
    }

    /**
     * Фильтрация по новостям
     * @param array $filter ;
     * @return LengthAwarePaginator
     */
    public function filter(array $filter): LengthAwarePaginator
    {
        return $this->_repository->filter($filter);
    }

    /**
     * Создание нового ресурса в хранилище
     *
     * @param array $data
     */
    public function store(array $data)
    {
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }

        if (!empty($data['publication_date'])) {
            $date = $data['publication_date'];
            $data['publication_date'] = Carbon::createFromFormat('d.m.Y', $date);
        } else {
            $data['publication_date'] = now();
        }

        $data['user_id'] = Auth::user()->id;

        $item = $this->_repository->create($data);

        if ($item && $item->id) {
            $id = $item->id;
            if (isset($data['preview_image']) and is_file($data['preview_image']) and FilesHelper::acceptableImage($data['preview_image'])) {
                $imageFile = $data['preview_image'];
                $directoryNumber = ceil($id / 1000);
                $previewDirectory = 'public/previews/' . $directoryNumber;
                Storage::makeDirectory($previewDirectory);
                $storeName = $id . '.' . $imageFile->extension();
                $previewPath = $imageFile->storeAs($previewDirectory, $storeName);
                $originalName = $imageFile->getClientOriginalName();
                $updatedData = [
                    'preview_path' => $previewPath,
                    'preview_name' => $originalName
                ];
                $result = $this->_repository->update($updatedData, $id);

                if (is_null($result)) {
                    return back()->withErrors(['Ошибка при загрузке изображения новости']);
                }
            }
            if (isset($data['redirect'])) {
                return redirect(route('news.index'));
            }
            return view('templates.dashboard.platform.news.create', [
                'item' => $item
            ]);
        } else {
            return back()->withErrors(['Ошибка при сохранении новости']);
        }
    }

    /**
     * Обновление ресурса в хранилище
     *
     * @param array $data
     * @param int $id
     */
    public function update(int $id, array $data)
    {
        if (empty($data)) {
            return back()->withErrors(['Пустой массив данных']);
        }

        if (!empty($data['publication_date'])) {
            $date = $data['publication_date'];
            $data['publication_date'] = Carbon::createFromFormat('d.m.Y', $date);

        } else {
            $data['publication_date'] = now();
        }

        if (isset($data['preview_image']) and is_file($data['preview_image']) and FilesHelper::acceptableImage($data['preview_image'])) {
            $imageFile = $data['preview_image'];
            $directoryNumber = ceil($id / 1000);
            $previewDirectory = 'public/previews/' . $directoryNumber;
            Storage::makeDirectory($previewDirectory);
            $storeName = $id . '.' . $imageFile->extension();
            $previewPath = $imageFile->storeAs($previewDirectory, $storeName);
            $data['preview_path'] = $previewPath;
            $originalName = $imageFile->getClientOriginalName();
            $data['preview_name'] = $originalName;
        }

        $result = $this->_repository->update($data, $id);

        if ($result) {
            $item = $this->_repository->find($id);
            if ($item and $item->id) {
                if (isset($data['redirect'])) {
                    return redirect(route('news.index'));
                }
                return view('templates.dashboard.platform.news.edit', [
                    'item' => $item
                ]);
            }
        } else {
            return back()->withErrors(['Ошибка при обновлении новости']);
        }
    }

    /**
     * Поиск ресурса по его идентификатору (ID)
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->_repository->find($id);
    }

    public function edit(int $id)
    {
        $item = $this->_repository->find($id);
        if ($item and $item->id) {
            return view('templates.dashboard.platform.news.edit', [
                'item' => $item
            ]);
        }
        return back()->withErrors(['Ошибка при получении экземпляра новости']);
    }

    /**
     * Мягкое удаление ресурса
     *
     * @param int $id
     * @return JsonResponse
     */
    public function unpublished(int $id): JsonResponse
    {
        if (!$id) {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Некорректно указан id ресурса'
            ]);
        }

        $unpublished = $this->_repository->unpublished($id);

        if (!$unpublished) {

        }

        $result = $this->_repository->destroy($id);

        if ($result) {
            return response()->json([
                "error" => false,
                "successTitle" => "Успешно!",
                "successMessage" => "Ресурс удален успешно",
                "restoreLink" => route('dashboard.news.restore', ['id' => $id]),
                "deleteLink" => route('dashboard.news.delete', ['id' => $id])
            ]);
        } else {
            return response()->json([
                'error' => true,
                'errorCode' => '#D0003',
                'errorMessage' => 'Не удалось удалить ресурс'
            ]);
        }
    }

    /**
     * Восстановление удаленного ресурса
     *
     * @param int $id
     */
    public function restore(int $id)
    {
        if (!$id) {
            return back()->withErrors(['Некорректно указанный id ресурса']);
        }

        $result = $this->_repository->restore($id);

        if ($result) {
            return back();
        }
        return back()->withErrors(['Не удалось восстановить ресурс']);
    }

    /**
     * Мягкое удаление ресурса
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        if (!$id) {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Неверно указан id ресурса'
            ]);
        }

        $result = $this->_repository->delete($id);

        if ($result) {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно!',
                'message' => 'Ресурс удален успешно',
            ]);
        } else {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Не удалось удалить ресурс'
            ]);
        }
    }

    /**
     * Удаление ресурса из хранилища (восстановлению не подлежит)
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if (!$id) {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Неверно указан id ресурса'
            ]);
        }

        $result = $this->_repository->destroy($id);

        if ($result) {
            return self::sendJsonResponse(true,[
                'title' => 'Успешно!',
                'message' => 'Ресурс удален успешно',
            ]);
        } else {
            return self::sendJsonResponse(false,[
                'title' => 'Ошибка',
                'message' => 'Не удалось удалить ресурс'
            ]);
        }
    }

    /**
     * Изменение статуса публикации ресурса
     *
     * @param int $currentStatus
     * @param resource $item
     */
    public function update_status(int $id)
    {
        $item = $this->_repository->find($id);
        if ($item and $item->id) {
            $published = $item->published;
            $published = ($published == 0) ? 1 : 0;
            $data = [
                'published' => $published
            ];
            $result = $this->_repository->update($data, $id);
            if ($result) {
                return redirect(route('news.index'));
            }
        }
        return back()->withErrors(['Возникла ошибка при обновлении статуса публикации']);
    }

    /**
     * Получить cnt последних новостей
     *
     * @param int $cnt
     * @return Collection
     */
    public function get_last_news(int $cnt): Collection
    {
        return $this->_repository->get_last_news($cnt);
    }
}
