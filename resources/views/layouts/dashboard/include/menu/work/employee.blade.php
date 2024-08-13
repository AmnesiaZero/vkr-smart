<div class="info-box dropdown-menu" id="info_box" aria-labelledby="work-menu-button">
    <p class="fs-14 lh-17 mb-3">Направление подготовки обучающегося</p>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-3">
        <p class="fs-14 lh-17 text-grey m-0"
           onclick="openModal('update_work_specialty_modal')"
            data-bs-target="#update_work_specialty_modal" data-bs-toggle="modal">
            Изменить направление подготовки
        </p>
    </div>
    <p class="fs-14 lh-17 mt-4 mb-3">Операции над работой</p>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/info.svg" alt="" class="pe-3">
        <p class="fs-14 lh-17 text-grey m-0"
           data-bs-target="#work_info_modal" data-bs-toggle="modal"
           onclick="workInfo()">Просмотр информации о работе</p>
    </div>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/down-arr.svg" alt="" class="pe-3">
        <p class="fs-14 lh-17 text-grey m-0" onclick="downloadWork()">Скачать файл работы</p>
    </div>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-3">
        <input type="file" id="file_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" id="upload_button">Загрузить или заменить файл работы</p>
    </div>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-3">
        <p class="fs-14 lh-17 text-grey m-0"
           onclick="openUpdateWorkModal()"
           data-bs-target="#update_work_modal" data-bs-toggle="modal">
            Изменить информацию о работе
        </p>
    </div>
    <p class="fs-14 lh-17 mt-4 mb-3">Самопроверка</p>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-3">
        <p class="fs-14 lh-17 text-grey m-0" onclick="updateSelfCheckStatus()">Изменить статус самопроверки</p>
    </div>
    <div id="added_menu">

    </div>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-3">
        <input type="file" id="certificate_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" id="upload_certificate_button">Загрузить или заменить справку<br> о самопроверке по другим
            системам</p>
    </div>
    <p class="fs-14 lh-17 mt-2 mt-4 mb-3">Дополнительные файлы</p>
    <div class="d-flex align-items-center cursor-p mb-2">
        <img src="/images/href_light.svg" alt="" class="pe-3">
        <p class="fs-14 lh-17 text-grey m-0"
           onclick="openModal('additional_files_modal');additionalFiles();return false"
           data-bs-target="#additional_files_modal" data-bs-toggle="modal">
            Открыть окно управления<br> дополнительными файлами
        </p>
    </div>
</div>
