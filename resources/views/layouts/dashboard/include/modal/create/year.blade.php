<div class="modal fade" id="create_year">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-white">

            <div class="modal-header">
                <h4 class="modal-title">Добавление года выпуска</h4>
            </div>

            <form method="post" id="yearForm"
                  onsubmit="createYear(); return false;">
                <div class="modal-body d-flex flex-column gap-3">
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
