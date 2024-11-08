<div id="add_work_modal" class="modal fade" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Прикрепление работы из списка загруженных</h3>
            </div>
            <form enctype="multipart/form-data" id="add_work_form" class="form-inline">
                <div class="modal-body">

                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <label class="col-sm-4">Выберите документ из списка:</label>
                            <div class="big-table">
                                <table class="table fs-14">
                                    <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                                    <tr class="text-grey">
                                        <th scope="col" class="align-middle">Выберите</th>
                                        <th scope="col" class="align-middle">Направление подготовки</th>
                                        <th scope="col" class="align-middle">Обучающийся</th>
                                        <th scope="col" class="align-middle">Группа</th>
                                        <th scope="col" class="align-middle">Дата защиты</th>
                                        <th scope="col" class="align-middle">Наименование<br> работы - тип работы</th>
                                        <th scope="col" class="align-middle">Оценка</th>
                                    </tr>
                                    </thead>
                                    <tbody class="lh-17 brb-green-light-2" id="works_table">
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example" class="custom_pagination" id="pagination">
                                <ul class="pagination m-0" id="pages">

                                </ul>
                            </nav>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">Выберите тип документа:</label>
                            <div class="col-sm-8">
                                <select name="achievement_type_id" class="selectpicker bs-select-hidden w-100">
                                    @if(isset($categories[2]->achievementsTypes) and is_iterable($categories[2]->achievementsTypes))
                                        <option class="boldoption" disabled="disabled">{{$categories[2]->name}}</option>
                                        @foreach($categories[2]->achievementsTypes as $achievementType)
                                            <option value="{{$achievementType->id}}">{{$achievementType->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">Кому доступен ресурс:</label>
                            <div class="col-sm-8">
                                <select class="selectpicker bs-select-hidden w-100" name="access_id">
                                    <option value="1">Всем</option>
                                    <option value="2">Только сотрудникам организации</option>
                                    <option value="3">Только мне</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary fs-14 text-grey py-1">
                        Добавить
                    </button>
                    <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1"
                            data-bs-dismiss="modal"
                            aria-label="Close" onclick="closeModal('add_work_modal')">
                        Закрыть
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
