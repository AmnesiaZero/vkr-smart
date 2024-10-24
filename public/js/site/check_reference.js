function openReport() {
    const data = $("#check_form").serialize();
    $.ajax({
        url: "/dashboard/works/check-code",
        type: 'GET',
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const work = response.data.work;

                $("#report_container").html($("#report_tmpl").tmpl(work));

                const modalElement = new bootstrap.Modal(document.getElementById('report_modal'));

                modalElement.show();
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}


let isFirstOpen = true;

$('#report_modal').on('shown.bs.modal', function () {
    if (isFirstOpen) {
        $('#report_modal .modal-body').html(`
            <div id="report_content">
                <p> Полный отчет по работе </p>
                <div class="d-flex justify-content-between">
                    <a ng-if="report.status_report !== '1'" id="print_report" class="btn btn-success">
                        <span class="glyphicon glyphicon-print"></span>
                        Распечатать отчет
                    </a>
                    <a ng-if="report.status_report !== '1'" id="vkr_reference" class="btn btn-warning">
                        <span class="glyphicon glyphicon-download"></span>
                        Справка ВКР
                    </a>
                </div>
                <div class="col-sm-8 mt-2">
                    <ol style="padding-left:15px;">
                        <li>Результаты проверки по базам данных ВКР-СМАРТ:
                            <ul>
                                <li>Оригинальность текста документа: <strong id="borrowings_percent">${unique_percent}%</strong></li>
                            </ul>
                            <ul>
                                <li>Код справки: <strong id="check_code">${id}-${check_code}</strong></li>
                            </ul>
                        </li>
                    </ol>
                </div>
                <table class="table table-mini table-bordered table-condensed mt-4">
                    <thead>
                        <tr>
                            <th>Источник</th>
                            <th>Ссылка на источник</th>
                            <th>Коллекция/модуль поиска</th>
                            <th>Доля в отчете</th>
                        </tr>
                    </thead>
                    <tbody id="report_assets_list">
                        <!-- Пример данных из шаблона -->
                    </tbody>
                </table>
            </div>
        `);
        isFirstOpen = false;
    }
});

$(document).on('click', '#vkr_reference', function() {
    $('#report_modal .modal-body').html(`
        <div ng-view="" class="view-animate ng-scope" autoscroll="">
            <div class="container certificate-container">
                <div class="row">
                    <a href="#" onclick="window.print(); return false;" class="btn btn-link btn-smart">
                        <span class="glyphicon glyphicon-print"></span> Распечатать справку
                    </a>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2>СПРАВКА</h2>
                        <h3>о результатах проверки на наличие заимствований</h3>
                        <p style="color: #006f92;font-size: 16px;padding-top: 10px;">
                            Уникальный код справки: <strong class="ng-binding">1-243735-35349</strong>
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 text-bolder">Ф.И.О. автора проверяемой работы: Тестовая работа</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 text-bolder">Тема работы: 33</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 text-bolder">Руководитель: Кузьмичев Николай Валерьевич</div>
                </div>
                <hr>
                <h3 class="text-center">Источники цитирования *</h3>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Доля в отчете</th>
                            <th>Источник (ссылка)</th>
                            <th>Где найдено (Модуль поиска)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>48.36%</td>
                            <td>Работа студента «Пугачев Сергей Александрович»</td>
                            <td>Модуль поиска Интернет</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2.02%</td>
                            <td>Ядерное оружие. Организация спасательных работ</td>
                            <td>Модуль поиска Интернет</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-12 text-center" style="font-size:28px">Уникальность текста:  48.16%</div>
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
                    </tbody>
                </table>
            </div>
        </div>
    `);
});

$(document).on('click', '#print_report', function() {
    window.print();  // Вызов функции печати браузера
});
