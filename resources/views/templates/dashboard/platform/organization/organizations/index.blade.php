@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Организации</h2>
            <div>
                <a href="{{ route('organizations.add') }}" class="btn btn-danger add-button"><i
                        class="fas fa-plus"></i> Добавить</a>
            </div>
        </div>
        <div class="list-body">
            <table class="table table-responsive">
                <thead class="thead-light">
                <tr>
                    <th colspan="7">
                        Список организаций
                    </th>
                </tr>
                <tr class="col-title">
                    <th class="id">
                        #
                    </th>
                    <th>
                        Название организации
                    </th>
                    <th class="text-center">
                        Доступ
                    </th>
                    <th class="status text-center">
                        Базовый
                    </th>
                    <th class="status text-center">
                        Премиум
                    </th>
                    <th class="status text-center">
                        Статус
                    </th>
                    <th class="actions">
                        Действия
                    </th>
                </tr>
                </thead>
                @if(isset($organizations) && count($organizations) > 0)
                    @foreach($organizations as $item)
                        @include('templates.dashboard.platform.organization.organizations.inc.item-row', array(
                            'item'=>$item,
                        ))
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">
                            Нет элементов для отображения
                        </td>
                    </tr>
                @endif
            </table>
{{--            {{ $organizations->links() }}--}}
        </div>
    </div>
@endsection
