@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Список отделений организации</h2>
            <div class="cursor-p" type="button" data-bs-toggle="modal" data-bs-target="#add_department_modal">
                <a class="btn btn-danger add-button"><i class="fas fa-plus"></i> Добавить</a>
            </div>
        </div>
        <div class="list-body">
            <div class="filter">
                <table class="table">
                    <thead>
                    <tr class="table-dark">
                        <th scope="col" class="filter"><i class="fa-solid fa-sliders me-2" aria-hidden="true"></i>Фильтр</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div>
                                <form id="search_departments_form" onsubmit="searchDepartments();return false">
                                    <div class="mb-3">
                                        <label for="name" class="form-label d-none">Логин</label>
                                        <input id="name" type="text" name="name" value="" placeholder="Название организации" class="form-control">
                                    </div>
                                    <div>
                                        <a class="d-block w-100 mb-2 btn btn-outline-secondary" onclick="resetSearch();return false">Очистить</a>
                                        <button type="submit" class="d-block w-100 btn btn-primary">Применить</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <table class="table table-responsive">
                <thead class="thead-light">
                <tr>
                    <th colspan="6">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Список отделений</h5>
                            <form id="search_departments_form" onsubmit="searchDepartments();return false">
                                <label class="m-0">
                                    <select name="organization_id" class="form-control" id="organizations_list">
                                        <option value="" selected id="default_organization">-- Выберите организацию --</option>
                                        @if(isset($organizations) && !empty($organizations))
                                            @foreach($organizations as $organization)
                                                <option value="{{$organization->id}}">{{$organization->name}} </option>
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
        </div>
    </div>

    @include('templates.dashboard.platform.organization.departments.create')

{{--    @include('templates.dashboard.platform.organization.departments.inc.item-row')--}}
@endsection

@section('scripts')
    @include('layouts.dashboard.include.tmpls.modal.update.department')
    <script src="/js/dashboard/platform/organization/departments.js"></script>
    @include('templates.dashboard.platform.organization.departments.inc.department_tmpl')
    @include('layouts.dashboard.include.tmpls.info.department')
    <script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>
    </script>
    <script id="year_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${year}</option>
    </script>


@endsection
