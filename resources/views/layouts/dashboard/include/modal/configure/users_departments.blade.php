<div class="modal fade" id="configure_user_departments" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Настройка доступа для проверяющих</h3>
            </div>
            <form class="form form-inline" onsubmit="configureUserDepartments(); return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5>Выберите те кафедры,которыми будет управлять сотрудник </h5>
                            <div id="checking-access-alert"></div>
                            <nav class="navbar navbar-default">
                                <ul class="nav gap-3" id="user_access_years_list">

                                </ul>
                            </nav>

                            <div class="list-group list-group-sm gap-2 pt-4">
                                <p class="m-0">
                                    <input id="checking_departments" type="checkbox">
                                    <label for="checking_departments">Выбрать все</label>
                                </p>
                                <div id="departments_list">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
                            Сохранить
                        </button>
                        <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1"
                                data-bs-dismiss="modal">
                            Закрыть
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>






