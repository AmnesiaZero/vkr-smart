<div class="modal fade modal-window" id="modalAddBooks" tabindex="-1" aria-labelledby="modalAddBooksLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h3 class="modal-title" id="modalAddBooksLabel">Подключение книг для организации</h3>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Закрыть
                    </button>
                    <button type="button" class="btn btn-primary add-books">Подключить</button>
                </div>
            </div>
            <div class="modal-body">
                <div id="content-area">
                    <div class="row">
                        <div class="col-lg-3">
                            <form id="filterFormBooks" action="" method="POST">
                                <div class="form-group">
                                    <label for="title" class="d-none">Название коллекции</label>
                                    <input id="title" type="text" name="title" placeholder="Введите название книги" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary filter-books">Применить фильтр</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-9">
                            <div id="booksList"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary add-books">Подключить</button>
            </div>
        </div>
    </div>
</div>
