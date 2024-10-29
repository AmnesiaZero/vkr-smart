<script id="report_tmpl" type="text/x-jquery-tmpl">
    <div class="modal fade"  id="report_modal">
       <div class="modal-dialog modal-lg modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h3 class="modal-title">Полный отчет по работе</h3>
               </div>
               <div class="modal-body" id="report_modal_container">
                   <div id="report_modal">
                       <p> Полный отчет по работе </p>

                       <div class="d-flex justify-content-between">
                           <a ng-if="report.status_report !== '1'"  class="btn btn-success ng-scope">
                               <span class="glyphicon glyphicon-print"></span>
                               Распечатать отчет
                           </a>
                           <a ng-if="report.status_report !== '1'" onclick="openCheck()" class="btn btn-warning ng-scope">
                               <span class="glyphicon glyphicon-download"></span>
                               Справка ВКР
                           </a>
                       </div>

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
                                       <a target="_blank" class="ng-binding fs-14" @{{if link}} href="${link}" @{{/if}}>${name}</a>
                                   </td>
                                   <td>
                                       <a target="_blank" @{{if link}} href="${link}" @{{/if}} class="ng-binding">@{{if link}} ${link} @{{else}} Ссылка не указана @{{/if}}</a>
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
        Руководитель: <span class="ng-binding">@{{if scientific_supervisor}} ${scientific_supervisor} @{{else}} Не указан @{{/if}}</span>
    </div>
</div>
            <h3 class="text-center">Информация о документе:</h3>
<hr>
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
					Уникальность текста:  ${unique_percent}%
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
