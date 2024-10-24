<script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>

</script>

<script id="department_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>

</script>

<script id="specialty_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>

</script>


<script id="check_tmpl" type="text/x-jquery-tmpl">
<style class="ng-scope">
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 3px 4px;
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 13px;
    }
	hr {
		margin:10px 0;
	}
	h3.text-center {
		margin-bottom: 15px;
		font-weight: 600;
	}
</style>
    <div ng-if="success" class="ng-scope">
        <div class="container certificate-container">
            <div class="row">
                <a class="btn btn-link btn-smart pointer" onclick="openReport(${id})"><span class="glyphicon glyphicon-chevron-left"></span>Назад</a>
                <a href="#" onclick="window.print(); return false;" class="btn btn-link btn-smart"><span class="glyphicon glyphicon-print"></span> Распечатать справку</a>
            </div>
            <div class="row">
                <div class="col-sm-4 text-left">
                    <img width="220px" src="http://www.vkr-vuz.ru/assets/templates/c/img/logo.png ">
                </div>
				<div class="col-sm-6 col-sm-offset-2 text-right">
                    <img class="" style="max-height: 164px; float:right; margin-left:20px; margin-right:30px;" src="http://www.vkr-vuz.ru/logotypes/1/logo_1.jpg"><br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h2>СПРАВКА</h2>
                    <h3>о результатах проверки на наличие заимствований</h3>
					<p style="color: #006f92;font-size: 16px;padding-top: 10px;" class="">Уникальный код справки: <strong class="ng-binding">${id}-${check_code}</strong></p>
                </div>
            </div><hr>
             <div class="row">
    <div class="col-sm-12 text-bolder ng-binding">
        Ф.И.О. автора проверяемой работы: <span class="ng-binding">${student}</span>
    </div>
</div>
<div class="col-sm-12 text-bolder ng-binding">
        Тема работы: <span class="ng-binding">${name}</span>
    </div>
 <div class="row">
    <div class="col-sm-12 text-bolder ng-binding">
        Руководитель: <span class="ng-binding">${scientific_supervisor}</span>
    </div>
</div>
            <h3 class="text-center">Информация о документе:</h3>
 <div class="row">
    <div class="col-sm-12 text-bolder ng-binding">
        Имя исходного файла: <span class="ng-binding">${document_name}</span>
    </div>
</div>
<hr>
 <div class="row">
    <div class="col-sm-12 text-bolder ng-binding">
        Тип документа: <span class="ng-binding">${work_type}</span>
    </div>
</div>
<hr>
            <div class="hide">
	<div class="row">
    <div class="col-sm-12 text-bolder ng-binding">
        Дата загрузки: <span class="ng-binding">${created_at}</span>
    </div>
</div>
><hr>
            </div>
			<div class="hide">
	<div class="row">
    <div class="col-sm-12 text-bolder ng-binding">
        Дата защиты: <span class="ng-binding">${protect_date}</span>
    </div>
</div>
<hr>
			</div>
            <div class="">
				<h3 class="text-center">Источники цитирования *</h3>
			<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th class="ng-binding ng-scope">Доля в отчете</th>
            <th class="ng-binding ng-scope">Источник (ссылка)</th>
             <th  class="ng-binding ng-scope">Где найдено (Модуль поиска)</th>

        </tr>
    </thead>
    <tbody>
         @{{each report_assets}}
            <td class="ng-binding">${borrowings_percent}%</td>
            <td class="ng-binding">"${name}"   @{{if link}} ${link} @{{else}} Ссылка не указана @{{/if}} </td>
            <td>Модуль поиска Интернет</td>
            @{{/each}}
    </tbody>
</table>
				<div class="row">
					<div class="col-sm-12 text-bolder">
						* Таблица формируется системой «ВКР-ВУЗ».
					</div>
				</div><hr>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center ng-binding" style="font-size:28px">
					Уникальность текста:  48.16%
				</div>
			</div>
			<table class="table table-mini">
				<tbody>
					<tr>
						<td><hr></td>
						<td><hr></td>
						<td><hr></td>
						<td><hr></td>
					</tr>
					<tr>
						<td class="">подпись студента</td>
						<td>расшифровка подписи</td>
						<td>подпись ответственного за проверку</td>
						<td>расшифровка подписи</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><hr></td>
						<td></td>
						<td><hr></td>
					</tr>
					<tr>
						<td></td>
						<td>дата</td>
						<td></td>
						<td>дата</td>
					</tr>
				</tbody>
			</table>
        </div>
    </div>
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
        <img src="/images/Copy.svg" alt="" class="pe-2">
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




