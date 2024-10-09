@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Список новостей</h2>
            <div>
                <a href="{{ route('news.create') }}" class="btn btn-danger add-button"><i class="fas fa-plus"></i>
                    Добавить</a>
            </div>
        </div>
        <div class="list-body">
            <table class="table table-responsive">
                <thead class="thead-light">
                <tr>
                    <th colspan="5">
                        Новости, ожидающие публикации
                    </th>
                </tr>
                <tr class="col-title">
                    <th class="id">
                        #
                    </th>
                    <th>
                        Заголовок
                    </th>
                    <th class="published_date">
                        Дата публикации
                    </th>
                    <th class="status text-center">
                        Статус
                    </th>
                    <th class="actions">
                        Действия
                    </th>
                </tr>
                </thead>
                @if(isset($unpublished_news) && !empty($unpublished_news))
                    @foreach($unpublished_news as $item)
                        @include('templates.dashboard.platform.news.inc.item-row', array(
                            'news'=>$item,
                        ))
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">
                            Нет элементов для отображения
                        </td>
                    </tr>
                @endif
            </table>

            <table class="table table-responsive">
                <thead class="thead-light">
                <tr>
                    <th colspan="5">
                        Опубликованные новости
                    </th>
                </tr>
                <tr class="col-title">
                    <th class="id">
                        #
                    </th>
                    <th>
                        Заголовок
                    </th>
                    <th class="published_date">
                        Дата публикации
                    </th>
                    <th class="status text-center">
                        Статус
                    </th>
                    <th class="actions">
                        Действия
                    </th>
                </tr>
                </thead>
                @if(isset($published_news) && !empty($published_news))
                    @foreach($published_news as $item)
                        @include('templates.dashboard.platform.news.inc.item-row', array(
                            'item'=>$item,
                        ))
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">
                            Нет элементов для отображения
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
