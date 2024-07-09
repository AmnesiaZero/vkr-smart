<div id="add_work_modal" class="modal" style="padding-right: 20px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="closeModal('add_work_modal')"><span aria-hidden="true">×</span></button>
                <h3>Прикрепление работы из списка загруженных</h3>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="add_work_form" class="form-inline">
                    <div class="form-group">
                        <label class="col-sm-4">Выберите документ из списка:</label>
                        <div class="big-table">
                            <table class="table fs-14">
                                <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                                <tr class="text-grey">
                                    <th scope="col">Выберите</th>
                                    <th scope="col">Направление подготовки</th>
                                    <th scope="col">Обучающийся</th>
                                    <th scope="col">Группа</th>
                                    <th scope="col">Дата защиты</th>
                                    <th scope="col">Наименование<br> работы - тип работы</th>
                                    <th scope="col">Оценка</th>
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
                    <div class="form-group">
                        <label class="col-sm-4">Выберите тип документа:</label>
                        <div class="col-sm-8">
                            <select name="achievement_type_id" class="selectpicker bs-select-hidden">
                            @if(isset($categories[2]->achievementsTypes) and is_iterable($categories[2]->achievementsTypes))
                                    <option class="boldoption" disabled="disabled">{{$categories[2]->name}}</option>
                                @foreach($categories[2]->achievementsTypes as $achievementType)
                                        <option value="{{$achievementType->id}}">{{$achievementType->name}}</option>
                                    @endforeach
                            @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Кому доступен ресурс:</label>
                        <div class="col-sm-8">
                            <select class="selectpicker bs-select-hidden" name="access_id">
                                <option value="1">Всем</option>
                                <option value="2">Только сотрудникам организации</option>
                                <option value="3">Только мне</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Действия</label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-lg btn-success"  onclick="closeModal('add_work_modal')">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="closeModal('add_work_modal')">Закрыть окно</button>
            </div>
        </div>
    </div>
</div>
