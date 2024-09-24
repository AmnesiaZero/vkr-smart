@extends('layouts.dashboard.platform')

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
        <form id="users_form" enctype="multipart/form-data" action="{{route('users.store')}}" method="POST">
            @csrf
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
                            <label for="avatar">Аватар</label>
                            <div class="input-group">
                                <input id="avatar" type="text" value="@if(isset($user) and $user->avatar_file_name) {{$user->avatar_file_name}} @endif" class="form-control"
                                       placeholder="Выберите изображение" aria-label="Выберите изображение"
                                       aria-describedby="button-select-image" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-select-image"
                                            onclick="toggleFile('avatar_load')">Загрузить
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="avatar_load" name="avatar" style="display: none">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Информация о пользователе</label>
                            <textarea id="description" name="description" rows="7" class="form-control"></textarea>
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
    <script src="/js/dashboard/platform/users.js"></script>
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
