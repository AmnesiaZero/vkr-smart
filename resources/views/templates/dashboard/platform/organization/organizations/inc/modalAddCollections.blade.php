<div class="modal fade modal-window" id="modalAddCollections" tabindex="-1" aria-labelledby="modalAddCollectionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h3 class="modal-title" id="modalAddCollectionsLabel">Подключение коллекций для организации</h3>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                        Закрыть
                    </button>
                    <button type="button" class="btn btn-primary add-collections">Подключить</button>
                </div>
            </div>
            <div class="modal-body">
                <div id="content-area">
                    <div class="row">
                        <div class="col-lg-3">
                            <form id="filterForm" action="{{ route('dashboard.catalog.categories.search-books') }}" method="POST">
                                <div class="form-group">
                                    <label for="title" class="d-none">Название коллекции</label>
                                    <input id="title" type="text" name="title" placeholder="Введите название книги" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary filter">Применить фильтр</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-9">
                            <div id="collectionsList"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary add-collections">Подключить</button>
            </div>
        </div>
    </div>
</div>
