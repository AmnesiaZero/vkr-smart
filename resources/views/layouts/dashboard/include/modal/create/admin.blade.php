<div class="modal fade" id="create_admin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: #fff;">
            <div class="modal-header">
                <h4 class="modal-title">Создать администратора</h4>
            </div>
            <div class="modal-body p-4">
                <form method="post" id="create_admin_form" class="d-flex flex-column gap-2"
                      onsubmit="createAdmin();return false;">

                    <div class="d-flex flex-column gap-3"><div class="row justify-items-center">
                            <label class="col-sm-4">ФИО</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" required="" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" required="" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Логин</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="login" required="" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Пароль</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password" required="" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Номер телефона</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" placeholder="+7-999-999-99-99">
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Дата рождения</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_of_birth">
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Пол</label>
                            <div class="col-sm-8">
                                <select name="gender" class="selectpicker form-control">
                                    <option value="1">Муж.</option>
                                    <option value="2">Жен.</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-items-center">
                            <label class="col-sm-4">Статус</label>
                            <div class="col-sm-8">
                                <select name="is_active" class="selectpicker form-control">
                                    <option value="1">Активен</option>
                                    <option value="0">Заблокирован</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer br-none pe-0">
                        <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
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

