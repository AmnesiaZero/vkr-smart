<div class="modal fade" id="inspectors_access_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Настройка доступа для проверяющих</h3>
            </div>
            <form class="form form-inline" id="checkingAccessForm"
                  onsubmit="configureInspectorsAccess(); return false;">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="mb-3">Выберите те направления подготовки, доступ к которым будет иметь
                                проверяющий
                                организации</h5>
                            <div id="checking-access-alert"></div>
                            <div id="checkingAccessFormListYears">
                                <nav class="navbar navbar-default">
                                    <ul class="nav gap-3" id="inspectors_access_years_list">

                                    </ul>
                                </nav>
                            </div>
                            <div id="checkingAccessFormList">

                                <div class="list-group list-group-sm gap-2">
                                    <p class="pt-3">
                                        <input id="checking_specialties" type="checkbox">
                                        <label for="checking_specialties">Выбрать все</label>
                                    </p>
                                    <div id="specialties_list">
                                    </div>
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
