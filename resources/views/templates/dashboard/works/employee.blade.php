@extends('layouts.dashboard.main')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            @role('admin')
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                <div id="tree" class="br-green-light-2 br-15 p-3 blue-scroll overflow-auto" style="max-height: 420px">
                    <ul class="ui-fancytree fancytree-container fancytree-plain" tabindex="0">
                        @if(is_iterable($years))
                            @foreach($years as $year)
                                <li class="">
		    						<span
                                        class="fancytree-node fancytree-expanded fancytree-folder fancytree-has-children fancytree-exp-e fancytree-ico-ef">
		    							<span class="fancytree-title" id="year_{{$year->id}}">{{$year->year}}</span>
		    						</span>
                                    <ul>
                                        @if(is_iterable($year->faculties))
                                            @foreach($year->faculties as $faculty)
                                                <li class="fancytree-lastsib">
		    								<span
                                                class="fancytree-node fancytree-expanded fancytree-folder fancytree-has-children fancytree-exp-e fancytree-ico-ef">
		    									<span class="fancytree-title"
                                                      id="faculty_{{$faculty->id}}">{{$faculty->name}}</span>
                                            </span>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            @endrole
            <div class="col">
                <div class="out-kod"></div>
                <form class="pt-4 col-xl-10" id="search_form" onsubmit="searchWorks();return false">
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <p class="fs-14 mb-2 text-grey">Сотрудник</p>
                            <div id="bg-white" class="bg-white">
                                <select class="js-example-basic-single w-100" name="scientific_supervisor"
                                        id="scientific_supervisors_list">
                                    <option></option>
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
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод..."
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
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод..."
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
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод..."
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
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод..."
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
                                <input type="text" name="daterange" value=""
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
                                        class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 me-3">
                                    Применить
                                </button>
                                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 me-3"
                                        onclick="resetEmployeeSearch();return false">
                                    Сбросить
                                </button>
                                @role('admin|inspector')
                                <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 me-3"
                                        onclick="exportWorks();return false;">
                                    Выгрузить
                                    <img src="/images/File_Download_green.svg" alt="" class="ps-2"></button>
                                @endrole
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="tmpl_modals">

        </div>
        <div class="d-flex justify-content-end mt-5">
            @role('admin|employee')
            <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 w-25 me-3"
                    onclick="openModal('add_work_modal')" data-bs-target="#add_work_modal" data-bs-toggle="modal">
                Добавить работу
                <img src="/images/pl-green.svg" alt="" class="ps-2">
            </button>
            <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 w-25"
                    onclick="openModal('import_work_modal')" data-bs-target="#import_work_modal" data-bs-toggle="modal">
                Импорт из файла
                <img src="/images/File_Download_green.svg" alt="" class="ps-2">
            </button>
            @endrole
        </div>

        <p class="fs-16 pt-3">
            <span class="text-grey">Работ: <span id="works_count" class="text-grey"></span></span>
        </p>
        <div class="pt-3 px-md-0 px-3 position-relative">
            <div class="big-table">
                <table class="table fs-14">
                    <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                    <tr class="text-grey">
                        <th scope="col">Направление подготовки</th>
                        <th scope="col">Обучающийся</th>
                        <th scope="col">Группа</th>
                        <th scope="col">Дата защиты</th>
                        <th scope="col">Наименование<br> работы - тип работы</th>
                        <th scope="col">Оценка</th>
                        <th scope="col">Самопроверка <br> по другим системам</th>
                        <th scope="col">Проверка<br> ВКР-СМАРТ</th>
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
        <div id="report_container">

        </div>
        @include('layouts.dashboard.include.modal.add.works.others')
        @include('layouts.dashboard.include.modal.update.work_specialty')
        @include('layouts.dashboard.include.modal.other.additional_file')
        @include('layouts.dashboard.include.modal.add.import-work')
        @endsection

        @section('scripts')
            <script src="{{'/js/bootstrap-select.js'}}"></script>
            <script src="/js/dashboard/works/employees.js"></script>
            <script src="/js/bootstrap.js"></script>
            <script type="text/javascript" src="/js/jquery/moment.min.js"></script>
            <script type="text/javascript"
                    src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

            @include('layouts.dashboard.include.tmpls.works_page')

            <script id="work_tmpl" type="text/x-jquery-tmpl">
{{--      @{{if visibility==1}}--}}
                <tr id="work_${id}" @{{if deleted_at!=null}} class="deleted" @{{/if}}>
               <th scope="row">@{{if specialty}}
                                           ${specialty.name}
                                           @{{else}}
                                           Не указан
                                           @{{/if}}
                                           </th>
               <td>${student}</td>
               <td>${group}</td>
               <td>${protect_date}</td>
               <td>${name} - ${work_type}</td>
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
                           <span class="bg-active p-2 d-flex align-items-center cursor-p">
                               <div class="me-2 green-c"></div>
                               Отчет
                           </span>
                       </div>
                       @{{/if}}
                       @{{if report_status==2}}
                       <div>
                           <span class="bg-error p-2 d-flex align-items-center gap-2">
                               <span class="red-c"></span>
                               Не&nbsp;проверена
                           </span>
                       </div>
                       @{{/if}}

                   </td>
                   <td>
                       <img src="/images/three_dots.svg" alt="" id="work-menu-button" class="btn-info-box cursor-p dropdown-toggle"
                       type="button" onclick="openInfoBox(${id})"
                       data-bs-toggle="dropdown" aria-expanded="false">
@include('layouts.dashboard.include.menu.work.employee')
                </td>
            </tr>
{{--            @{{/if}}--}}


            </script>

@endsection
