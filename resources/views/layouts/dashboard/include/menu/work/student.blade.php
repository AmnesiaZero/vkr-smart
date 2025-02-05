<div class="info-box dropdown-menu" id="student_info_box">
    @role('user|admin')
    <p class="fs-14 lh-17">Операции над работой</p>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/info.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="workInfoStudent('main-information')"
           data-bs-target="work_info_student" data-bs-toggle="modal">
            Просмотр информации о работе
        </p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Chat.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="workInfoStudent('comments')">Оставить комментарий</p>
    </div>
    @endrole

    @role('admin')
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="openModal('update_work_modal')">Изменить информацию о работе</p>
    </div>
    <div id="added_menu">

    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/down-arr.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="downloadWork()">Скачать файл работы</p>
    </div>
    <div class="d-flex cursor-p mb-2 pt-2 brt-black-grey">
        <img src="/images/download.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" id="upload_button">Заменить файл работы</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/File_Remove.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="acceptWork();return false">Принять работу</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/File_Remove.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="declineWork();return false">Отклонить работу (отправить на
            доработку)</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/clock_grey.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="putWorkOnWait();return false">Перевести статус работы в режим
            ожидания</p>
    </div>
    <p class="fs-14 lh-17">Самопроверка</p>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/close_grey.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="updateSelfCheckStatus()">Изменить статус самопроверки</p>
    </div>
    <p class="fs-14 lh-17">Согласие на размещение</p>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/close_grey.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0">Файл согласия не загружен</p>
    </div>
    @endrole

    @role('admin|inspector')
    <p class="fs-14 lh-17">Дополнительные файлы</p>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/href_light.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0"
           onclick="openModal('additional_files_modal');additionalFiles();return false">Открыть окно управления<br>
            дополнительными файлами</p>
    </div>
    @endrole
</div>
