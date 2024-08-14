@extends('layouts.dashboard.main')

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3 mb-4">
            @role('admin')
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                @include('layouts.dashboard.include.elements.tree')
            </div>
            @endrole
            <div class="col">
                <div class="out-kod"></div>
                <form class="pt-4 col-xl-10" id="search_form" onsubmit="searchWorks();return false">
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">ФИО обучающегося</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="student" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод...">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Тип работы</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="work_type" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод...">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="fs-14 mb-2 text-grey">Статус работы</p>
                            <div id="bg-white" class="bg-white">
                                <select class="js-example-basic-single w-100" name="state">
                                    <option value="0">Ожидает одобрения</option>
                                    <option value="1">Одобрена</option>
                                    <option value="2">Отклонена (отправлена на доработку)</option>
                                </select>
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
                            <p class="fs-14 mb-2 text-grey">УГНП</p>
                            <div id="bg-white_1">
                                <select class="js-example-basic-single w-100" name="specialty_id">
                                    @if(isset($specialties) and is_iterable($specialties))
                                        @foreach($specialties as $specialty)
                                            <option value="{{$specialty->id}}">{{$specialty->code}}
                                                | {{$specialty->name}}</option>
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
                                <input type="text" name="daterange" value="01/01/2023 - 01/15/2023"
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
                                <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 me-3">
                                    Применить
                                </button>
                                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 me-3"
                                        onclick="resetSearch();return false;">Сбросить
                                </button>
                                <button class="btn bg-green br-100 text-grey fs-14 py-1"
                                        onclick="exportWorks();return false;">
                                    Выгрузить
                                    <img src="/images/File_Download_green.svg" alt="" class="ps-2">
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="tmpl_modals">

        </div>
        <p class="fs-16 pt-3">
            <span class="text-grey">Работ: <span id="works_count"></span></span>
        </p>
        <div class="px-md-0 px-3 position-relative">
            <div class="big-table blue-scroll">
                <table class="table fs-14">
                    <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                    <tr class="text-grey">
                        <th scope="col">Направление подготовки</th>
                        <th scope="col">Обучающийся</th>
                        <th scope="col">Группа</th>
                        <th scope="col">Дата защиты</th>
                        <th scope="col">Наименование<br> работы - тип работы</th>
                        <th scope="col">Оценка</th>
                        <th scope="col">Самопроверка по другим системам</th>
                        <th scope="col">Проверка<br> ВКР-ВУЗка</th>
                        <th scope="col"><img src="/images/nine_dots.svg" alt="" class="pb-2"></th>
                    </tr>
                    </thead>
                    <tbody class="lh-17 brb-green-light-2" id="works_table">
                    </tbody>
                    @include('layouts.dashboard.include.menu.work.student')
                </table>
            </div>

            <div id="about_work">
            </div>
            <nav aria-label="Page navigation example" class="custom_pagination" id="works_pagination">
                <ul class="pagination m-0" id="pages">

                </ul>
            </nav>
        </div>
        @include('layouts.dashboard.include.modal.add.works.admin')
        @include('layouts.dashboard.include.modal.update.work_specialty')
        @include('layouts.dashboard.include.modal.other.additional_file')
        @include('layouts.dashboard.include.modal.add.import-work')
        @endsection

        @section('scripts')
            <script src="/js/dashboard/works/employees.js"></script>
            <script src="/js/dashboard/works/students.js"></script>
            <script src="{{'/js/bootstrap-select.js'}}"></script>
            <script id="work_tmpl" type="text/x-jquery-tmpl">
                @{{if visibility==1}}
               <tr id="work_${id}" @{{if deleted_at!=null}} class="deleted" @{{/if}}>
                {{--    <th scope="row">${specialty.name}</th>--}}
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
                        <span class="bg-active px-2 d-flex align-items-center">
                        <div class="me-2 green-c">
                        </div>
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
                        type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                @include('layouts.dashboard.include.menu.work.student')
                </td>
            </tr>
            @{{/if}}


            </script>

<script id="work_info_student_tmpl" type="text/x-jquery-tmpl">
    <div id="work_info_student" class="modal fade" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h3>Информация о работе</h3>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="tabs-list" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#"
                            @{{ if activeTabpanel === 'main-information'}}
                                class="nav-link active"
                            @{{ else }}
                                class="nav-link"
                            @{{/if}}
                            id="main-information-tab" data-bs-toggle="tab"
                                data-bs-target="#main-information" type="button" role="tab" aria-controls="main-information"
                                aria-selected="true">Основная информация</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#"
{{--                            @{{ if activeTabpanel === 'comments'}}--}}
{{--                                class="nav-link active"--}}
{{--                            @{{ else }}--}}
{{--                                class="nav-link"--}}
{{--                            @{{/if}}--}}
                            id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments"
                                type="button" role="tab" aria-controls="comments" aria-selected="false">Комментарии</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="main-information" role="tabpanel"
                            aria-labelledby="main-information-tab">
                            <form class="form form-horizontal d-flex flex-column gap-4 mt-4" id="infoWorkForm" onsubmit="workInfo(); return false;">
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Год выпуска</label>
                                    <div class="col-sm-8" id="value_year_id">${year.year}</div>
                                </div>
                                @{{if faculty}}
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Факультет</label>
                                    <div class="col-sm-8" id="faculty_id">${faculty.name}</div>
                                </div>
                                @{{/if}}
                                @{{if department}}
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Кафедра</label>
                                    <div class="col-sm-8" id="value_department_id">${department.name}</div>
                                </div>
                                @{{/if}}
                                @{{if specialty}}
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Образовательная программа (специальность)</label>
                                    <div class="col-sm-8">${specialty.name}</div>
                                </div>
                                @{{/if}}
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Кто загрузил работу</label>
                                    <div class="col-sm-8">${user.name}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">ФИО обучающегося</label>
                                    <div class="col-sm-8">${student}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Группа обучающегося</label>
                                    <div class="col-sm-8">${group}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Наименование работы</label>
                                    <div class="col-sm-8" id="value_name">${name}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Тип работы</label>
                                    <div class="col-sm-8" id="value_worktype">${work_type}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Научный руководитель</label>
                                    <div class="col-sm-8" id="value_scientific_adviser">${scientific_supervisor}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Дата защиты</label>
                                    <div class="col-sm-8" id="value_protectdate">${protect_date}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Дата загрузки работы</label>
                                    <div class="col-sm-8" id="value_createdon">${created_at}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Оценка</label>
                                    <div class="col-sm-8" id="value_assessment">${getAssessmentDescription(assessment)}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Согласие на размещение работы</label>
                                    <div class="col-sm-8" id="value_agreement">${getAgreementDescription(agreement)}</div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Файл работы</label>
                                    <div class="col-sm-8" id="value_workfile"><a onclick="downloadWork(); return false;"
                                            href="#"><span class="glyphicon glyphicon-save-file"></span> Скачать файл работы</a>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Самопроверка работы студентом</label>
                                    <div class="col-sm-8">
                                        <a href="#" onclick="updateSelfCheckStatus()" class="btn btn-sm" style="background: whitesmoke;"> <span
                                                id="self_check_value"> ${getSelfCheckDescription(self_check)} </span>
                                            <span class="glyphicon glyphicon-refresh"></span>
                                        </a>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Справка о самопроверке работы обучающимся по системе
                                        заимствований</label>
                                    @{{if certificate}}
                                    <a class="col-sm-8" onclick="downloadCertificate()">Скачать файл самопроверки</a>
                                    @{{else}}
                                    <div class="col-sm-8" id="value_certificate">Файл справки не загружен</div>
                                    @{{/if}}
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Отчет о заимствованиях по базам ВКР-ВУЗ</label>
                                    @{{if borrowings_percent}}
                                    <div class="col-sm-8" id="value_percent_person">Фактических некорректных заимствований:
                                        ${borrowings_percent}</div>
                                    @{{/if}}
                                </div>
                                <div id="works-add-alert"></div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                            <form class="form form-horizontal mt-4 d-flex flex-column gap-4" id="add_comment_form" onsubmit="addComment(); return false;">
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Заголовок</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="title"
                                            placeholder="Укажите заголовок комментария" required="">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold">Текст комментария</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control"
                                        name="text" placeholder="Укажите комментарий">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <label class="col-sm-4 fs-16 fw-bold"></label>
                                    <div class="col-sm-8 text-end">
                                        <button type="submit" class="btn btn-secondary fs-14 text-grey py-1">
                                            Добавить
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <h3 class="mb-3">Комментарии к работе:</h3>
                            <div class="row work-comment-pagination pagination pagination-sm" id="comments_list"></div>
                            <div class="work-comment-pagination pagination pagination-sm"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"
                        onclick="closeTmplModal('work_info_student')">Закрыть окно</button>
                </div>
            </div>
        </div>
    </div>

</script>

            <script id="comment_tmpl" type="text/x-jquery-tmpl">
                <div id="comment_${id}" class="mb-3" style="border-bottom: 1px solid #ccc">
                <div class="row row-comment">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-4">
								<span class="comment_date">
								    <span class="fw-bold">Дата написания:</span>
								    ${created_at}
								</span>
							</div>
							<div class="col-sm-6 fw-500">
								<span class="sender_name">
								    <span class="fw-bold">Автор:</span>
								    ${sender.name}
								</span>
							</div>
							<div class="col-sm-2">
								<a href="#" onclick="deleteComment(${id}); return false;">Удалить</a>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="comment_content">
									<h5 class="comment_title mb-0 mt-3">${title}</h5>
									<p class="mb-2 pt-3">${text}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>


            </script>
    @include('layouts.dashboard.include.tmpls.works_page')
@endsection


