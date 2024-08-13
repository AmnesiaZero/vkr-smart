<div class="modal fade" id="update_work_specialty_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Редактирование направления подготовки квалификационной работы</h3>
            </div>
            <form class="form form-horizontal" id="update_work_specialty_form" onsubmit="updateWorkSpecialty(); return false;">
                <div class="modal-body">
                    <div class="d-flex flex-column gap-4">
                        <div class="row">
                            <label class="col-sm-3">Год выпуска</label>
                            <div class="col-sm-9">
                                <select name="year_id" class="form-control" id="update_years_list" data-width="100%">
                                    <option value="">Выбрать...</option>
                                    @if(isset($years) and is_iterable($years))
                                        @foreach($years as $year)
                                            <option value="{{$year->id}}">{{$year->year}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3">Подразделение</label>
                            <div class="col-sm-9">
                                <select name="faculty_id" class="form-control" id="update_faculties_list" data-width="100%">
                                    <option value="" disabled="" selected="selected">Уточните год выпуска</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3">Кафедра</label>
                            <div class="col-sm-9">
                                <select name="department_id" class="form-control" id="update_departments_list" data-width="100%">
                                    <option value="" disabled="" selected="selected">Уточните подразделение</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3">Направление подготовки (специальность)</label>
                            <div class="col-sm-9">
                                <select name="specialty_id" class="form-control" id="update_specialties_list" data-width="100%">
                                    <option value="" disabled="" selected="selected">Уточните кафедру</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
                        Изменить
                    </button>
                    <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                        Закрыть
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
