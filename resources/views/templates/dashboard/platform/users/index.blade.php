@extends('layouts.dashboard.platform')

@section('styles')
    <link rel="stylesheet" href="{{ secure_asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@endsection

@section('content')
    <div class="list">
        <div class="row">
            <div class="col-lg-3">
                <h2 class="block-title mb-3">Фильтр</h2>
                <form action="{{ route('users.filter') }}">
                    <div class="mb-3">
                        <label for="login">Логин</label>
                        <input id="login" type="text" name="login" value="{{ request()->input('login') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email">E-mail</label>
                        <input id="email" type="text" name="email" value="{{ request()->input('email') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="organization_id">Организация</label>
                        <select id="organization_id" name="organization_id" class="form-control">
                            <option value="">Все организации</option>
                            @if(isset($organizations))
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" @if(request()->organization_id == $organization->id) selected @endif>{{ $organization->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Сбросить</a>
                        <input type="submit" value="Фильтровать" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <div class="col-lg-9">
                <div class="list-header">
                    <h2 class="block-title">Список пользователей</h2>
                    <div>
                        <a href="{{ route('dashboard.users.create') }}" class="btn btn-danger add-button"><i class="fas fa-plus"></i> Добавить</a>
                    </div>
                </div>
                <div class="list-body">
                    <table class="table table-responsive">
                        <thead class="thead-light">
                        <tr>
                            <th colspan="4">
                                Список пользователей
                            </th>
                        </tr>
                        <tr class="col-title">
                            <th class="id">
                                #
                            </th>
                            <th>
                                ФИО пользователя
                            </th>
                            <th class="status text-center">
                                Статус
                            </th>
                            <th class="actions">
                                Действия
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($users) && $users->total() > 0)
                            @foreach($users as $u)
                                @include('templates.dashboard.' . config('settings.dashboard_theme') . '.pages.users.inc.item-row', array(
                                    'user'=>$u,
                                ))
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
                                    Нет элементов для отображения
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ secure_asset('/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('#organization_id').select2({
            theme: 'bootstrap4'
        });
    </script>
@endsection
