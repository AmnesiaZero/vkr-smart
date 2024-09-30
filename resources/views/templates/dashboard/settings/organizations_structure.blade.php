@extends('layouts.dashboard.main')

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">

        <div class="row g-4 pt-5 px-0 px-sm-4 mx-sm-0 mx-4">

            <div class="col-xxl-4 col-xl-6 col-12">
                <div class="br-green-light-2 br-15 py-3">
                    <div class="row">
                        <div class="col">
                            <p class="mb-2 fw-600 px-3">Год выпуска</p>

                            <div class="p-2" id="year_end">
                                <button class="btn btn-secondary br-none text-grey w-100 fs-14 py-2" data-bs-toggle="modal"
                                        data-bs-target="#create_year">
                                    Добавить
                                    <img src="/images/Plus.svg" alt="" class="ps-2">
                                </button>
                            </div>

                            <div id="years_list" class="blue-scroll"></div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.dashboard.include.modal.create.year')
            @include('layouts.dashboard.include.modal.update.year')

            <div class="col-xxl-4 col-xl-6 col-12">
                <div class="br-green-light-2 br-15 py-3" style="display: none"
                     id="departments_container">
                    <div class="row">
                        <div class="col">
                            <p class="mb-2 fw-600 px-3">Кафедры</p>

                            <form method="post" id="department_form"
                                  onsubmit="createDepartment();return false;">
                                <div class="btn-group p-2 w-100">
                                    <input type="text" class="form-control fs-14" id="department-name" name="name" placeholder="Введите наименование..." style="border-radius: 5px 0 0 5px">
                                    <button type="submit" class="fs-14 text-grey btn btn-secondary">Добавить</button>
                                </div>
                            </form>

                            <div id="departments_list" class="blue-scroll"></div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.dashboard.include.modal.update.department')

            <div class="col-xxl-4 col-xl-6 col-12">
                <div class="br-green-light-2 br-15 py-3" style="display: none" id="programs_container">
                    <div class="row">
                        <div class="col">
                            <p class="mb-2 fw-600 px-3">Профили обучения</p>

                            <form method="post" id="program_form"
                                  onsubmit="createProgram();return false;">
                                <div class="btn-group p-2 w-100">
                                    <input type="text" class="form-control fs-14" id="program-name" name="name" placeholder="Введите наименование..." style="border-radius: 5px 0 0 5px">
                                    <button type="submit" class="fs-14 text-grey btn btn-secondary">Добавить</button>
                                </div>
                            </form>

                            <div id="programs_list" class="blue-scroll"></div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.dashboard.include.modal.create.program')

            <div class="col-xxl-4 col-xl-6 col-12">
                <div class="br-green-light-2 br-15 py-3" id="faculties_container" style="display: none">
                    <div class="row">
                        <div class="col">
                            <p class="mb-2 fw-600 px-3">Подразделения</p>

                            <form method="post" id="faculty_form" onsubmit="createFaculty();return false;">
                                <div class="btn-group p-2 w-100">
                                    <input id="faculty-name" name="name" type="text" class="form-control fs-14" placeholder="Введите наименование..." style="border-radius: 5px 0 0 5px">
                                    <button type="submit" class="fs-14 btn text-grey btn-secondary">Добавить</button>
                                </div>
                            </form>

                            <div id="faculties_list" class="blue-scroll"></div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.dashboard.include.modal.update.faculty')
        </div>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title fw-600 fs-16 text-center pe-5">Настройки профиля обучения</h5>
            </div>
            <div class="offcanvas-body px-0" style="overflow-x: hidden;">
                <div>
                    <div class="mb-3 col-10 mx-4">
                        <p class="m-0">Профиль обучения</p>
                        <p class="fs-12 mb-2">программы подготовки</p>
                        <form class="input-group w-100" id="update_name_form" onsubmit="updateProgramName(); return false;">
                            <input type="text" class="form-control" id="profile" name="name" value="">
                            <button type="submit" class="fs-14 text-grey btn btn-secondary">Изменить</button>
                        </form>
                    </div>
                </div>
                <div class="mt-5">
                    <ul class="nav nav-tabs d-flex justify-content-between brb-green-light-2 px-4" id="myQuestions"
                        role="tablist">
                        <li class="nav-item nav-item-head pb-2" role="presentation">
                            <a class="fs-16 active pb-1 px-0 link-offcanvas td-none" id="base-tab" data-bs-toggle="tab"
                               href="#base" role="tab" aria-controls="base" aria-selected="true">База направлений</a>
                        </li>
                        <li class="nav-item nav-item-head pb-2" role="presentation">
                            <a class="fs-16 pb-1 px-0 link-offcanvas td-none" id="own-settings-tab" data-bs-toggle="tab"
                               href="#own-settings" role="tab" aria-controls="own-settings" aria-selected="false">Собственные
                                настройки</a>
                        </li>
                    </ul>
                    <div class="tab-content bg-white br-blue-grey-1 bbrr-20 bblr-20 " id="myQuestionsContent">
                        <div class="tab-pane fade active show" id="base" role="tabpanel" aria-labelledby="base-tab">
                            <p class="fs-14 mb-2 pt-4 ps-4">Уровень образования:</p>
                            <div class="d-flex inline-flex ps-4" id="level_education_group">
                                <div class="form-check">
                                    <input class="form-check-input green" type="radio" name="level_education"
                                           id="level_education_1" value="1">
                                    <label class="form-check-label" for="level_education_1">
                                        СПО
                                    </label>
                                </div>
                                <div class="form-check ms-5">
                                    <input class="form-check-input green" type="radio" name="level_education"
                                           id="level_education_2" value="2">
                                    <label class="form-check-label" for="level_education_2">
                                        ВО
                                    </label>
                                </div>
                            </div>
                            <p class="fs-14 mb-2 pt-4 ps-4">Уровень подготовки:</p>
                            <div class="row ps-4" id="level_group">
                                <div class="col d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_1"
                                               value="1">
                                        <label class="form-check-label" for="level_1">
                                            Бакалавриат
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_2"
                                               value="2">
                                        <label class="form-check-label" for="level_2">
                                            Магистратура
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_3"
                                               value="3">
                                        <label class="form-check-label" for="level_3">
                                            Специалитет
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_4"
                                               value="4">
                                        <label class="form-check-label" for="level_4">
                                            Аспирантура
                                        </label>
                                    </div>
                                </div>
                                <div class="col d-flex flex-column gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_5"
                                               value="5">
                                        <label class="form-check-label" for="level_5">
                                            Адъюнктура
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_6"
                                               value="6">
                                        <label class="form-check-label" for="level_6">
                                            Ординатура
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input green" type="radio" name="level" id="level_7"
                                               value="7">
                                        <label class="form-check-label" for="level_7">
                                            Ассистентура
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p class="fs-14 mb-2 pt-4 ps-4">Направление:</p>
                            <div class="px-4 col-12">
                                <form onsubmit="addSpecialty(); return false;">
                                    <select class="js-example-basic-single w-100" name="state" id="specialties_list" required></select>

                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="fs-14 text-grey btn btn-secondary">Добавить</button>
                                    </div>
                                </form>
                            </div>
                            @include('layouts.dashboard.include.elements.program_specialties_table')
                        </div>

                        <div class="tab-pane fade" id="own-settings" role="tabpanel" aria-labelledby="own-settings-tab">
                            <p class="text-grey fs-14 pt-4 mx-4 lh-17">Вы можете самостоятельно добавить направление
                                подготовки, если в предлагаемой базе направлений вы не видите необходимого</p>
                            <form onsubmit="createProgramSpecialty();return false;" id="create_program_specialty">
                                <div class="mb-4 mx-4 col-8">
                                    <label for="code_course" class="form-label mb-2">Код направления:</label>
                                    <input type="text" class="form-control" name="code" id="code_course"
                                           value="" placeholder="Ввод..." required>
                                </div>
                                <div class="mb-3 mx-4 col-8">
                                    <label for="course" class="form-label mb-2">Направление:</label>
                                    <input type="text" class="form-control" name="name" id="course"
                                           value="" placeholder="Ввод..." required>
                                </div>
                                <div class="mx-4 col-8">
                                    <button class="btn btn-secondary text-grey fs-14 br-100 w-100 br-none py-2 mt-3">
                                        Добавить
                                    </button>
                                </div>
                            </form>
                            @include('layouts.dashboard.include.elements.program_specialties_table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @section('scripts')
            <script id="year_tmpl" type="text/x-jquery-tmpl">
                <div class="row align-items-center py-2 mx-0 border-bottom" id="year_row_${id}">
                    <div class="col ps-3 pe-0">
                        <p class="m-0 fs-14 header" id="year_${id}" onclick="faculties(${id})">${year}</p>
                    </div>

                    <div class="col-auto ps-0 text-end">
                        <button id="edit_year_issue" class="btn copy_edit br-none"
                                data-bs-toggle="modal" data-bs-target="#update_year"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать"
                                type="button"
                                data-id="${id}"
                                data-year="${year}"
                                data-students_count="${students_count}"
                                data-comment="${comment}">
                        </button>

                        <button id="copy" class="btn copy_btn br-none" type="button"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Копировать" onclick="copyYear(${id})"></button>

                        <button id="delete" class="btn copy_delete br-none"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить"
                        type="button" onclick="deleteYear(${id})"></button>
                    </div>
                </div>
            </script>


            <script id="faculty_tmpl" type="text/x-jquery-tmpl">
                <div class="row align-items-center py-2 mx-0 border-top" id="faculty_row_${id}">
                    <div class="col-8 ps-3">
                        <p class="m-0 fs-14 header" onclick="facultyDepartments(${id})" id="faculty_${id}">${name}</p>
                    </div>
                    <div class="col text-end">
                        <button id="edit" class="btn copy_edit br-none"
                                data-bs-toggle="modal" data-bs-target="#update_faculty"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать"
                                type="button"
                                data-id="${id}"
                                data-name="${name}">
                        </button>

                        <button id="delete" class="btn copy_delete br-none"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить"
                        type="button" onclick="deleteFaculty(${id})"></button>
                    </div>
                </div>
            </script>

            <script id="department_tmpl" type="text/x-jquery-tmpl">
                <div class="row align-items-center py-2 mx-0 border-top" id="department_row_${id}">
                    <div class="col pe-0 ps-3">
                        <p class="m-0 fs-14 header" onclick="programs(${id})" id="department_${id}">${name}</p>
                    </div>

                    <div class="col-auto ps-0 text-end">
                        <button id="edit" class="btn copy_edit br-none"
                                data-bs-toggle="modal" data-bs-target="#update_department"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Редактировать"
                                type="button"
                                data-id="${id}"
                                data-name="${name}">
                        </button>

                        <button id="delete" class="btn copy_delete br-none"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Удалить"
                        type="button" onclick="deleteDepartment(${id})"></button>
                    </div>
                </div>
            </script>

            <script id="program_tmpl" type="text/x-jquery-tmpl">

                <div class="row align-items-center py-2 mx-0 border-top" id="program_row_${id}">
                <div class="col-8 ps-3">
                    <p class="m-0 fs-14" id="program_${id}">${name}</p>
                </div>
                <div class="col text-end">
                    <button id="edit" class="btn copy_edit br-none" type="button" onclick="loadProgramInfo(${id})"></button>
                    <button id="delete" class="btn copy_delete br-none" type="button" onclick="deleteProgram(${id})"></button>
                </div>
            </div>

            </script>
            <script id="specialty_menu_tmpl" type="text/x-jquery-tmpl">
                <option value="${id}"> ${code} | ${name} </option>

            </script>
            <script id="specialty_tmpl" type="text/x-jquery-tmpl">
                <tr class="program_specialty_${id}">
                                       <th scope="row" class="ps-4">${code}</th>
                                       <td>${name}</td>
                                       <td class="pe-4"><button id="delete" class="btn copy_delete br-none" type="button" onclick="deleteProgramSpecialty(${id})"></button></td>
                                   </tr>

            </script>


            <script src="/js/dashboard/settings/organizations.js"></script>
@endsection
