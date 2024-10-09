@extends('layouts.dashboard.platform')

@section('styles')
    <link rel="stylesheet" href="{{ secure_asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('/css/text-styles.css') }}" type="text/css">
@endsection

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование новости</h2>
        </div>
        <form enctype="multipart/form-data" id="news_form" action="{{ route('news.update', ['id' => $item->id]) }}" data-action-index="{{ route('news.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="post">
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input id="title" type="text" name="title" value="{{ $item->title }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="annotation">Анонс новости</label>
                    <textarea id="annotation" name="annotation" rows="4" class="form-control">{{ $item->annotation }}</textarea>
                </div>
                <div class="form-group">
                    <label for="text">Текст новости</label>
                    <textarea id="text" name="text" rows="12" class="form-control editor">{{ $item->text }}</textarea>
                </div>
                <div class="form-group">
                    <label for="preview_image">Изображение новости</label>
                    <div class="input-group">
                        <input id="preview_image" type="text" value="@if($item->preview_name) {{$item->preview_name}} @endif" class="form-control"
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
                    <label for="publication_date">Дата начала публикации</label>
                    <input id="publication_date" type="text" name="publication_date" value="@if($item->publication_date){{ \Carbon\Carbon::parse($item->publication_date)->format('d.m.Y') }} @else{{\Carbon\Carbon::parse($item->created_at)->format('d.m.Y')}}@endif " class="form-control datepicker">
                </div>
                <div class="form-group">
                    <label for="published">Параметры публикации</label>
                    <select id="published" name="published" class="form-control">
                        <option value="0">Не опубликован</option>
                        @if($item->published)
                            <option value="1" selected="selected">Опубликован</option>
                        @else
                            <option value="1">Опубликован</option>
                        @endif
                    </select>
                    <input type="checkbox" name="redirect" id="redirect" style="display: none">

                </div>
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
    <script src="{{ secure_asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ secure_asset('/plugins/editors/CKEditor/v5/ckeditor.js') }}"></script>
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script>
        $("#publication_date").datetimepicker({
            lang:'ru',
            format:'d.m.Y',
            // formatTime:'H:i',
            formatDate:'d.m.Y',
            timepicker:false,
            datepicker:true,
        });
        $('#button-select-image').on('click', function() {
        	selectFileWithCKFinder( 'preview_image' );
        });
    </script>
@endsection
