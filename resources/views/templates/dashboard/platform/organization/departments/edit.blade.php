@extends('templates.dashboard.' . config('settings.dashboard_theme') . '.index')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование отделения: {{ $item->title }}</h2>
        </div>
        <form id="formContent" action="{{ route('dashboard.organizations.departments.update', $item->id) }}" data-action-index="{{ route('dashboard.organizations.departments.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="title">Название отделения</label>
                            <input id="title" type="text" name="title" value="{{ $item->title }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Дополнительная информация</label>
                            <textarea id="description" name="description" rows="4" class="form-control">{{ $item->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" value="{{ $item->id }}">
                        </div>
                    </div>
                </div>
                <div class="col-4">
{{--                    <div class="form-group">--}}
{{--                        <label for="is_blocked">Организация заблокирована</label>--}}
{{--                        <select id="is_blocked" name="is_blocked" class="form-control">--}}
{{--                            <option value="0">Нет</option>--}}
{{--                            <option value="1">Да</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="date_start">Дата начала доступа</label>--}}
{{--                        <div class="input-group">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span id="date-start" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>--}}
{{--                            </div>--}}
{{--                            <input id="date_timepicker_start" type="text" name="date_start" aria-describedby="date-start" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="date_end">Дата окончания доступа</label>--}}
{{--                        <div class="input-group">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span id="date-end" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>--}}
{{--                            </div>--}}
{{--                            <input id="date_timepicker_end" type="text" name="date_end" aria-describedby="date-end" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <h3 class="mb-3">Доп. параметры</h3>--}}
{{--                    <div class="form-group">--}}
{{--                        <div class="custom-control custom-switch">--}}
{{--                            <input id="is_head" type="checkbox" value="1" class="custom-control-input" @if($item->is_head) checked @endif>--}}
{{--                            <label for="is_head" class="custom-control-label" style="font-size: 14px; font-weight: normal">Головная организация</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <div class="custom-control custom-switch">--}}
{{--                            <input id="is_premium" type="checkbox" value="1" class="custom-control-input" @if($item->is_premium) checked @endif>--}}
{{--                            <label for="is_premium" class="custom-control-label" style="font-size: 14px; font-weight: normal">Доступ Premium (все издания доступны)</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <div class="custom-control custom-switch">--}}
{{--                            <input id="is_testing" type="checkbox" value="1" class="custom-control-input" @if($item->is_testing) checked @endif>--}}
{{--                            <label for="is_testing" class="custom-control-label" style="font-size: 14px; font-weight: normal">Тестовый доступ</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <div class="custom-control custom-switch">--}}
{{--                            <input id="is_demo" type="checkbox" value="1" class="custom-control-input" @if($item->is_demo) checked @endif>--}}
{{--                            <label for="is_demo" class="custom-control-label" style="font-size: 14px; font-weight: normal">Демо-организация (для презентаций и технических работ)</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <h3 class="mb-3">Структура организации</h3>--}}
{{--                    <div class="d-flex justify-content-between">--}}
{{--                        <button type="button" data-toggle="modal" data-target="#modalDepartments" data-organization-id="{{ $item->id }}" class="btn btn-info" style="width: 48%;"><i class="fas fa-network-wired"></i> Отделения</button>--}}
{{--                        <button type="button" data-toggle="modal" data-target="#modalDepartments" data-organization-id="{{ $item->id }}" class="btn btn-info" style="width: 48%;"><i class="fas fa-users"></i> Группы</button>--}}
{{--                    </div>--}}
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
    <script>
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

        $('#modalDepartments').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let organizationID = button.data('organization-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/departments',
                data: '',
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                },
                error: function(jqXHR, Exception) {
                    console.log(jqXHR);
                }
            });
            // let modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            // modal.find('.modal-body input').val(recipient)
        })
    </script>
@endsection
