<script id="report_tmpl" type="text/x-jquery-tmpl">
 <div id="report_modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Полный отчет по работе</h3>

            </div>
            <div class="modal-body">
                <div id="report_modal">
                    <div class="col-sm-8">
                        <ol style="padding-left:15px;">
                            <li>Результаты проверки по базам данных ВКР-СМАРТ:
                                <ul>
                                    <li>Оригинальность текста документа: <strong id="borrowings_percent" class="ng-binding">${unique_percent}%</strong></li>

                                </ul>
                            </li>
                        </ol>
                    </div>
                    <table class="table table-mini table-bordered table-condensed ng-scope">
                        <thead>
                        <tr>
                            <th>Источник</th>
                            <th>Ссылка на источник</th>
                            <th>Коллекция/модуль поиска</th>
                            <th>Доля в отчете</th>
                        </tr>
                        </thead>
                        <table>
                            <tbody id="report_assets_list">
                            @{{each reportAssets}}
                            <tr>
                                <td><a  class="ng-binding">${value.name}</a></td>
                                <td><a target="_blank" @{{if value.link}} href="${value.link}" @{{/if}} class="ng-binding"></a></td>
                                <td>Интернет</td>
                                <td class="ng-binding">${value.borrowings_percent}%</td>
                            </tr>
                            @{{/each}}
                            </tbody>
                        </table>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="closeTmplModal('add_achievement_modal')">Закрыть окно</button>
            </div>
        </div>
    </div>
</div>


</script>
