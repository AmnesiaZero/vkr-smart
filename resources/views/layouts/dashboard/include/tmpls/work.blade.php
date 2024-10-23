<script id="work_tmpl" type="text/x-jquery-tmpl">
     <tr id="work_${id}">
    <td>${student}</td>
    <td>${protect_date}</td>
    <td>${name}</td>
    <td>${getAssessmentDescription(assessment)}</td>
    <td>${getSelfCheckDescription(self_check)}</td>
        <td>
            @{{if report_status==0}}
                <span class="bg-error p-2 d-flex align-items-center gap-2">
                    <div class="me-2 yellow-c"></div>
                    В очереди на проверку
                </span>
            @{{/if}}

            @{{if report_status==1}}
                <span class="bg-error p-2 d-flex align-items-center gap-2">
                    <div class="me-2 green-c"></div>
                    Отчет
                </span>
            @{{/if}}

            @{{if report_status==2}}
                <span class="bg-error p-2 d-flex align-items-center gap-2">
                    <div class="me-2 red-c"></div>
                    Не проверена
                </span>
            @{{/if}}
        </td>

    </tr>

</script>
