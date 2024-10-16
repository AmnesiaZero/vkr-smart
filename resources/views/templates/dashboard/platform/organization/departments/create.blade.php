@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Новое отделение</h2>
        </div>
        <form id="departments_form" action="{{ route('departments.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="organizations_list">Выберите организацию</label>
                            <select id="organizations_list" name="organization_id" class="form-control">
                                <option value="">-- Выберите организацию --</option>
                                @if(isset($organizations) && !empty($organizations))
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="years_list">Выберите год выпуска:</label>
                            <select id="years_list" name="year_id" class="form-control">
                                <option> Выберите организацию</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="faculties_list">Выберите факультет:</label>
                            <select id="faculties_list" name="faculty_id" class="form-control">
                                <option> Выберите год выпуска</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Название отделения</label>
                            <input id="title" type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Дополнительная информация</label>
                            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                        </div>
                        <input type="checkbox" name="redirect" id="redirect" style="display: none">
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
    <script src="/js/dashboard/platform/organization/departments.js"></script>
    <script src="{{ secure_asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script>
        jQuery(function () {
            jQuery('#date_timepicker_start').datetimepicker({
                lang: 'ru',
                format: 'Y/m/d',
                scrollMonth: false,
                onShow: function (ct) {
                    this.setOptions({
                        maxDate: jQuery('#date_timepicker_end').val() ? jQuery('#date_timepicker_end').val() : false
                    })
                },
                timepicker: false
            });
            jQuery('#date_timepicker_end').datetimepicker({
                lang: 'ru',
                format: 'Y/m/d',
                scrollMonth: false,
                onShow: function (ct) {
                    this.setOptions({
                        minDate: jQuery('#date_timepicker_start').val() ? jQuery('#date_timepicker_start').val() : false
                    })
                },
                timepicker: false
            });
        });
    </script>

    <script id="year_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${year}</option>

    </script>


    <script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>

    </script>
@endsection
