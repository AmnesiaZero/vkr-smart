@extends('layouts.dashboard.'.config('settings.dashboard_theme').'.index')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Новое отделение</h2>
        </div>
        <form id="formContent" action="{{ route('dashboard.organizations.departments.store') }}" data-action-index="{{ route('dashboard.organizations.departments.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="organization_id">Выберите организацию</label>
                            <select id="organization_id" name="organization_id" class="form-control">
                                <option value="">-- Выберите организацию --</option>
                                @if(isset($organizations) && !empty($organizations))
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Название отделения</label>
                            <input id="title" type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Дополнительная информация</label>
                            <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="chief_id" value="{{ $user->id }}">
                            <input type="hidden" name="id" value="0" />
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
    </script>
@endsection
