@extends('layouts.dashboard.main')

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12 mb-4">
        <div class="row pt-4 g-3 px-md-0 px-3 mb-5">
            <div class="col-xxl-4 col-xl-5 col-lg-6">
                @include('layouts.dashboard.include.elements.tree',['years' => $years])
                <button class="btn btn-secondary text-grey br-none br-100 fs-14 w-100 mt-3 py-1"
                        onclick="getReport();return false">
                    За все время
                </button>
            </div>

            <div class="col-xxl-8 col-xl-7 col-lg-6">

            </div>

            <div class="out-kod mb-3"></div>

            <div id="report_container"></div>
        </div>

        @endsection

        @section('scripts')
            <script src="/js/dashboard/reports.js"></script>

            <script id="report_tmpl" type="text/x-jquery-tmpl">

            <div class="col">

                <div class="row g-4">
                    <div class="col-xl-6">
                        <div class="br-green-light-2 p-3 br-20">
                            <div class="text-grey fw-600 fs-16 d-flex align-items-center gap-3 mb-3">
                                <img src="/images/Users_Group-l.svg">
                                Пользователей всего
                                <span class="fs-24 text-grey fw-600">
                                    ${roles_users[0]}
                                </span>
                            </div>
                            @{{each roles}}

                            @{{if findRole(roles_users,this[0])}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">${this[1]}</p>
                                <p class="text-grey fs-14 mb-2">
                                    ${roles_users[getRoleIndex()].users_count}
                                </p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">${this[1]}</p>
                                <p class="text-grey fs-14 mb-2"> 0
                                </p>
                            </div>
                            @{{/if}}
                            @{{/each}}
                        </div>
                        <div class="br-green-light-2 p-3 br-20 mt-4">
                            <div class="text-grey fs-16 fw-600 d-flex align-items-center gap-3 mb-3">
                                <img src="/images/User_Card_ID-l.svg">
                                Портфолио всего
                                <span class="fs-24 text-grey fw-600">${roles_users[0]}</span>
                            </div>
                            @{{if findRole(roles_achievements,'user')}}
                            <div class="d-flex justify-content-between brt-green-light-2 mt-3">
                                <p class="text-grey fs-14 mb-3 mt-1">Студенты</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Записи достижений:</p>
                                <p class="text-grey fs-14 mb-2">
                                    ${roles_achievements[getRoleIndex()].achievements_count}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>
                                <p class="text-grey fs-14 mb-2">${roles_achievements[getRoleIndex()].records_count}</p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between brt-green-light-2 mt-3">
                                <p class="text-grey fs-14 mb-3 mt-1">Студенты</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Записи достижений:</p>
                                <p class="text-grey fs-14 mb-2">
                                    0
                                </p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>
                                <p class="text-grey fs-14 mb-2">0</p>
                            </div>

                            @{{/if}}

                            @{{if findRole(roles_achievements,'teacher')}}
                            <div class="d-flex justify-content-between brt-green-light-2 mt-3">
                                <p class="text-grey fs-14 mb-3 mt-1">Преподаватели</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Записи достижений:</p>
                                <p class="text-grey fs-14 mb-2">
                                    ${roles_achievements[getRoleIndex()].achievements_count}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>
                                <p class="text-grey fs-14 mb-2">${roles_achievements[getRoleIndex()].records_count}</p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between brt-green-light-2 mt-3">
                                <p class="text-grey fs-14 mb-3 mt-1">Преподаватели</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Записи достижений:</p>
                                <p class="text-grey fs-14 mb-2">
                                    0
                                </p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>
                                <p class="text-grey fs-14 mb-2">0</p>
                            </div>

                            @{{/if}}

                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="br-green-light-2 p-3 br-20">

                            <div class="text-grey fs-16 fw-600 d-flex align-items-center gap-3 mb-3">
                                <img src="/images/File_Document.svg">
                                Загруженных работ всего
                                <span class="fs-24 text-grey fw-600">${roles_works[0]}</span>
                            </div>
                            @{{if findRole(roles_works,'admin')}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Администраторы:</p>
                                <p class="text-grey fs-14 mb-2">
                                    ${roles_works[getRoleIndex()].works_count}
                                </p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Администраторы:</p>
                                <p class="text-grey fs-14 mb-2">
                                    0
                                </p>
                            </div>

                            @{{/if}}
                            @{{if findRole(roles_works,'teacher')}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Преподаватели:</p>
                                <p class="text-grey fs-14 mb-2">
                                    ${roles_works[getRoleIndex()].works_count}
                                </p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Преподаватели:</p>
                                <p class="text-grey fs-14 mb-2">
                                    0
                                </p>
                            </div>
                            @{{/if}}
                            @{{if findRole(roles_works,'employee')}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудники организации:</p>
                                <p class="text-grey fs-14 mb-2">
                                    ${roles_works[getRoleIndex()].works_count}
                                </p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудники организации:</p>
                                <p class="text-grey fs-14 mb-2">
                                    0
                                </p>
                            </div>
                            @{{/if}}

                            @{{if findRole(roles_works,'user')}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-3 mt-1">Обучающимися</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Одобрено:</p>
                                <p class="text-grey fs-14 mb-2">${roles_works[getRoleIndex()].work_approved}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Отправлено на доработку:</p>
                                <p class="text-grey fs-14 mb-2">${roles_works[getRoleIndex()].work_denied}</p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Ожидают одобрения:</p>
                                <p class="text-grey fs-14 mb-2">${roles_works[getRoleIndex()].work_wait}</p>
                            </div>
                            @{{else}}
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-3 mt-1">Обучающимися</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Одобрено:</p>
                                <p class="text-grey fs-14 mb-2">0</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Отправлено на доработку:</p>
                                <p class="text-grey fs-14 mb-2">0</p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Ожидают одобрения:</p>
                                <p class="text-grey fs-14 mb-2">0</p>
                            </div>
                            @{{/if}}

                        </div>
                    </div>
                </div>
            </div>


            </script>


@endsection






