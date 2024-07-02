<div id="add_achievement_modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="closeModal('add_achievement_modal')">×</span></button>
                <h3>Добавление достижения</h3>
            </div>
            <div class="modal-body">
                <form id="add_achievement_form" onsubmit="addAchievement(); return false;" class="form-inline">
                    <div class="form-group">
                        <label class="col-sm-4">Введите наименование достижения</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control fullwidth" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Выберите тип деятельности:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="achievement_mode_id">
                                <option value="3">Научная деятельность</option>
                                <option value="2">Производственная деятельность</option>
                                <option value="5">Социальная деятельность</option>
                                <option value="6">Спортивная деятельность</option>
                                <option value="4">Творческая деятельность</option>
                                <option value="1">Учебная деятельность</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Уточните уровень образования:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="educational_level">
                                <option value="" class="boldoption" disabled="">Общее образование</option>
                                <option value="1">Дошкольное образование</option>
                                <option value="2">Начальное общее образование</option>
                                <option value="3">Основное общее образование</option>
                                <option value="4">Среднее общее образование</option>
                                <option value="" class="boldoption" disabled="">Профессиональное образование</option>
                                <option value="5">Среднее профессиональное образование</option>
                                <option value="6">Высшее образование - бакалавриат</option>
                                <option value="7">Высшее образование - специалитет, магистратура</option>
                                <option value="8">Высшее образование - подготовка кадров высшей квалификации</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Введите описание</label>
                        <div class="col-sm-8">
                            <textarea rows="8" name="description" class="form-control fullwidth"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Укажите дату достижения</label>
                        <div class="col-sm-8">
                            <input type="date" name="record_date" class="form-control datepick" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Кому доступно достижение:</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="access_level">
                                <option value="1">Всем</option>
                                <option value="2">Только сотрудникам организации</option>
                                <option value="3">Только мне</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success" onclick="closeModal('add_achievement_modal')">Добавить достижение</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="closeModal('add_achievement_modal')">Закрыть окно</button>
            </div>
        </div>
    </div>
</div>
