@extends('layouts.dashboard.'.config('settings.dashboard_theme').'.index')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Новая организация</h2>
        </div>
        <form id="formContent" action="{{ route('dashboard.organizations.store') }}" data-action-index="{{ route('dashboard.organizations.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="title">Название организации</label>
                            <input id="title" type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Является связанной для организации:</label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="">--Выберите--</option>
                                @if(isset($parents) && !empty($parents))
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="logo">Логотип</label>
                            <div class="input-group">
                                <input id="logo" type="text" name="logo" class="form-control" placeholder="Выберите изображение" aria-label="Выберите изображение" aria-describedby="button-select-image">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-select-image">Загрузить</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <input id="address" type="text" name="address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input id="phone" type="text" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="website">Сайт</label>
                            <input id="website" type="text" name="website" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="info">Дополнительная информация</label>
                            <textarea id="info" name="info" rows="4" class="form-control editor"></textarea>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="date_start">Дата начала доступа</label>--}}
{{--                            <div class="input-group">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <span id="date-start" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>--}}
{{--                                </div>--}}
{{--                                <input id="date_timepicker_start" type="text" name="date_start" aria-describedby="date-start" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="date_end">Дата окончания доступа</label>--}}
{{--                            <div class="input-group">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <span id="date-end" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>--}}
{{--                                </div>--}}
{{--                                <input id="date_timepicker_end" type="text" name="date_end" aria-describedby="date-end" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        {{--<div class="form-group">
                            <label for="is_head">Голованя организация</label>
                            <select id="is_head" name="is_head" class="form-control">
                                <option value="0">Нет</option>
                                <option value="1">Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_premium">Доступ Premium (все издания доступны)</label>
                            <select id="is_premium" name="is_premium" class="form-control">
                                <option value="0">Нет</option>
                                <option value="1">Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_testing">Тестовый доступ</label>
                            <select id="is_testing" name="is_testing" class="form-control">
                                <option value="0">Нет</option>
                                <option value="1">Да</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_demo">Демо-организация (для презентаций и технических работ)</label>
                            <select name="is_demo" class="form-control" id="published">
                                <option value="0">Нет</option>
                                <option value="1">Да</option>
                            </select>
                        </div>
                        --}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_blocked">Организация заблокирована</label>--}}
{{--                            <select id="is_blocked" name="is_blocked" class="form-control">--}}
{{--                                <option value="0">Нет</option>--}}
{{--                                <option value="1">Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <input type="hidden" name="id" value="0" />
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="is_blocked">Организация заблокирована</label>
                        <select id="is_blocked" name="is_blocked" class="form-control">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_start">Дата начала доступа</label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span id="date-start" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="date_timepicker_start" type="text" name="date_start" aria-describedby="date-start" class="form-control" autocomplete="off">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Укажите дату в формате <strong>yyyy/mm/dd</strong></small>
                    </div>
                    <div class="form-group">
                        <label for="date_end">Дата окончания доступа</label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span id="date-end" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="date_timepicker_end" type="text" name="date_end" aria-describedby="date-end" class="form-control" autocomplete="off">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Укажите дату в формате <strong>yyyy/mm/dd</strong></small>
                    </div>
                    <h3 class="mb-3">Доп. параметры</h3>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_head" type="checkbox" name="is_head" value="1" class="custom-control-input">
                            <label for="is_head" class="custom-control-label" style="font-size: 14px; font-weight: normal">Головная организация</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_basic" type="checkbox" name="is_basic" value="1" class="custom-control-input">
                            <label for="is_basic" class="custom-control-label" style="font-size: 14px; font-weight: normal">Базовый доступ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_premium" type="checkbox" name="is_premium" value="1" class="custom-control-input">
                            <label for="is_premium" class="custom-control-label" style="font-size: 14px; font-weight: normal">Доступ Premium (все издания доступны)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_testing" type="checkbox" name="is_testing" value="1" class="custom-control-input">
                            <label for="is_testing" class="custom-control-label" style="font-size: 14px; font-weight: normal">Тестовый доступ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_demo" type="checkbox" name="is_demo" value="1" class="custom-control-input">
                            <label for="is_demo" class="custom-control-label" style="font-size: 14px; font-weight: normal">Демо-организация (для презентаций и технических работ)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="member_transfer_network" type="checkbox" name="member_transfer_network" value="1" class="custom-control-input">
                            <label for="member_transfer_network" class="custom-control-label" style="font-size: 14px; font-weight: normal">Участник сети трансферов</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="show_catalog" type="checkbox" name="show_catalog" value="1" class="custom-control-input">
                            <label for="show_catalog" class="custom-control-label" style="font-size: 14px; font-weight: normal">Отображать в каталоге</label>
                        </div>
                    </div>
                    <h3 class="mb-3">Структура организации</h3>
                    <div class="d-flex justify-content-between">
                        <button type="button" data-toggle="modal" data-target="#modalDepartments" class="btn btn-info" style="width: 48%;"><i class="fas fa-network-wired"></i> Отделения</button>
                        <button type="button" class="btn btn-info" style="width: 48%;"><i class="fas fa-users"></i> Группы</button>
                    </div>
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
    <script src="{{ secure_asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ secure_asset('/plugins/editors/CKEditor/v5/ckeditor.js') }}"></script>
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script>CKFinder.config({connectorPath: '/ckfinder/connector'});</script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script>
        $('#button-select-image').on('click', function () {
            selectFileWithCKFinder('logo');
        });

        jQuery(function(){
            jQuery('#date_timepicker_start').datetimepicker({
                lang: 'ru',
                format:'Y/m/d',
                scrollMonth: false,
                onShow:function( ct ){
                    this.setOptions({
                        maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
                    })
                },
                timepicker:false
            });
            jQuery('#date_timepicker_end').datetimepicker({
                lang: 'ru',
                format:'Y/m/d',
                scrollMonth: false,
                onShow:function( ct ){
                    this.setOptions({
                        minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
                    })
                },
                timepicker:false
            });
        });
    </script>
@endsection
