@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование отделения: {{ $department->name }}</h2>
        </div>
        <form id="departments_form" action="{{ route('departments.edit', ['id' => $department->id])}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="title">Название отделения</label>
                            <input id="title" type="text" name="name" value="{{ $department->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Дополнительная информация</label>
                            <textarea id="description" name="description" rows="4" class="form-control">{{ $department->description }}</textarea>
                        </div>
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
    <script src="/js/dashboard/platform/organization/departments.js"></script>
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
        })
    </script>

    <script id="year_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${year}</option>
    </script>


    <script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>
    </script>
@endsection
