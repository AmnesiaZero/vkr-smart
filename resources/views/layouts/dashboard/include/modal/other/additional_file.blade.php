<div class="modal fade" id="additional_files_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Управление дополнительными файлами для&nbsp;работы</h3>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="upload_additional_file_form"
                      class="form-inline form-well well-form">
                    <div class="d-flex gap-4 align-items-center">
                        <div class="col-sm-9">
                            <input type="file" name="additional_file" class="form-control" required>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary btn-block">Прикрепить файл</button>
                        </div>
                    </div>
                </form>
                <hr>
                <h3 class="bc-post-title-sm">Прикрепленные файлы</h3>
                <table class="table table-striped table-condensed table-bordered table-mini">
                    <thead>
                    <tr>
                        <th>Наименование файла</th>
                        <th width="80px">Действия</th>
                    </tr>
                    </thead>
                    <tbody id="additional_files">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
