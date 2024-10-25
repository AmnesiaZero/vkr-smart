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
