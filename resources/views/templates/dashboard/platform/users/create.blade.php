@extends('layouts.dashboard.'.config('settings.dashboard_theme').'.index')

@section('styles')
    <link rel="stylesheet" href="{{ secure_asset('/plugins/bootstrap-select/v1.14.0/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Новый пользователь</h2>
        </div>
        <form id="formContent" action="{{ route('dashboard.users.store') }}" data-action-index="{{ route('dashboard.users.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="post">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="name">ФИО пользователя</label>
                            <input id="name" type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input id="login" type="text" name="login" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="organization_id">Организация</label>
                            <select id="organization_id" name="organization_id" class="form-control">
                                <option value="">-- Выберите --</option>
                                @isset($organizations)
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Подтвердите пароль</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="role">Тип учетной записи</label>
                            <select id="role" name="role" class="form-control">
                                <option value="">-- Выберите --</option>
                                @isset($roles)
                                    @foreach($roles as $role)
                                        <option value="{{ $role->slug }}">{{ $role->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post">Должность</label>
                            <input id="post" type="text" name="post" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="avatar">Аватар</label>
                            <div class="input-group">
                                <input id="avatar" type="text" name="avatar" class="form-control" placeholder="Выберите изображение" aria-label="Выберите изображение" aria-describedby="button-select-image">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-select-image">Выбрать</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_leading" type="checkbox" name="is_leading" value="1" class="custom-control-input">
                                <label for="is_leading" class="custom-control-label" style="font-size: 14px; font-weight: normal">Ведущий мероприятий</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_lector" type="checkbox" name="is_lector" value="1" class="custom-control-input">
                                <label for="is_lector" class="custom-control-label" style="font-size: 14px; font-weight: normal">Лектор</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_approved" type="checkbox" name="is_approved" value="1" class="custom-control-input">
                                <label for="is_approved" class="custom-control-label" style="font-size: 14px; font-weight: normal">Пользователь одобрен</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_blocked" type="checkbox" name="is_blocked" value="1" class="custom-control-input">
                                <label for="is_blocked" class="custom-control-label" style="font-size: 14px; font-weight: normal">Пользователь заблокирован</label>
                            </div>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label for="is_approved">Одобрен</label>--}}
{{--                            <select id="is_approved" name="is_approved" class="form-control">--}}
{{--                                <option value="0">Нет</option>--}}
{{--                                <option value="1">Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_limited">is_limited</label>--}}
{{--                            <select id="is_limited" name="is_limited" class="form-control">--}}
{{--                                <option value="0">Нет</option>--}}
{{--                                <option value="1">Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_blocked">Пользователь заблокирован?</label>--}}
{{--                            <select id="is_blocked" name="is_blocked" class="form-control">--}}
{{--                                <option value="0">Нет</option>--}}
{{--                                <option value="1">Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="info">Информация о пользователе</label>
                            <textarea id="info" name="info" rows="7" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" value="0">
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
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script src="{{ secure_asset('/plugins/bootstrap-select/v1.14.0/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ secure_asset('/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('#button-select-image').on('click', function() {
            selectFileWithCKFinder('avatar');
        });

        $('select#organization_id').select2({
            theme: 'bootstrap4',
            placeholder: '-- Выберите организацию --',
        })

        // $('select#organization_id').select2({
        //     placeholder: '-- Выберите организацию --',
        //     ajax: {
        //         url: "/api/organizations/get-organizations",
        //         dataType: 'json',
        //         delay: 500,
        //         data: function (params, page) {
        //             console.log(params);
        //             return {
        //                 s: params.term,
        //             };
        //         },
        //         processResults: function (data) {
        //             return {
        //                 results: data
        //             };
        //         },
        //         cache: true
        //     }
        // });
    </script>
@endsection
