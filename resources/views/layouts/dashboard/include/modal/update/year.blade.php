<div class="modal fade" id="update_year">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Редактирование года выпуска</h4>
                </div>
            </div>

            <form onsubmit="return false;">
                <div class="modal-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="row g-0">
                            <div class="col-sm-4">
                                <p class="fs-15 fw-bold m-0">Год:</p>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="year"
                                       class="form-control box-shadow-none fs-15 p-0 px-2 py-1 br-2 edited" value="">
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col-sm-4">
                                <p class="fs-15 fw-bold m-0">Количество обучающихся:</p>
                            </div>
                            <div class="col-sm-8">
                                <input id="edited2" type="text" name="students_count"
                                       class="form-control box-shadow-none fs-15 p-0 px-2 py-1 br-2 edited"
                                       value="">
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col-sm-4">
                                <p class="fs-15 fw-bold m-0">Комментарий:</p>
                            </div>
                            <div class="col-sm-8">
                                <input id="edited1" type="text" name="comment"
                                       class="form-control box-shadow-none fs-15 p-0 px-2 py-1 br-2 edited w-100"
                                       value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
                        Применить
                    </button>
                    <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1"
                            data-bs-dismiss="modal">
                        Закрыть
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
