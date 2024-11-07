<div class="dropdown-menu p-3">
    <p class="fs-14 lh-17">Операции над работой</p>

    <div class="d-flex cursor-p mb-2">
        <img src="/images/info.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="workInfo()">
            Просмотр информации о работе
        </p>
    </div>

    <div class="d-flex cursor-p mb-2">
        <img src="/images/down-arr.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="downloadWork()">Скачать файл работы</p>
    </div>

    <div class="d-flex cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-2">
        <input type="file" id="file_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" id="upload_button">Загрузить или заменить файл работы</p>

    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="openUpdateWorkModal()">Изменить информацию о работе</p>
    </div>

    <p class="fs-14 lh-17">Самопроверка</p>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="updateSelfCheckStatus()">Изменить статус самопроверки</p>
    </div>

    <div id="added_menu">

    </div>

    <div class="d-flex cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-2">
        <input type="file" id="certificate_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" id="upload_certificate_button">Загрузить или заменить справку<br> о
            самопроверке по другим
            системам</p>
    </div>

    <p class="fs-14 lh-17">Дополнительные файлы</p>

    <div class="d-flex cursor-p mb-2">
        <img src="/images/href_light.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" data-bs-target="#additional_files_modal" data-bs-toggle="modal"
           onclick="openModal('additional_files_modal');additionalFiles();return false">
            Открыть окно управления<br>
            дополнительными файлами
        </p>
    </div>

    <p class="fs-14 lh-17">Проверка ВКР-СМАРТ.РФ</p>

    <div class="d-flex cursor-p mb-2">
        <img src="/images/href_light.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="updateWorkVisibility(); return false">Сделать работу недоступной
            сотрудникам организации</p>
    </div>
</div>
