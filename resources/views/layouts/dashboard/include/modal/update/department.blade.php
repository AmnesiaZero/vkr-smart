<div class="modal" id="update_department">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Редактирование кафедры</h4>
            </div>
            <form onsubmit="updateDepartment(${id});return false;" id="department_update_${id}">
                <div class="modal-body">
                    <div class="row g-0">
                        <div class="col-sm-3">
                            <p class="fs-15 fw-bold m-0">Название:</p>
                        </div>
                        <div class="col-sm-9">
                            <input id="edited1" type="text" name="name"
                                   class="form-control box-shadow-none fs-15 p-0 px-2 py-1 br-2 edited w-100"
                                   value="">
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-sm-3">
                            <p class="fs-15 fw-bold m-0">Дополнительная информация:</p>
                        </div>
                        <div class="col-sm-9">
                            <input id="edited1" type="text" name="description"
                                   class="form-control box-shadow-none fs-15 p-0 px-2 py-1 br-2 edited w-100"
                                   value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
