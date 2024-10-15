<script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>

</script>

<script id="department_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>

</script>

<script id="specialty_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>

</script>


<script id="work_info_tmpl" type="text/x-jquery-tmpl">
        <div class="modal fade" id="work_info_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Информация о работе</h3>
                    </div>
                    <div class="modal-body">
                        <form class="form form-horizontal" id="infoWorkForm" onsubmit="workInfo(); return false;">
                            <div class="d-flex flex-column gap-4">
                            <div class="row">
                                <label class="col-sm-4">Год выпуска</label>
                                <div class="col-sm-8" id="value_year_id">@{{if year}}${year.year}@{{/if}}</div>
                            </div>
                                <div class="row">
                                    <label class="col-sm-4">Факультет</label>
                                    <div class="col-sm-8" id="faculty_id">@{{if faculty}} ${faculty.name} @{{/if}}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Кафедра</label>
                                    <div class="col-sm-8" id="value_department_id">@{{if department}} ${department.name} @{{/if}}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Образовательная программа (специальность)</label>
                                    <div class="col-sm-8">@{{if specialty}} ${specialty.name} @{{/if}}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Кто загрузил работу</label>
                                    <div class="col-sm-8">@{{if user}} ${user.name} @{{/if}}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">ФИО обучающегося</label>
                                    <div class="col-sm-8" >${student}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Группа обучающегося</label>
                                    <div class="col-sm-8">${group}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Наименование работы</label>
                                    <div class="col-sm-8" id="value_name">${name}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Тип работы</label>
                                    <div class="col-sm-8" id="value_worktype">${work_type}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Научный руководитель</label>
                                    <div class="col-sm-8" id="value_scientific_adviser">${scientific_supervisor}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Дата защиты</label>
                                    <div class="col-sm-8" id="value_protectdate">${protect_date}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Дата загрузки работы</label>
                                    <div class="col-sm-8" id="value_createdon">${created_at}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Оценка</label>
                                    <div class="col-sm-8" id="value_assessment">${getAssessmentDescription(assessment)}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Согласие на размещение работы</label>
                                    <div class="col-sm-8" id="value_agreement">${getAgreementDescription(agreement)}</div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Файл работы</label>
                                    <div class="col-sm-8" id="value_workfile"><a onclick="downloadWork(); return false;" href="#"><span class="glyphicon glyphicon-save-file"></span> Скачать файл работы</a></div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Самопроверка работы студентом</label>
                                    <div class="col-sm-8">
                                    <a href="#" onclick="updateSelfCheckStatus()" class="btn btn-grey">
                                        <span id="self_check_value">
                                            ${getSelfCheckDescription(self_check)}
                                        </span>
                                    </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Справка о самопроверке работы обучающимся по системе заимствований</label>
                                    @{{if certificate}}
                                    <a class="col-sm-8" onclick="downloadCertificate()">Скачать файл самопроверки </a>
                                    @{{else}}
                                    <div class="col-sm-8" id="value_certificate">Файл справки не загружен</div>
                                    @{{/if}}
                                </div>
                                <div class="row">
                                    <label class="col-sm-4">Отчет о заимствованиях по базам ВКР-СМАРТ</label>
                                    @{{if borrowings_percent}}
                                    <div class="col-sm-8" id="value_percent_person">Фактических некорректных заимствований: ${borrowings_percent}</div>
                                    @{{/if}}
                                </div></div>
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

<script id="deleted_menu_tmpl" type="text/x-jquery-tmpl">
     <div class="d-flex cursor-p mb-2">
        <img src="/images/Trash_Full.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="restore()">Восстановить работу</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Trash_Full.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="destroyWork()">Безвозвратно удалить работу<br> обучающего и все файлы</p>
    </div>


</script>
<script id="undeleted_menu_tmpl" type="text/x-jquery-tmpl">
        <div class="d-flex cursor-p mb-2">
        <img src="/images/copy.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="copyWork()">Сделать копию записи без создания файлов</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Trash_Full.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="deleteWork()">Поместить работу на удаление</p>
    </div>


</script>


<script id="additional_file_tmpl" type="text/x-jquery-tmpl">
        <tr id="additional_file_${id}">
            <td>${file_name}</td>
            <td class="d-flex gap-3 justify-content-center">
                <a target="_blank" href="/dashboard/works/employees/additional-files/download?id=${id}"
                    data-bs-toggle="tooltip" title="Скачать">
                    <img src="/images/down-arr.svg" alt="">
                </a>
                <a onclick="deleteAdditionalFile(${id}); return false;" href="#"
                data-bs-toggle="tooltip" title="Удалить">
                    <img src="/images/Trash_Full.svg" alt="">
                </a>
            </td>
        </tr>

</script>

<script id="update_work_tmpl" type="text/x-jquery-tmpl">
    <div class="modal fade" id="update_work_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Редактирование направления подготовки квалификационной работы
                    </h3>
                </div>
                <form class="form form-horizontal" id="update_work_form" onsubmit="updateWork(); return false;">
                    <div class="modal-body">
                        <div id="editWorkSpecialtieAlert"></div>

                        <div class="d-flex flex-column gap-4">
                            <div class="row">
                            <label class="col-sm-4">ФИО обучающегося</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="student" value="${student}" placeholder="" required="">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Группа обучающегося</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="group" value="${group}" placeholder="">
                            </div>
                         </div>
                        <div class="row">
                            <label class="col-sm-4">Наименование работы</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="" value="${name}" required="">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">Научный руководитель</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="scientific_supervisor" value="${scientific_supervisor}">
                                <span style="font-size:13px; display:block; margin:0.5rem 0; color:#999;">Или выберите из списка:</span>
                                <select name="scientific_supervisor" class="selectpicker form-control"
                                        title="Выбрать...">
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
    <input type="text" class="form-control" name="work_type" value="${work_type}">
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
    <input type="date" class="form-control" name="protect_date" value="${protect_date}">
</div>
</div>
<div class="row">
<label class="col-sm-4">Оценка</label>
<div class="col-sm-8">
    <select class="selectpicker form-control" data-width="100%" name="assessment">
        <option value="0" @{{if assessment==0}} selected @{{/if}}>Без оценки</option>
        <option value="5" @{{if assessment==5}} selected @{{/if}}>Отлично</option>
        <option value="4" @{{if assessment==4}} selected @{{/if}}>Хорошо</option>
        <option value="3" @{{if assessment==3}} selected @{{/if}}>Удовлетворительно</option>
        <option value="2" @{{if assessment==2}} selected @{{/if}}>Неудовлетворительно</option>
    </select>
</div>
</div>
<div class="row">
<label class="col-sm-4">Согласие на размещение работы</label>
<div class="col-sm-8">
    <div class="checkbox">
        <label>
            <input type="checkbox" value="1" name="agreement" checked=""> @{{if agreement==1}} Да @{{else}} Нет @{{/if}}
        </label>
    </div>
</div>
</div>

<div class="row">
<label class="col-sm-4">Способ проверки работы по базе ВКР-СМАРТ:</label>
<div class="col-sm-8">
    <div class="radio">
    <label>
        <input type="radio" name="verification_method" value="0" class="form-check-input green"
               @{{if verification_method==0}} selected @{{/if}}>
        <span class="ms-1">Проверить автоматически после загрузки</span>
    </label>
</div>
<div class="radio">
    <label>
        <input type="radio" name="verification_method" value="1" checked=""
               class="form-check-input green"
               @{{if verification_method==1}} selected @{{/if}}>
        <span class="ms-1">Проверить работу в ручном режиме</span>
    </label>
</div>
<div class="radio">
    <label>
        <input type="radio" name="verification_method" value="2" class="form-check-input green"
               @{{if verification_method==2}} selected @{{/if}}>
        <span class="ms-1">Не проверять работу после загрузки</span>
    </label>
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-secondary fs-14 text-grey py-1" data-bs-dismiss="modal">
Применить
</button>
<button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
Закрыть
</button>
</div>
</form>
</div>
</div>
</div>


</script>


<script id="report_tmpl" type="text/x-jquery-tmpl">
 <div class="modal fade"  id="report_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Полный отчет по работе</h3>
            </div>
            <div class="modal-body">
                <div id="report_modal">
                    <span> Полный отчет по работе </span>

                    <a ng-if="report.status_report !== '1'" ng-click="showFull()" class="btn btn-success ng-scope"><span class="glyphicon glyphicon-print"></span> Распечатать отчет</a>
                    <a ng-if="report.status_report !== '1'" href="#/reference/530250/1/cd9640cd3f886e13072731fc90e66715" class="btn btn-warning ng-scope"><span class="glyphicon glyphicon-download"></span> Справка ВКР</a>

                    <div class="col-sm-8 mt-2">
                        <ol style="padding-left:15px;">
                            <li>Результаты проверки по базам данных ВКР-СМАРТ:
                                <ul>
                                    <li>Оригинальность текста документа: <strong id="borrowings_percent" class="ng-binding">${unique_percent}%</strong></li>
                                </ul>
                                <ul>
                                    <li>Код справки: <strong id="check_code" class="ng-binding">${id}-${check_code}</strong></li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                    <table class="table table-mini table-bordered table-condensed ng-scope mt-4">
                        <thead>
                        <tr>
                            <th>Источник</th>
                            <th>Ссылка на источник</th>
                            <th>Коллекция/модуль поиска</th>
                            <th>Доля в отчете</th>
                        </tr>
                        </thead>
                        <tbody id="report_assets_list">
                            @{{each report_assets}}
                            <tr>
                                <td>
                                    <a target="_blank" class="ng-binding fs-14" href="${link}">${name}</a>
                                </td>
                                <td>
                                    <a target="_blank" href="${link}" class="ng-binding">${link}</a>
                                </td>
                                <td>
                                    Интернет
                                </td>
                                <td class="ng-binding">
                                    ${borrowings_percent}%
                                </td>
                            </tr>
                            @{{/each}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal" aria-label="Close">
                    Закрыть окно
                </button>
            </div>
        </div>
    </div>
</div>

</script>


