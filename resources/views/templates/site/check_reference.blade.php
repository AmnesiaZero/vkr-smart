@extends('layouts.site.main')
@section('content')
    <main>
        <div class="container py-5 mb-5">
            <div class="row">
                <div class="col-lg-12 px-lg-0 px-4">
                    <h3>Введите код проверки</h3>
                    <div class="row">
                        <div class="col-sm-3">
                            <form class="form" id="check_form" onsubmit="openReport(); return false;">
                                <div class="form-group">
                                    <input id="id" type="text" class="form-control"
                                           style="font-size:18px;height:50px;" placeholder="Введите проверочный код"
                                           required="">
                                </div>
                                <div class="form-group mt-3">
                                    <button class="btn  btn-lg btn-block btn-success" type="submit">Проверить</button>
                                </div>

                            </form>
                        </div>
                        <div class="col-sm-9">
                            <div id="alerts"></div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script src="/js/site/check_reference.js"></script>

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

                    <div class="col-sm-8 mt-2">
                        <ol style="padding-left:15px;">
                            <li>Результаты проверки по базам данных ВКР-СМАРТ:
                                <ul>
                                    <li>Оригинальность текста документа: <strong id="borrowings_percent" class="ng-binding">${unique_percent}%</strong></li>
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
                                    <a  class="ng-binding fs-14">${name}</a>
                                </td>
                                <td>
                                    <a target="_blank" href="${link}" class="ng-binding"></a>
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
@endsection
