<div class="modal fade create-modal" id="add_department" style="display: none">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #fff;">
            <div class="modal-header">
                <h4 class="modal-title">Создать кафедру</h4>
            </div>
            <div class="modal-body p-4">
                <form method="post" id="add_department_form" class="d-flex flex-column gap-2"
                      onsubmit="addDepartment();return false;">
                    <div class="row">
                        <label class="col-sm-4">Год выпуска</label>
                        <div class="col-sm-8">
                            <select class="selectpicker form-control" id="add_department_years_list" required
                            title="Выберите...">

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">Факультет</label>
                        <div class="col-sm-8">
                            <select class="selectpicker form-control" id="add_department_faculties_list"
                                    title="Выбрать..." required>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4">Кафедры</label>
                        <div class="col-sm-8">
                            <select name="departments_ids[]" id="add_departments_menu_list"
                                    class="selectpicker form-control bs-select-hidden" title="Выбрать несколько..."
                                    data-width="100%" multiple required>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer br-none pe-0">
                        <button type="submit" class="btn btn-secondary fs-14 text-grey py-1">
                            Применить
                        </button>
                        <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                            Закрыть
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
