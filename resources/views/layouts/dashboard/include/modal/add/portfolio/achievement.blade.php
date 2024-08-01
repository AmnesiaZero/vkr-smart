<div id="add_achievement_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавление достижения</h3>
            </div>
            <div class="modal-body">
                <form id="add_achievement_form" onsubmit="addAchievement(); return false;" class="form-inline">
                    <div class="d-flex flex-column gap-3">
                        <div class="row align-items-start">
                            <label class="col-sm-4 fs-16 fw-500">Введите наименование достижения</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control fullwidth" required="" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <label class="col-sm-4 fs-16 fw-500">Выберите тип деятельности:</label>
                            <div class="col-sm-8">
                                <select name="achievement_mode_id" class="selectpicker bs-select-hidden">
                                    @if(isset($modes) and is_iterable($modes))
                                        @foreach($modes as $mode)
                                            <option value="{{$mode->id}}">{{$mode->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <label class="col-sm-4 fs-16 fw-500">Уточните уровень образования:</label>
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
                        <div class="row align-items-start">
                            <label class="col-sm-4 fs-16 fw-500">Введите описание</label>
                            <div class="col-sm-8">
                                <textarea row align-items-centers="8" name="description" class="form-control fullwidth" placeholder="Ввод..."></textarea>
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <label class="col-sm-4 fs-16 fw-500">Укажите дату достижения</label>
                            <div class="col-sm-8">
                                <input type="date" name="record_date" class="form-control datepick" required="">
                            </div>
                        </div>
                        <div class="row align-items-start">
                            <label class="col-sm-4 fs-16 fw-500">Кому доступно достижение:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="access_level">
                                    <option value="1">Всем</option>
                                    <option value="2">Только сотрудникам организации</option>
                                    <option value="3">Только мне</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
                    Добавить достижение
                </button>
                <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
