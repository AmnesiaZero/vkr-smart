@extends('layouts.dashboard.main')
@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            @role('admin')
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                @include('layouts.dashboard.include.elements.tree',['years' => $years])
            </div>
            @endrole
            <div class="col">
                <div class="out-kod"></div>
                <form id="search_users_form" class="pt-4 col-xl-10" onsubmit="searchUsers();return false">
                    <div class="row g-3">
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">ФИО обучающегося</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="name" value=""
                                       class="form-control search br-none fs-14 form-small-p" id="name_input"
                                       placeholder="Ввод...">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                                    <img src="/images/Search.svg" alt="search">
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <p class="text-grey mb-2 fs-14">Группа</p>
                            <div class="input-group input-group-lg br-100 br-green-light-2 focus-form">
                                <input type="text" name="group" value=""
                                       class="form-control search br-none fs-14 form-small-p" id="group_input"
                                       placeholder="Ввод...">
                                <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
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
                                       class="form-control search br-none fs-14 form-small-p" placeholder="Ввод..."
                                       id="email_input">
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
                                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1"
                                        onclick="resetSearch();return false">
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
            <nav aria-label="Page navigation example" class="custom_pagination" id="users_pagination">
                <ul class="pagination m-0" id="pages">

                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/dashboard/portfolios/main.js"></script>

    @include('layouts.dashboard.include.tmpls.user_portfolio')

@endsection
