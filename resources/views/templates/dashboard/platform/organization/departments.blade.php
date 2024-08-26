@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Список отделений организации</h2>
            <div>
                <a href="" class="btn btn-danger add-button"><i class="fas fa-plus"></i> Добавить</a>
            </div>
        </div>
        <div class="list-body">
            <table class="table table-responsive">
                <thead class="thead-light">
                <tr>
                    <th colspan="6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Список отделений</h5>
                            <form action="">
                                <label class="m-0">
                                    <select name="organization_id" class="form-control">
                                        <option value="">-- Выберите организацию --</option>
                                        @if(isset($organizations) && !empty($organizations))
                                            @foreach($organizations as $organization)
                                                <option value="{{ $organization->id }}" @if(request()->organization_id == $organization->id) selected @endif>{{ $organization->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </label>
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
                </tbody>
            </table>
            @include('layouts.dashboard.include.modal.update.department')
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

    <script id="department_tmpl" type="text/x-jquery-tmpl">
        <tr id="rowID_${id}" class="rows  @{{if deleted_at}} deleted @{{/if}}">
            <td class="id">
               ${id}
            </td>
            <td class="title">
                <a href="" class="name">${name}</a>
            </td>
            <td class="status-blocked text-center">
                @{{if deleted_at}}
                <i class="far fa-circle"></i>
                   @{{if is_blocked}}
                        <a href="" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas fa-lock blocked"></i></a>
                   @{{else}}
                        <a href="" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas fa-lock unblocked"></i></a>
                   @{{/if}}
                @{{else}}
                <a href="" id="status_${id}" data-item-id="${id}" class="toggle-blocked-status"><i id="stat_${id}" class="fas fa-lock-open unblocked"></i></a>
                @{{/if}}
            </td>
            <td class="actions text-center">
                @{{if deleted_at}}
                <a href="" id="status_${id}" data-item-id="${id}" class="restore d-inline mr-2">
                <i id="stat_${id}" class="icon fas fa-trash-restore"></i>
                </a>
                <a href="" data-item-id="${id}" class="delete d-inline">
                    <i class="icon far fa-trash-alt"></i>
                </a>
                @{{else}}
                <a href="" class="d-inline mr-2" data-bs-toggle="modal" data-bs-target="#update_department">
                <i class="icon fas fa-edit" ></i>
                </a>
                <a href="" data-item-id="${id}" class="destroy d-inline">
                    <i class="icon far fa-trash-alt"></i>
                </a>
                @{{/if}}
            </td>
        </tr>

    </script>
@endsection
