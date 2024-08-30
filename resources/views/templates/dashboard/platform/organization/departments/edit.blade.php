@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование отделения: {{ $department->title }}</h2>
        </div>
        <form id="formContent" action="/dashboard/organization/departments/update"  method="POST" onsubmit="redirect()">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="title">Название отделения</label>
                            <input id="title" type="text" name="title" value="{{ $department->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Дополнительная информация</label>
                            <textarea id="description" name="description" rows="4" class="form-control">{{ $department->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" value="{{ $department->id }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button id="save-close" type="submit" class="btn btn-primary">Сохранить и закрыть</button>
                <button id="save" class="btn btn-primary">Сохранить</button>
                <button id="close" class="btn btn-secondary">Отмена</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ secure_asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="/js/dashboard/platform/organization/departments.js"></script>
{{--    <script>--}}

{{--        jQuery(function(){--}}
{{--            jQuery('#date_timepicker_start').datetimepicker({--}}
{{--                lang: 'ru',--}}
{{--                format:'Y/m/d',--}}
{{--                scrollMonth: false,--}}
{{--                onShow:function( ct ){--}}
{{--                    this.setOptions({--}}
{{--                        maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false--}}
{{--                    })--}}
{{--                },--}}
{{--                timepicker:false--}}
{{--            });--}}
{{--            jQuery('#date_timepicker_end').datetimepicker({--}}
{{--                lang: 'ru',--}}
{{--                format:'Y/m/d',--}}
{{--                scrollMonth: false,--}}
{{--                onShow:function( ct ){--}}
{{--                    this.setOptions({--}}
{{--                        minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false--}}
{{--                    })--}}
{{--                },--}}
{{--                timepicker:false--}}
{{--            });--}}
{{--        });--}}

{{--        $('#modalDepartments').on('show.bs.modal', function (event) {--}}
{{--            let button = $(event.relatedTarget);--}}
{{--            let organizationID = button.data('organization-id');--}}
{{--            $.ajax({--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                },--}}
{{--                method: 'POST',--}}
{{--                url: '/dashboard/organizations/departments',--}}
{{--                data: '',--}}
{{--                dataType: 'json',--}}
{{--                success: function(result) {--}}
{{--                    console.log(result);--}}
{{--                },--}}
{{--                error: function(jqXHR, Exception) {--}}
{{--                    console.log(jqXHR);--}}
{{--                }--}}
{{--            });--}}
{{--            // let modal = $(this)--}}
{{--            // modal.find('.modal-title').text('New message to ' + recipient)--}}
{{--            // modal.find('.modal-body input').val(recipient)--}}
{{--        })--}}
{{--    </script>--}}
@endsection
