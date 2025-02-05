@extends('layouts.dashboard.main')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                <div id="tree" class="br-green-light-2 br-15 p-3 overflow-auto blue-scroll" style="max-height: 430px;">
                    <ul class="ui-fancytree fancytree-container fancytree-plain overflow-auto" tabindex="0">
                        @if(is_iterable($years))
                            @foreach($years as $year)
                                <li class="fancytree-lastsib">
		    							<span
                                            class="fancytree-node fancytree-expanded fancytree-folder fancytree-has-children fancytree-exp-e fancytree-ico-ef">
		    								<span class="fancytree-title" id="year_{{$year->id}}">{{$year->year}}</span>
		    							</span>
                                    <ul>
                                        @if(is_iterable($year->departments))
                                            @foreach($year->departments as $department)
                                                <li class="fancytree-lastsib">
		    											<span
                                                            class="fancytree-node fancytree-lastsib fancytree-exp-nl fancytree-ico-c"><span
                                                                class="fancytree-expander"></span>
		    											<span class="fancytree-title"
                                                              id="department_{{$department->id}}">{{$department->name}}</span>
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
            <div class="col">
                <form class="pt-4 col-xxl-6 col-xl-5 col-md-8" onsubmit="searchUsers();return false;" id="search_users">
                    <div class="row">
                        <div class="col-xxl-6">
                            <p class="fs-14 m-0 text-grey">Статус</p>
                            <div class="form-check mt-2">
                                <input class="form-check-input green" type="radio" name="is_active" id="default_status"
                                       value="1"
                                       checked>
                                <label class="form-check-label" for="status1">
                                    Активен
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input green" type="radio" name="is_active" id="status2"
                                       value="0">
                                <label class="form-check-label" for="status2">
                                    Заблокирован
                                </label>
                            </div>
                        </div>

                        <div class="col-xxl-6">
                            <p class="fs-14 m-0 text-grey">Тип пользователя</p>
                            <div class="form-check mt-2">
                                <input class="form-check-input green" type="radio" name="role" id="default_type"
                                       value="user"
                                       checked>
                                <label class="form-check-label" for="user_type1">
                                    Студентам
                                </label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input green" type="radio" name="role" id="user_type2"
                                       value="teacher">
                                <label class="form-check-label" for="user_type2">
                                    Преподавателям
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="input-group input-group-lg br-100 br-green-light-2 focus-form mt-3">
                        <input type="text" name="name" id="name_input" class="form-control search br-none fs-14 form-small-p"
                               placeholder="Поиск по имени">
                        <button class="btn pe-3 py-0 d-flex align-items-center" type="submit" id="search">
                            <img src="/images/Search.svg" alt="search">
                        </button>
                    </div>
                    <div class="input-group input-group-lg br-100 br-green-light-2 focus-form mt-3">
                        <input type="text" name="email" id="email_input" class="form-control search br-none fs-14 form-small-p"
                               placeholder="Поиск по email">
                        <button class="btn pe-3 py-0 d-flex align-items-center" type="submit" id="search">
                            <img src="/images/Search.svg" alt="search">
                        </button>
                    </div>
                    <div class="input-group input-group-lg br-100 br-green-light-2 focus-form mt-3">
                        <input type="text" name="group" id="group_input" class="form-control search br-none fs-14 form-small-p"
                               placeholder="Группа">
                        <button class="btn pe-3 py-0 d-flex align-items-center" type="submit" id="search">
                            <img src="/images/Search.svg" alt="search">
                        </button>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100 text-grey fs-14 br-100 br-none mt-4 mb-5">
                        Применить
                    </button>

                    <button class="btn btn-secondary br-green-light-2 w-100 text-grey fs-14 br-100 br-none mt-4 mb-5" onclick="resetSearch()">
                        Сбросить
                    </button>
{{--                    <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 me-3" onclick="resetEmployeeSearch();return false">--}}
{{--                        Сбросить--}}
{{--                    </button>--}}
                </form>
                <div class="out-kod"></div>
            </div>
        </div>
        <div class="pt-5 px-md-0 px-3">
            <p class="text-grey fs-16">Пользователей: <span class="text-grey" id="users_count"></span></p>
            <div class="row g-3" id="users_list">


            </div>
            <nav aria-label="Page navigation example" class="custom_pagination" id="users_pagination">
                <ul class="pagination m-0" id="pages">

                </ul>
            </nav>
        </div>
    </div>
    <div id="report_container">

    </div>
    @include('layouts.dashboard.include.elements.works_menu')

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit">
        <div class="offcanvas-header border-bottom">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            <h5 class="offcanvas-title fw-600 fs-16 text-center pe-5">Редактирование пользователя</h5>
        </div>
        <div class="offcanvas-body" id="canvas_body">

        </div>
    </div>
@endsection

@section('scripts')

    <script src="/js/dashboard/settings/user_management.js">

    </script>
    <script src="/js/app.js"></script>
    <script src="/js/user.js"></script>
    <script id="user_tmpl" type="text/x-jquery-tmpl">
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12" id="user_${id}">
                <div class="br-green-light-1 p-3 br-15">
                        <div class="d-flex justify-content-between align-items-center pb-4">
                            <button class="btn copy_edit br-none" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasEdit" aria-controls="offcanvasEdit" onclick="openUpdateUserCanvas(${id})"></button>
                            <div class="bg-active br-100">
                            @{{if is_active}}
                                <p class="text-grey fs-14 m-0 px-3 d-flex gap-2 align-items-center">
                                    <img src="/images/green_active.svg" alt="">
                                    Активен
                                </p>
                            @{{else}}
                              <p class="text-grey fs-14 m-0 px-3 px-3 d-flex gap-2 align-items-center">
                                  <img src="/images/red.svg" alt="">
                                  Заблокирован
                              </p>
                             @{{/if}}
                            </div>
                        </div>
                    <p>${name}</p>
                    <div class="border-left ps-3">
                        <p class="text-grey fs-14 m-0">Группа: ${group}</p>
                        <p class="text-grey fs-14 m-0">${date_of_birth}</p>
                        <p class="text-grey fs-14 m-0">
                         @{{if email_visibility==1}}${email}@{{else}} *******@*******@{{/if}}
                        </p>
                    </div>
                    @{{if is_active}}
                    <div class="mt-3"><img src="/images/Lock_1.svg" alt=""><a href="#"
                                                                             class="text-grey link-active-hover fs-14 ps-2" onclick="blockUser(${id})">Заблокировать</a>
                    </div>
                    @{{else}}
                    <div class="mt-3"><img src="/images/Lock_1.svg" alt="">
                    <a href="#" class="text-grey link-active-hover fs-14 ps-2"  onclick="unblockUser(${id})">Разблокировать</a>
                    </div>
                    @{{/if}}
                    <p class="mt-2"><img src="/images/setting_grey.svg" alt=""><a href="#"
                                                                     class="text-grey ps-2 fs-14 link-active-hover" onclick="resetUserPassword('${email}')">Сбросить
                        пароль</a></p>
                    <div class="bg-green-light br-5 d-flex justify-content-center py-1 header" onclick="openWorks(${id})"
                            data-bs-toggle="modal"
                            data-bs-target="#user_works_modal">
                        <img src="/images/doc_green.svg" alt="" class="pe-2">
                        <p class="text-muted fs-6 m-0">
                            Загруженных<br> документов: @{{if typeof works!='undefined'}} ${works.length} @{{else}} 0 @{{/if}}
                        </p>
                    </div>
                </div>
            </div>




    </script>

    @include('layouts.dashboard.include.tmpls.works.report')

    <script type="text/x-jquery-tmpl" id="off_canvas_user">
        <div class="px-4">
        <form onsubmit="updateUser(${id});return false" id="update_user_form">
            <p class="fs-14 m-0 pt-4">Тип пользователя</p>
            <div class="form-check mt-2">
                <input class="form-check-input green" type="radio" name="role" value="user" id="user_type1"
                       @{{if roles[0].slug =='user'}} checked @{{/if}}>
                <label class="form-check-label">
                    Студент
                </label>
            </div>
            <div class="form-check mt-2">
                <input class="form-check-input green" type="radio" name="role" value="teacher" id="user_type2"
                       @{{if roles[0].slug =='teacher'}} checked @{{/if}}>
                <label class="form-check-label">
                    Преподаватель
                </label>
            </div>
            <div class="mb-3 pt-4">
                <label for="fio">ФИО</label>
                <input type="text" name="name" class="form-control fs-16 text-black" id="fio"
                       value="${name}" required>
            </div>
            <div class="mb-3">
                <label for="group">Группа</label>
                <input type="text" name="group" class="form-control fs-16 text-black" id="group"
                       value="${group}" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control fs-16 text-black" id="email"
                       value="@{{if email_visibility==1}}${email}@{{else}} *******@*******@{{/if}}" required>
            </div>
            <div class="mb-3">
                <label for="date_registration">Дата регистрации</label>
                <input type="text" class="form-control bg-grey-form fs-16 text-grey" id="date_registration"
                       value="${created_at}" readonly>
            </div>
            <button type="submit" class="btn btn-secondary w-100 text-grey fs-14 br-100 br-none mt-4 mb-5">Применить</button>
            </form>
        </div>




    </script>

    @include('layouts.dashboard.include.tmpls.work')

@endsection
