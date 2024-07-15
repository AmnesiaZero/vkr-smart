<div class="modal fade" id="create_year">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white">

            <div class="modal-header">
                <h4 class="modal-title">Добавление года выпуска</h4>
            </div>

            <div class="modal-body">
                <form method="post" id="yearForm" class="d-flex flex-column gap-3"
                      onsubmit="createYear(); return false;">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="year" class="fw-bold fs-15">Год</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control fs-14" id="year" name="year">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="comment" class="fw-bold ">Комментарий</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control fs-14" id="comment" name="comment">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <label for="students_count" class="fw-bold ">Количество студентов</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control fs-14" id="students_count" name="students_count">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" onclick="closeModal('create_year')">
                    Добавить
                </button>
                <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
