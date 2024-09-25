@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование пользователя: {{ $user->name }}</h2>
        </div>
        <form id="users_form" enctype="multipart/form-data"  action="{{ route('users.edit', ['id' => $user->id]) }}" data-action-index="" method="POST">
            @csrf
            <div class="post">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="name">ФИО пользователя</label>
                            <input id="name" type="text" name="name" value="{{ $user->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="text" name="email" value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input id="login" type="text" name="login" value="{{ $user->login }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="organization_id">Организация</label>
                            <select id="organization_id" name="organization_id" class="form-control">
                                <option value="">-- Выберите --</option>
                                @isset($organizations)
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" @if($user->organization_id == $organization->id) selected @endif>{{ $organization->name }}</option>
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
                                        <option value="{{ $role->slug }}" @if($user->roles[0]->slug == $role->slug) selected @endif>{{ $role->name }}</option>
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
                            <label for="info">Информация о пользователе</label>
                            <textarea id="info" name="info" rows="7" class="form-control">{{ $user->info }}</textarea>
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
@endsection
