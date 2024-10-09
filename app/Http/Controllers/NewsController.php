<?php

namespace App\Http\Controllers;

use App\Helpers\ValidatorHelper;
use App\Services\News\NewsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    protected array $fillable = [
        'id',
        'title',
        'additional_title',
        'annotation',
        'seo_title',
        'description',
        'keywords',
        'visibility',
        'tags',
        'preview_path',
        'preview_name',
        'text',
        'published',
        'publication_date',
        'redirect',
        'preview_image'
    ];
    private $_newsService;

    public function __construct(NewsService $newsService)
    {
        $this->_newsService = $newsService;
    }

    public function create()
    {
        $you = Auth::user();
        return view('templates.dashboard.platform.news.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'title' => 'required|max:250',
            'preview_image' => 'file',
//            'publication_date' => 'date',
            'published' => 'required|bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $data = $request->only($this->fillable);
        return $this->_newsService->store($data);
    }

    public function index()
    {
        return $this->_newsService->index();
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'id' => ['required', 'integer', Rule::exists('news', 'id')],
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        return $this->_newsService->edit($id);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'id' => ['required', 'integer', Rule::exists('news', 'id')],
            'title' => 'required|max:250',
            'publication_date' => 'date',
            'published' => 'required|bool'
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        $data = $request->only($this->fillable);
        return $this->_newsService->update($id, $data);
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'id' => ['required', 'integer', Rule::exists('news', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::redirectError($validator);
        }
        $id = $request->id;
        return $this->_newsService->update_status($id);

    }

    /**
     * Отобразить содержимое выбранной новости
     *
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        $id = $request->id;
        if ($id) {
            $item = $this->_newsService->findOnlyPublished($request->id);
            $nextItem = $this->_newsService->findOnlyPublished($item->id + 1);
            $prevItem = $this->_newsService->findOnlyPublished($item->id - 1);
//            $last_news = $this->_newsService->get_last_news(4);
            $viewData = [
                'item' => $item,
//                'last_news' => $last_news,
                'previous_id' => $prevItem ?? NULL,
                'next_id' => $nextItem ?? NULL
            ];
            return View('templates.dashboard.platform.news.inc.item-row', $viewData);
        } else {
            return View($this->template . '.pages.404');
        }
    }

    /**
     * Получить список новостей через ajax для отображения на сайте (через JQ Template)
     * @param Request $request
     * @return JsonResponse
     */
    public function getAjaxNews(Request $request): JsonResponse
    {
        $page = $request->input('page');
        return $this->_newsService->getAjaxNews('', $page, 12);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'id' => ['required', 'integer', Rule::exists('news', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->_newsService->delete($id);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'id' => ['required', 'integer', Rule::exists('news', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->_newsService->destroy($id);
    }

    public function restore(Request $request)
    {
        $validator = Validator::make($request->only($this->fillable), [
            'id' => ['required', 'integer', Rule::exists('news', 'id')]
        ]);
        if ($validator->fails()) {
            return ValidatorHelper::error($validator);
        }
        $id = $request->id;
        return $this->_newsService->restore($id);
    }
}
