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
            {{ $organizations->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/app.js"></script>
    <script src="/js/dashboard/platform/organization/organizations.js"></script>
    <script id="basic_status_tmpl" type="text/x-jquery-tmpl">
        <a onclick="updateBasic(${id})" id="basic_status_${id}" data-item-id="${id}" class="toggle-basic-status"><i id="basic_${id}" class="far @{{if is_basic}} fa-check-square basic @{{else}} fa-square not-basic @{{/if}}"></i></a>

    </script>

    <script id="premium_status_tmpl" type="text/x-jquery-tmpl">
	    <a onclick="updatePremium(${id})" id="premium_status_${id}" data-item-id="${id}" class="toggle-premium-status"><i id="premium_${id}" class="far @{{if is_premium}} fa-check-square premium @{{else}} fa-square not-premium @{{/if}}"></i></a>

    </script>

    <script id="status_tmpl" type="text/x-jquery-tmpl">
	     <a onclick="updateStatus(${id})" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas @{{if is_blocked}} fa-lock blocked @{{else}} fa-lock-open unblocked @{{/if}}"></i></a>

    </script>
@endsection
