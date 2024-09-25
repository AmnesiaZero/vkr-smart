@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Список отделений организации</h2>
            <div>
                <a href="{{ route('departments.add')}}" class="btn btn-danger add-button"><i class="fas fa-plus"></i> Добавить</a>
            </div>
        </div>
        <div class="list-body">
            <table class="table table-responsive">
                <thead class="thead-light">
                    <tr>
                        <th colspan="6">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Список отделений</h5>
                                <form action="{{route('departments.index')}}">
                                    <label class="m-0">
                                        <select name="organization_id" id="main_organizations_list" class="form-control">
                                            <option value="">-- Выберите организацию --</option>
                                            @if(isset($organizations) && !empty($organizations))
                                                @foreach($organizations as $organization)
                                                    <option value="{{ $organization->id }}" @if(request()->organization_id == $organization->id) selected @endif>
                                                        {{ $organization->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </label>
                                    <input type="checkbox" checked name="with_trashed" style="display: none">
                                </form>
                            </div>
                        </th>
                    </tr>
                    <tr class="col-title">
                        <th class="id">
                            #
                        </th>
                        <th>
                            Название отделения
                        </th>
                        <th class="status text-center">
                            Статус
                        </th>
                        <th class="actions">
                            Действия
                        </th>
                    </tr>
                </thead>
                <tbody id="departments_list">
                    @if(isset($departments) && count($departments)>0)
                        @foreach($departments as $item)
                            @include('templates.dashboard.platform.organization.departments.inc.item-row', array(
                                'item'=>$item,
                            ))
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
                                Подразделения не найдены
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('select[name="organization_id"]').on('change', function(e) {
            $(this).closest('form').submit();
        });
    </script>
    <script src="/js/dashboard/platform/organization/departments.js"></script>

    <script id="status_tmpl" type="text/x-jquery-tmpl">
	     <a onclick="updateStatus(${id})" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas @{{if is_blocked}} fa-lock blocked @{{else}} fa-lock-open unblocked @{{/if}}"></i></a>
    </script>
@endsection
