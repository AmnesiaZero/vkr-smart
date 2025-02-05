<div class="dropdown-menu info px-3 py-2" id="info_box">
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Edit_Pencil.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="openUpdateAchievementModal()">
            Изменить запись
        </p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/info.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="deleteAchievement()">Удалить запись</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-2">
        <input type="file" id="file_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" onclick="openModal('add_file_modal')" data-bs-target="#add_file_modal"
           data-bs-toggle="modal">
            Добавить файл
        </p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-2">
        <input type="file" id="file_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" onclick="openModal('add_link_modal')" data-bs-target="#add_link_modal"
           data-bs-toggle="modal">
            Добавить ссылку
        </p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-2">
        <input type="file" id="file_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" data-bs-target="#add_text_modal"
           data-bs-toggle="modal">
            Добавить текст
        </p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/download.svg" alt="" class="pe-2">
        <input type="file" id="file_input" style="display: none">
        <p class="fs-14 lh-17 text-grey m-0" onclick="openAddWorksModal()" data-bs-target="#add_work_modal"
           data-bs-toggle="modal">
            Выбрать работу из списка
        </p>
    </div>
</div>
