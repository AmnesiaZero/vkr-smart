<script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>


            </script>

<script id="department_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>



            </script>

<script id="specialty_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>



            </script>

<script id="work_tmpl" type="text/x-jquery-tmpl">
     <tr id="work_${id}" @{{if deleted_at!=null}} class="deleted" @{{/if}}>
    <th scope="row">${specialty.name}</th>
    <td>${student}</td>
    <td>${group}</td>
    <td>${protect_date}</td>
    <td>${name}</td>
    <td>${getAssessmentDescription(assessment)}</td>
    <td>${getSelfCheckDescription(self_check)}</td>
        <td>
            <div class="mt-2">
            @{{if report_status==0}}
            <span class="bg-waiting px-2 d-flex align-items-center">
            <div class="me-2 yellow-c">
            </div>
              В очереди на проверку
            </span>
            </div>
            @{{/if}}
            @{{if report_status==1}}
            <span class="bg-active px-2 d-flex align-items-center">
            <div class="me-2 green-c">
            </div>
              Отчет
            </span>
            </div>
            @{{/if}}
            @{{if report_status==2}}
            <span class="bg-error px-2 d-flex align-items-center">
            <div class="me-2 red-c">
            </div>
              Не проверена
            </span>
            </div>
            @{{/if}}

        </td>
        <td>
            <img src="/images/three_dots.svg" alt="" class="btn-info-box cursor-p" onclick="openInfoBox(${id})">
        </td>
    </tr>


            </script>

<script id="work_info_tmpl" type="text/x-jquery-tmpl">
        <div id="work_info_modal" style="display: block;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteElement('work_info_modal');return false"><span aria-hidden="true">×</span></button>
                        <h3>Информация о работе</h3>
                    </div>
                    <div class="modal-body">
                        <h3 class="bc-post-title bc-post-title-sm">Информация о работе</h3>
                        <form class="form form-horizontal" id="infoWorkForm" onsubmit="workInfo(); return false;">
                            <div class="form-group">
                                <label class="col-sm-4">Год выпуска</label>
                                <div class="col-sm-8" id="value_year_id">${year.year}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Факультет</label>
                                <div class="col-sm-8" id="faculty_id">${faculty.name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Кафедра</label>
                                <div class="col-sm-8" id="value_department_id">${department.name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Образовательная программа (специальность)</label>
                                <div class="col-sm-8">${specialty.name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Кто загрузил работу</label>
                                <div class="col-sm-8">${user.name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">ФИО обучающегося</label>
                                <div class="col-sm-8" >${student}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Группа обучающегося</label>
                                <div class="col-sm-8">${group}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Наименование работы</label>
                                <div class="col-sm-8" id="value_name">${name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Тип работы</label>
                                <div class="col-sm-8" id="value_worktype">${work_type}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Научный руководитель</label>
                                <div class="col-sm-8" id="value_scientific_adviser">${scientific_supervisor}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Дата защиты</label>
                                <div class="col-sm-8" id="value_protectdate">${protect_date}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Дата загрузки работы</label>
                                <div class="col-sm-8" id="value_createdon">${created_at}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Оценка</label>
                                <div class="col-sm-8" id="value_assessment">${getAssessmentDescription(assessment)}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Согласие на размещение работы</label>
                                <div class="col-sm-8" id="value_agreement">${getAgreementDescription(agreement)}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Файл работы</label>
                                <div class="col-sm-8" id="value_workfile"><a onclick="workDownload(); return false;" href="#"><span class="glyphicon glyphicon-save-file"></span> Скачать файл работы</a></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Самопроверка работы студентом</label>
                                <div class="col-sm-8" id="self_check_value">
                                <a href="#" onclick="updateSelfCheckStatus()" class="btn btn-warning btn-sm"> ${getSelfCheckDescription(self_check)}
                                <span class="glyphicon glyphicon-refresh">
                                </span>
                                </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Справка о самопроверке работы обучающимся по системе заимствований</label>
                                @{{if certificate}}
                                <a class="col-sm-8" onclick="downloadCertificate()">Скачать файл самопроверки </a>
                                @{{else}}
                                <div class="col-sm-8" id="value_certificate">Файл справки не загружен</div>
                                @{{/if}}
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Отчет о заимствованиях по базам ВКР-ВУЗ</label>
                                @{{if borrowings_percent}}
                                <div class="col-sm-8" id="value_percent_person">Фактических некорректных заимствований: ${borrowings_percent}</div>
                                @{{/if}}
                            </div>
                            <div id="works-add-alert"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="deleteElement('work_info_modal');return false">Закрыть окно</button>
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
        <p class="fs-14 lh-17 text-grey m-0" onclick="destroyWork()">Стереть запись и удалить прикрепленные файлы</p>
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

<script id="self_check_tmpl" type="text/x-jquery-tmpl">
       <a href="#" onclick="updateSelfCheckStatus()" class="btn btn-warning btn-sm"> ${getSelfCheckDescription(self_check)}
          <span class="glyphicon glyphicon-refresh">
                                </span>

            </script>

<script id="additional_file_tmpl" type="text/x-jquery-tmpl">
        <tr id="additional_file_${id}">
            <td>${file_name}</td>
            <td>
                <a target="_blank" href="/dashboard/works/employees/additional-files/download?id=${id}" class="btn btn-sm btn-success btn-block">Скачать</a>
                <a onclick="deleteAdditionalFile(${id}); return false;" href="#" class="btn btn-sm btn-danger btn-block">Удалить</a>
            </td>
        </tr>
            </script>
