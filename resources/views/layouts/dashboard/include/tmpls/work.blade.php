<script id="work_tmpl" type="text/x-jquery-tmpl">
                <tr id="work_${id}" @{{if deleted_at!=null}} class="deleted" @{{/if}}>
                <td>${name} - ${work_type}</td>
               <td>${protect_date}</td>
               <td>${getAssessmentDescription(assessment)}</td>
               <td>${getSelfCheckDescription(self_check)}</td>
                   <td>
                       @{{if report_status==0}}
                       <div>
                       <span class="bg-waiting p-2 d-flex align-items-center gap-2">
                       <div class="me-2 yellow-c">
                       </div>
                         В очереди на проверку
                       </span>
                       </div>
                       @{{/if}}
                       @{{if report_status==1}}
                       <div onclick="openReport(${id})">
                           <span class="bg-active p-2 d-flex align-items-center cursor-p">
                               <div class="me-2 green-c"></div>
                               Отчет
                           </span>
                       </div>
                       @{{/if}}
                       @{{if report_status==2}}
                       <div>
                           <span class="bg-error p-2 d-flex align-items-center gap-2">
                               <span class="red-c"></span>
                               Не&nbsp;проверена
                           </span>
                       </div>
                       @{{/if}}

                   </td>
            </tr>
            </script>
