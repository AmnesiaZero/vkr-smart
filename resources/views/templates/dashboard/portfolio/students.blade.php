@extends('layouts.dashboard.main')
@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                @include('layouts.dashboard.include.elements.tree',['years' => $years])
            </div>
            <div class="col">
                <div class="out-kod"></div>
                <form id="search_users_form" class="pt-4 col-xl-10" onsubmit="searchUsers();return false">
                    <div class="row g-3">
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">ФИО обучающегося</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="name" value=""
                                       class="form-control search br-none fs-14 form-small-p" id="name_input" placeholder="Ввод...">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Группа</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="group" value=""
                                       class="form-control search br-none fs-14 form-small-p" id="group_input" placeholder="Ввод...">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search" >
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 pt-3 d-flex align-items-end">
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Поиск по email</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="email" value=""
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод..." id="email_input">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="mt-auto d-flex gap-3">
                                <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1">
                                    Применить
                                </button>
                                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1" onclick="resetSearch();return false">
                                    Сбросить
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @include('layouts.dashboard.include.elements.works_menu')
        <div class="pt-5 px-md-0 px-3">
            <p class="text-grey fs-14">Пользователей: <span class="text-black" id="users_count"></span></p>
            <div class="row g-3" id="users_list">

            </div>
            <nav aria-label="Page navigation example" class="custom_pagination" id="pagination">
                <ul class="pagination m-0" id="pages">

                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/dashboard/portfolios/main.js"></script>

    <script id="user_tmpl" type="text/x-jquery-tmpl">
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="br-green-light-1 p-3 br-15">
                <div class="d-flex pb-4">
                    @{{if is_active==1}}
                    <div class="bg-active br-100">
                    <p class="text-grey fs-14 m-0 px-3">
                        <span><img src="/images/green_active.svg" alt="" class="pe-2"></span>Активен</p>
                    </div>
                    @{{else}}
                    <div class="bg-error br-100">
                    <p class="text-grey fs-14 m-0 px-3"><span><img src="/images/red.svg" alt=""
                                                                   class="pe-2"></span>Заблокирован</p>
                    </div>
                    @{{/if}}
                </div>
                <p>${name}</p>
                <div class="border-left ps-3 mb-3">
                    <p class="text-grey fs-14 mb-1">Группа:
                        ${group}
                    </p>
                    <p class="text-grey fs-14 mb-1">
                        ${date_of_birth}
                    </p>
                    <p class="text-grey fs-14 mb-1">
                        ${email}
                    </p>
                </div>
                <p class="mb-1"><img src="/images/doc_grey_img.svg" alt=""><a href="#"
                                                                              class="text-grey ps-2 fs-14 link-active-hover" onclick="openWorks(${id})">работы</a>
                </p>
                <p class="mb-1"><img src="/images/User_Card_Id_Grey.svg" alt=""><a href="/dashboard/portfolio/${id}"
                                                                                   class="text-grey ps-2 fs-14 link-active-hover">портфолио</a>
                </p>
                <p class="mb-1"><img src="/images/setting_grey.svg" alt=""><a href="/dashboard/portfolio/achievements/${id}"
                                                                              class="text-grey ps-2 fs-14 link-active-hover">управление
                    портфолио</a></p>
            </div>
        </div>
    </script>


@endsection
