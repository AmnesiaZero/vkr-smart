
<div class="modal fade" id="add_department_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавление работы</h3>
            </div>
            <form class="form form-horizontal" id="create_department_form" onsubmit="createDepartment();return false">
                <div class="modal-body">

                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <label class="col-sm-4">Организация</label>
                            <div class="col-sm-8">
                                <select name="organization_id" class="form-control" id="organizations_list" data-width="100%">
                                    <option value="">Выбрать...</option>
                                    @if(isset($organizations) and is_iterable($organizations))
                                        @foreach($organizations as $organization)
                                            <option value="{{$organization->id}}">{{$organization->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Год выпуска</label>
                            <div class="col-sm-8">
                                <select name="year_id" class="form-control" id="years_list" data-width="100%">
                                    <option value="" disabled="" selected="selected">Уточните организацию</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Факультет</label>
                            <div class="col-sm-8">
                                <select name="faculty_id" class="form-control" id="faculties_list" data-width="100%">
                                    <option value="" disabled="" selected="selected">Уточните год выпуска</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Название подразделения</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Дополнительная информация</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="description" placeholder="Ввод..." required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
                        Добавить
                    </button>
                    <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                        Закрыть
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

