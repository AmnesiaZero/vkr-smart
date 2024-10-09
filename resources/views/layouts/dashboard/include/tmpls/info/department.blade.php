<script id="department_info_tmpl" type="text/x-jquery-tmpl">

<div class="modal fade" id="department_info">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Информация о подразделении</h3>
                    </div>
                    <div class="modal-body">
                        <form class="form form-horizontal">
                            <div class="d-flex flex-column gap-4">
                            <div class="row">
                                <label class="col-sm-4">Название</label>
                                <div class="col-sm-8" id="name">${name}</div>
                            </div>
                                <div class="row">
                                    <label class="col-sm-4">Дополнительная информация</label>
                                    <div class="col-sm-8" id="description">
                                    @{{if description}}
                                    ${description}
                                    @{{/if}}
                                    </div>
                                </div>
                                </div>
                                <div id="works-add-alert"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
            <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                Закрыть
            </button>
</div>
</div>
</div>
</div>

</script>
