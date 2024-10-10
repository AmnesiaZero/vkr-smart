@extends('layouts.dashboard.platform')

@section('styles')
    <link rel="stylesheet"
          href="{{ secure_asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('/css/text-styles.css') }}" type="text/css">
@endsection

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Новая новость</h2>
        </div>
        <form enctype="multipart/form-data" id="news_form" action="{{ route('news.store') }}"
              data-action-index="{{ route('news.index') }}" method="POST">
            @csrf
            <div class="post">
                <div class="form-group">
                    <label for="title" style="font-size:14px;">Заголовок</label>
                    <input id="title" type="text" name="title" class="form-control"
                           value="@if(isset($item->title)) {{$item->title}} @endif">
                </div>
                <div class="form-group">
                    <label for="annotaion" style="font-size:14px;">Анонс новости</label>
                    <textarea id="annotaion" name="annotaion" rows="4" class="form-control"> @if(isset($item->annotaion))
                            {{$item->annotaion}}
                        @endif</textarea>
                </div>
                <div class="form-group">
                    <label for="text" style="font-size:14px;">Текст новости</label>
                    <textarea id="text" name="text" rows="12" class="form-control editor">@if(isset($item->text))
                            {{$item->text}}
                        @endif</textarea>
                </div>
                <div class="form-group">
                    <label for="preview_image">Изображение новости</label>
                    <div class="input-group">
                        <input id="preview_image" type="text"
                               value="@if(isset($item->preview_name)) {{$item->preview_name}} @endif"
                               class="form-control"
                               placeholder="Выберите изображение" aria-label="Выберите изображение"
                               aria-describedby="button-select-image" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button-select-image"
                                    onclick="toggleFile('preview_image_load')">Загрузить
                            </button>
                        </div>
                    </div>
                    <input type="file" id="preview_image_load" name="preview_image" style="display: none">
                </div>
                <div class="form-group">
                    <label for="publication_date" style="font-size:14px;">Дата начала публикации</label>
                    <input id="publication_date" type="text" name="publication_date" class="form-control datepicker"
                           value="@if(isset($item->publication_date)) {{$item->publication_date}} @endif">
                </div>
                <div class="form-group">
                    <label for="published" style="font-size:14px;">Параметры публикации</label>
                    <select name="published" class="form-control" id="published">
                        <option value="0" @if(isset($item->published) and $item->published==0) selected @endif>Не
                            опубликован
                        </option>
                        <option value="1" @if(isset($item->published) and $item->published==1) selected @endif>
                            Опубликован
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="id" value="0"/>
                </div>
                <input type="checkbox" name="redirect" id="redirect" style="display: none">
            </div>
        </form>
        <div class="form-group">
            <button id="save-close" class="btn btn-primary">Сохранить и закрыть</button>
            <button id="save" class="btn btn-primary">Сохранить</button>
            <button id="close" class="btn btn-secondary">Отмена</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/dashboard/platform/news.js"></script>
    <script src="{{ secure_asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ secure_asset('/plugins/editors/CKEditor/v5/ckeditor.js') }}"></script>
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script>CKFinder.config({connectorPath: '/ckfinder/connector'});</script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script>
        $("#publication_date").datetimepicker({
            lang: 'ru',
            format: 'd.m.Y',
            // formatTime:'H:i',
            formatDate: 'd.m.Y',
            timepicker: false,
            datepicker: true,
        });
        $('#button-select-image').on('click', function () {
            selectFileWithCKFinder('preview_image');
        });
    </script>
@endsection
