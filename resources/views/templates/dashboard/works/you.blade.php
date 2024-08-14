@extends('layouts.dashboard.main')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            <div class="col">
                <div class="out-kod"></div>
                <form class="pt-4 col-xl-10" id="search_form" onsubmit="searchWorks();return false">
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <p class="fs-14 mb-2 text-grey">Сотрудник</p>
                            <div id="bg-white" class="bg-white">
                                <select class="js-example-basic-single w-100" name="scientific_supervisor"
                                        id="scientific_supervisors_list">
                                    <option value="">Выбрать</option>
                                    @if(isset($scientific_supervisors) and is_iterable($scientific_supervisors))
                                        )
                                        @foreach($scientific_supervisors as $scientific_supervisor)
                                            <option
                                                value="{{$scientific_supervisor->name}}">{{$scientific_supervisor->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">ФИО обучающегося</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="student" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder=""
                                       id="student_input">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Название работы</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="name" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder=""
                                       id="work_name_input">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Группа</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="group" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder=""
                                       id="group_input">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Тип работы</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="work_type" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder=""
                                       id="work_type_input">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="fs-14 mb-2 text-grey">УГНП</p>
                            <div id="bg-white_1">
                                <select class="js-example-basic-single w-100" name="specialty_id" id="specialties_list">
                                    <option value="" id="default_specialty">Выбрать</option>
                                    @if(isset($program_specialties) and is_iterable($program_specialties))
                                        @foreach($program_specialties as $program_specialty)
                                            <option
                                                value="{{$program_specialty->id}}">{{$program_specialty->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="fs-14 mb-2 text-grey">Период загрузки работ</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form pe-2">
                                <button class="btn pe-3 py-0 fs-14" disabled>
                                    <img src="/images/Calendar.svg" alt="">
                                </button>
                                {{--                                Временно поменял имя,чтобы не мешалось--}}
                                <input type="text" name="daterange" value="04.06.2024 - 07.06.2024"
                                       class=" fs-14 text-grey p-date w-75"/>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="fs-14 mb-2 text-grey">Отображение работ</p>
                            <div id="bg-white_1">
                                <select class="js-example-basic-single w-100" name="delete_type" id="delete_type">
                                    <option value="2" selected>Отображать все работы</option>
                                    <option value="0">Отображать только активные</option>
                                    <option value="1">Отображать только удаленные</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row pt-4 d-flex align-items-end">
                        <div class="col">
                            <div class="mt-auto">
                                <button type="submit"
                                        class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 me-3">применить
                                </button>
                                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 me-3"
                                        onclick="resetSearch();return false">сбросить
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="tmpl_modals">

        </div>
        <div class="d-flex mt-5">
            <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 w-75 me-3"
                    onclick="openModal('add_work_modal')">добавить
                <img src="/images/pl-green.svg" alt="" class="ps-2"></button>
        </div>

        <p class="fs-14 pt-3">
            <span class="text-grey">Работ: <span id="works_count"></span></span>
        </p>
        <div class="pt-3 px-md-0 px-3 position-relative">
            <div class="big-table">
                <table class="table fs-14">
                    <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                    <tr class="text-grey">
                        <th scope="col">Группа</th>
                        <th scope="col">Дата защиты</th>
                        <th scope="col">Наименование<br> работы - тип работы</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Оценка</th>
                        <th scope="col">Самопроверка по другим системам</th>
                        <th scope="col">Проверка<br> ВКР-ВУЗка</th>
                        <th scope="col"><img src="/images/nine_dots.svg" alt="" class="pb-2"></th>
                    </tr>
                    </thead>
                    <tbody class="lh-17 brb-green-light-2" id="works_table">
                    </tbody>
                </table>
            </div>


            <div id="about_work">
            </div>
            <nav aria-label="Page navigation example" class="custom_pagination" id="works_pagination">
                <ul class="pagination m-0" id="pages">

                </ul>
            </nav>
        </div>
        @include('layouts.dashboard.include.menu.work.you')

        <div id="report_container">

        </div>

        @include('layouts.dashboard.include.modal.add.works.you')
        @include('layouts.dashboard.include.modal.update.work_specialty')
        @include('layouts.dashboard.include.modal.other.additional_file')
        @include('layouts.dashboard.include.modal.add.import-work')
        @endsection

        @section('scripts')
            <script src="{{'/js/bootstrap-select.js'}}"></script>
            <script src="/js/dashboard/works/you.js"></script>
            <script src="/js/bootstrap.js"></script>
            <script type="text/javascript" src="/js/jquery/moment.min.js"></script>
            <script type="text/javascript"
                    src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
            <script id="faculty_tmpl" type="text/x-jquery-tmpl">
        <option value="${id}">${name}</option>



            </script>

            <script id="department_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>




            </script>

            <script id="specialty_tmpl" type="text/x-jquery-tmpl">
     <option value="${id}">${name}</option>

            </script>

            <script id="work_tmpl" type="text/x-jquery-tmpl">
     <tr id="work_${id}" @{{if deleted_at!=null}} class="deleted" @{{/if}}>
    <td>${group}</td>
    <td>${protect_date}</td>
    <td>${name}</td>
    <td>${description}</td>
    <td>${getAssessmentDescription(assessment)}</td>
    <td>${getSelfCheckDescription(self_check)}</td>
        <td>
            @{{if report_status==0}}
            <div class="mt-2">
            <span class="bg-waiting px-2 d-flex align-items-center">
            <div class="me-2 yellow-c">
            </div>
              В очереди на проверку
            </span>
            </div>
            @{{/if}}
            @{{if report_status==1}}
            <div class="mt-2" onclick="openReport(${id})">
            <span class="bg-active px-2 d-flex align-items-center">
            <div class="me-2 green-c">
            </div>
              Отчет
            </span>
            </div>
            @{{/if}}
            @{{if report_status==2}}
            <div class="mt-2">
            <span class="bg-error px-2 d-flex align-items-center">
            <div class="me-2 red-c">
            </div>
              Не проверена
            </span>
            </div>
            @{{/if}}

        </td>
        <td>
            <img src="/images/three_dots.svg" alt="" class="btn-info-box cursor-p" onclick="openInfoBox(${id})">
        </td>
    </tr>




            </script>

            <script id="work_info_tmpl" type="text/x-jquery-tmpl">
        <div id="work_info_modal" style="display: block;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteElement('work_info_modal');return false"><span aria-hidden="true">×</span></button>
                        <h3>Информация о работе</h3>
                    </div>
                    <div class="modal-body">
                        <h3 class="bc-post-title bc-post-title-sm">Информация о работе</h3>
                        <form class="form form-horizontal" id="infoWorkForm" onsubmit="workInfo(); return false;">
                            <div class="form-group">
                                <label class="col-sm-4">Год выпуска</label>
                                <div class="col-sm-8" id="value_year_id">${year.year}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Факультет</label>
                                <div class="col-sm-8" id="faculty_id">${faculty.name}</div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4">Кто загрузил работу</label>
                                <div class="col-sm-8">${user.name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">ФИО обучающегося</label>
                                <div class="col-sm-8" >${student}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Группа обучающегося</label>
                                <div class="col-sm-8">${group}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Наименование работы</label>
                                <div class="col-sm-8" id="value_name">${name}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Тип работы</label>
                                <div class="col-sm-8" id="value_worktype">${work_type}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Научный руководитель</label>
                                <div class="col-sm-8" id="value_scientific_adviser">${scientific_supervisor}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Дата защиты</label>
                                <div class="col-sm-8" id="value_protectdate">${protect_date}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Дата загрузки работы</label>
                                <div class="col-sm-8" id="value_createdon">${created_at}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Оценка</label>
                                <div class="col-sm-8" id="value_assessment">${getAssessmentDescription(assessment)}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Согласие на размещение работы</label>
                                <div class="col-sm-8" id="value_agreement">${getAgreementDescription(agreement)}</div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Файл работы</label>
                                <div class="col-sm-8" id="value_workfile"><a onclick="downloadWork(); return false;" href="#"><span class="glyphicon glyphicon-save-file"></span> Скачать файл работы</a></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Самопроверка работы студентом</label>
                                <div class="col-sm-8" id="self_check_value">
                                <a href="#" onclick="updateSelfCheckStatus()" class="btn btn-sm" style="background: whitesmoke;">
                                    ${getSelfCheckDescription(self_check)}
                                <span class="glyphicon glyphicon-refresh">
                                </span>
                                </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Справка о самопроверке работы обучающимся по системе заимствований</label>
                                @{{if certificate}}
                                <a class="col-sm-8" onclick="downloadCertificate()">Скачать файл самопроверки </a>
                                @{{else}}
                                <div class="col-sm-8" id="value_certificate">Файл справки не загружен</div>
                                @{{/if}}
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Отчет о заимствованиях по базам ВКР-ВУЗ</label>
                                @{{if borrowings_percent}}
                                <div class="col-sm-8" id="value_percent_person">Фактических некорректных заимствований: ${borrowings_percent}</div>
                                @{{/if}}
                            </div>
                            <div id="works-add-alert"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="deleteElement('work_info_modal');return false">Закрыть окно</button>
                    </div>
                </div>
            </div>
        </div>


            </script>

            <script id="deleted_menu_tmpl" type="text/x-jquery-tmpl">
     <div class="d-flex cursor-p mb-2">
        <img src="/images/Trash_Full.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="restore()">Восстановить работу</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Trash_Full.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="destroyWork()">Безвозвратно удалить работу<br> обучающего и все файлы</p>
    </div>


            </script>
            <script id="undeleted_menu_tmpl" type="text/x-jquery-tmpl">
        <div class="d-flex cursor-p mb-2">
        <img src="/images/copy.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="copyWork()">Сделать копию записи без создания файлов</p>
    </div>
    <div class="d-flex cursor-p mb-2">
        <img src="/images/Trash_Full.svg" alt="" class="pe-2">
        <p class="fs-14 lh-17 text-grey m-0" onclick="deleteWork()">Поместить работу на удаление</p>
    </div>


            </script>

            <script id="self_check_tmpl" type="text/x-jquery-tmpl">
       <a href="#" onclick="updateSelfCheckStatus()" class="btn btn-sm" style="background: whitesmoke;">
          ${getSelfCheckDescription(self_check)}
          <span class="glyphicon glyphicon-refresh"></span>
       </a>
            </script>

            <script id="additional_file_tmpl" type="text/x-jquery-tmpl">
        <tr id="additional_file_${id}">
            <td>${file_name}</td>
            <td>
                <a target="_blank" href="/dashboard/works/employees/additional-files/download?id=${id}" class="btn btn-sm btn-success btn-block">Скачать</a>
                <a onclick="deleteAdditionalFile(${id}); return false;" href="#" class="btn btn-sm btn-danger btn-block">Удалить</a>
            </td>
        </tr>

            </script>

            <script id="update_work_tmpl" type="text/x-jquery-tmpl">
    <div class="modal-dialog modal-lg" id="update_work_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Редактирование направления подготовки квалификационной работы</h3>
            </div>
            <form class="form form-horizontal" id="update_work_form" onsubmit="updateWork(); return false;">
                <div class="modal-body">
                    <div id="editWorkSpecialtieAlert"></div>
                    <div class="form-group">
                        <label class="col-sm-4">ФИО обучающегося</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="student" value="${student}" placeholder="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-sm-4">Группа обучающегося</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="group" value="${group}" placeholder="">
                    </div>
                </div>
                    <div class="form-group">
                        <label class="col-sm-4">Наименование работы</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" placeholder="" value="${name}" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Научный руководитель</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="scientific_supervisor" value="${scientific_supervisor}">
                                <span style="font-size:13px; display:block; margin:0.5rem 0; color:#999;">Или выберите из списка:</span>
                                <select name="scientific_supervisor" class="form-control">
                                    <option value="">Выбрать...</option>
                                    @if(isset($scientific_supervisors) and is_iterable($scientific_supervisors))
                    @foreach($scientific_supervisors as $scientific_supervisor)
                        <option value="{{$scientific_supervisor->name}}">{{$scientific_supervisor->name}}</option>

                    @endforeach
                @endif
                </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Тип работы</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="work_type" value="${work_type}">
                <span style="font-size:13px; display:block; margin:0.5rem 0; color:#999;">Или выберите из списка:</span>
                <select name="work_type" class="form-control">
                    <option value="">Выбрать...</option>
@if(isset($works_types) and is_iterable($works_types))
                    @foreach($works_types as $works_type)
                        <option value="{{$works_type->name}}">{{$works_type->name}}</option>

                    @endforeach
                @endif
                </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Дата защиты</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" name="protect_date" value="${protect_date}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Оценка</label>
        <div class="col-sm-8">
            <select class="selectpicker bs-select-hidden" data-width="100%" data-style="btn"
                    name="assessment">
                <option value="0" @{{if assessment==0}} selected @{{/if}}>Без оценки</option>
                <option value="5" @{{if assessment==5}} selected @{{/if}}>Отлично</option>
                <option value="4" @{{if assessment==4}} selected @{{/if}}>Хорошо</option>
                <option value="3" @{{if assessment==3}} selected @{{/if}}>Удовлетворительно</option>
                <option value="2" @{{if assessment==2}} selected @{{/if}}>Неудовлетворительно</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Согласие на размещение работы</label>
        <div class="col-sm-8">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="1" name="agreement" checked=""> @{{if agreement==1}} Да @{{else}} Нет @{{/if}}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4">Способ проверки работы по базе ВКР-ВУЗ:</label>
        <div class="col-sm-8">
            <div class="radio">
                <label>
                    <input type="radio" name="verification_method" value="0" @{{if verification_method==0}} selected @{{/if}}> Проверить автоматически после
                        загрузки
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="verification_method" value="1" checked="" @{{if verification_method==1}} selected @{{/if}}> Проверить работу в ручном
                        режиме
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="verification_method" value="2" @{{if verification_method==2}} selected @{{/if}}> Не проверять работу после загрузки
                </label>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-success">Изменить</button>
    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="closeModal('update_work_modal')">Отмена</button>
</div>
</form>
</div>
</div>


            </script>


            <script id="report_tmpl" type="text/x-jquery-tmpl">
 <div id="report_modal" class="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="closeTmplModal('add_achievement_modal')">×</span></button>
                <h3>Полный отчет по работе</h3>

            </div>
            <div class="modal-body">
                <div id="report_modal">
                    <span> Полный отчет по работе </span>
                    <div class="col-sm-8">
                        <ol style="padding-left:15px;">
                            <li>Результаты проверки по базам данных ВКР-ВУЗ:
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
                                <td><a target="_blank" href="${value.link}" class="ng-binding"></a></td>
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

@endsection
