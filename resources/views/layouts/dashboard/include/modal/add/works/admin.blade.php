<div class="modal fade" id="add_work_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Добавление работы</h3>
            </div>
            <form enctype="multipart/form-data" class="form form-horizontal" id="addWorkForm">
                <div class="modal-body">

                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <label class="col-sm-4">Год выпуска</label>
                            <div class="col-sm-8">
                                <select name="year_id" class="selectpicker form-control" id="years_list" data-width="100%"
                                        title="Выбрать...">
                                    @if(isset($years) and is_iterable($years))
                                        @foreach($years as $year)
                                            <option value="{{$year->id}}">{{$year->year}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Подразделение</label>
                            <div class="col-sm-8">
                                <select name="faculty_id" class="form-control" id="faculties_list" data-width="100%"
                                        title="Выбрать...">
                                    <option value="" disabled="" selected="selected">Уточните год выпуска</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Кафедра</label>
                            <div class="col-sm-8">
                                <select name="department_id" class="form-control" id="departments_list" data-width="100%"
                                        title="Выбрать...">
                                    <option value="" disabled="" selected="selected">Уточните подразделение</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Направление подготовки (специальность)</label>
                            <div class="col-sm-8">
                                <select name="specialty_id" class="form-control" id="add_specialties_list" data-width="100%"
                                        title="Выбрать...">
                                    <option value="" disabled="" selected="selected">Уточните кафедру</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">ФИО обучающегося</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="student" placeholder="Ввод..." required="">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Группа обучающегося</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="group" placeholder="Ввод...">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Наименование работы</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="Ввод..." required="">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Научный руководитель</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scientific_supervisor" placeholder="Ввод...">
                                <span style="font-size:13px; display:block; margin:0.5rem 0; color:#999;">Или выберите из списка:</span>
                                <select name="scientific_supervisor" class="selectpicker form-control" title="Выбрать...">
                                    @if(isset($scientific_supervisors) and is_iterable($scientific_supervisors))
                                        @foreach($scientific_supervisors as $scientific_supervisor)
                                            <option value="{{$scientific_supervisor->name}}">{{$scientific_supervisor->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Тип работы</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="work_type" placeholder="Ввод...">
                                <span style="font-size:13px; display:block; margin:0.5rem 0; color:#999;">Или выберите из списка:</span>
                                <select name="work_type" class="selectpicker form-control" title="Выбрать...">
                                    @if(isset($works_types) and is_iterable($works_types))
                                        @foreach($works_types as $works_type)
                                            <option value="{{$works_type->name}}">{{$works_type->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Дата защиты</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="protect_date">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Оценка</label>
                            <div class="col-sm-8">
                                <select class="selectpicker form-control" data-width="100%"
                                        name="assessment">
                                    <option value="0">Без оценки</option>
                                    <option value="5">Отлично</option>
                                    <option value="4">Хорошо</option>
                                    <option value="3">Удовлетворительно</option>
                                    <option value="2">Неудовлетворительно</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Согласие на размещение работы</label>
                            <div class="col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="agreement" checked="" required=""> Да
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Файл работы</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="work_file">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Способ проверки работы по базе ВКР-ВУЗ:</label>
                            <div class="col-sm-8">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="verification_method" value="1"> Проверить автоматически после
                                        загрузки
                                    </label>
                                </div>
                                <div class="radio mt-2">
                                    <label>
                                        <input type="radio" name="verification_method" value="0" checked=""> Проверить работу в ручном
                                        режиме
                                    </label>
                                </div>
                                <div class="radio mt-2">
                                    <label>
                                        <input type="radio" name="verification_method" value="2"> Не проверять работу после загрузки
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex flex-column gap-3">
                        <div class="row">
                            <label class="col-sm-4">Самопроверка работы студентом</label>
                            <div class="col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="self_check" value="1" checked=""> Работа проверена
                                        самостоятельно
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Справка о самопроверке работы обучающимся по системе
                                заимствований</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" name="certificate_file" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div id="works-add-alert"></div>
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
