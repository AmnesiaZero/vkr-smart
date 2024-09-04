@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование организации: {{ $organization->name }}</h2>
        </div>
        <form id="organization_form" enctype="multipart/form-data"  action="{{ route('organizations.update', ['id' => $organization->id] )}}"  method="POST">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="title">Название организации</label>
                            <input id="title" type="text" name="name" value="{{ $organization->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Является связанной для организации:</label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="0">--Выберите--</option>
                                @if(isset($parents) && !empty($parents))
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" @if($parent->id == $organization->parent_id) selected @endif>{{ $parent->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="logo">Логотип</label>
                            <div class="input-group">
                                <input id="logo" type="text" value="{{ $organization->logo }}" class="form-control" placeholder="Выберите изображение" aria-label="Выберите изображение" aria-describedby="button-select-image">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-select-image" onclick="toggleFile('logo_load')">Загрузить</button>
                                </div>
                            </div>
                            <input type="file" id="logo_load" name="logo" style="display: none">
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <input id="address" type="text" name="address" value="{{ $organization->address }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input id="phone" type="text" name="phone" value="{{ $organization->phone }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="website">Сайт</label>
                            <input id="website" type="text" name="website" value="{{ $organization->website }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="text" name="email" value="{{ $organization->email }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="info">Дополнительная информация</label>
                            <textarea id="info" name="info" rows="4" class="form-control editor">{{ $organization->info }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="start_date">Дата начала доступа</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="date-start" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input id="date_timepicker_start" type="text" name="start_date" value="@if($organization->start_date) {{ \Carbon\Carbon::parse($item->start_date)->format('d.m.Y') }} @endif" aria-describedby="date-start" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date">Дата окончания доступа</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span id="date-end" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input id="date_timepicker_end" type="text" name="end_date" value="@if($organization->end_date) {{ \Carbon\Carbon::parse($item->end_date)->format('d.m.Y') }} @endif" aria-describedby="date-end" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_head">Голованя организация</label>
                            <select id="is_head" name="is_head" class="form-control">
                                <option value="0" @if(!$organization->is_head) selected @endif>Нет</option>
                                <option value="1" @if($organization->is_head) selected @endif>Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_premium">Доступ Premium (все издания доступны)</label>
                            <select id="is_premium" name="is_premium" class="form-control">
                                <option value="0" @if(!$organization->is_premium) selected @endif>Нет</option>
                                <option value="1" @if($organization->is_premium) selected @endif>Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_testing">Тестовый доступ</label>
                            <select id="is_testing" name="is_testing" class="form-control">
                                <option value="0" @if(!$organization->is_testing) selected @endif>Нет</option>
                                <option value="1" @if($organization->is_testing) selected @endif>Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_demo">Демо-организация (для презентаций и технических работ)</label>
                            <select name="is_demo" class="form-control" id="published">
                                <option value="0" @if(!$organization->is_demo) selected @endif>Нет</option>
                                <option value="1" @if($organization->is_demo) selected @endif>Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_blocked">Организация заблокирована</label>
                            <select id="is_blocked" name="is_blocked" class="form-control">
                                <option value="0" @if(!$organization->is_blocked) selected @endif>Нет</option>
                                <option value="1" @if($organization->is_blocked) selected @endif>Да</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="checkbox" id="redirect" name="redirect" style="display: none;">

            </div>
        </form>
        <div class="form-group">
            <button id="save-close" class="btn btn-primary">Сохранить и закрыть</button>
            <button id="save" class="btn btn-primary">Сохранить</button>
            <button id="close" class="btn btn-secondary">Отмена</button>
        </div>
    </div>
    @include('templates.dashboard.platform.organization.organizations.inc.modal_departments')
    {{--    @include('templates.dashboard.' . config('settings.dashboard_theme') . '.pages.organizations.inc.modal_groups')--}}
@endsection

@section('scripts')
    <script src="{{ secure_asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ secure_asset('/plugins/jquery/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ secure_asset('/plugins/editors/CKEditor/v5/ckeditor.js') }}"></script>
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script src="/js/dashboard/platform/organization/organizations.js"></script>

@endsection
