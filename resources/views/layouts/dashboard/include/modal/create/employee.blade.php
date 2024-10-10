<div class="modal fade" id="create_employee" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #fff;">
            <div class="modal-header">
                <h4 class="modal-title">Добавить сотрудника</h4>
            </div>
            <div class="modal-body p-4">
                <form method="post" id="create_employee_form" class="d-flex flex-column gap-2"
                      onsubmit="createEmployee();return false;">
                    <div class="row g-3">
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">ФИО</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" required placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" name="email" required placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Логин</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="login" required placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Пароль</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" name="password" required placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Номер телефона</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="phone" placeholder="+7-999-999-99-99">
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Дата рождения</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" name="date_of_birth">
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Пол</label>
                            <div class="col-sm-12">
                                <select name="gender" class="selectpicker form-control">
                                    <option value="1">Муж.</option>
                                    <option value="2">Жен.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Статус</label>
                            <div class="col-sm-12">
                                <select name="is_active" class="selectpicker form-control">
                                    <option value="1">Активен</option>
                                    <option value="0">Заблокирован</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="bc-post-title m-0 pt-4">Определение уровня доступа</h4>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Год выпуска</label>
                            <div class="col-sm-12">
                                <select class=" form-control" name="year_id" id="years_list" required title="Выбрать...">

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Факультет</label>
                            <div class="col-sm-12">
                                <select class="selectpicker form-control" name="faculty_id" id="faculties_list"
                                        data-title="Выбрать..." required>
                                    <option value="" selected>Уточните год</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 justify-content-center">
                            <label class="col-sm-12">Кафедры</label>
                            <div class="col-sm-12">
                                <select name="departments_ids[]" id="departments_menu_list"
                                        class="selectpicker form-control bs-select-hidden" data-title="Выбрать несколько..."
                                        data-width="100%" multiple required>
                                    <option value="" selected>Уточните факультет</option>
                                </select>
                            </div>
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
