@extends('layouts.dashboard.main')

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12 mb-4">
        <div class="row pt-4 g-3 px-md-0 px-3 mb-5">
            <div class="col-xxl-4 col-xl-5 col-lg-6">
               @include('layouts.dashboard.include.elements.tree',['years' => $years])
                <button class="btn btn-secondary br-none br-100 text-grey fs-14 w-100 mt-3 py-1 mt-3" onclick="getReport();return false">за все время</button>
            </div>
            <div class="out-kod mb-3"></div>
            <div id="report_container">

            </div>

        </div>

        @endsection

@section('scripts')
    <script src="/js/dashboard/reports.js"></script>

    <script id="report_tmpl" type="text/x-jquery-tmpl">
         <div class="col">

                <div class="row g-4">
                    <div class="col-xl-6">
                        <div class="br-green-light-2 p-3 br-20">
                            <img src="/images/Users_Group-l.svg">
                            <p class="text-grey fs-14">Пользователей <span class="ps-4 fs-32 fw-700">
                                      ${users.length}
                         </span>
                            </p>

                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудников</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_users[0]}}
                                   @{{if roles_users[0].users}}
                                    ${roles_users[0].users.length}
                                    @{{/if}}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудников</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_users[1]}}
                                    @{{if roles_users[0].users}}
                                    ${roles_users[1].users.length}
                                    @{{/if}}

                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудников</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_users[2].users}}
                                    ${roles_users[2].users.length}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудников</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_users[3].users}}
                                    ${roles_users[3].users.length}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудников</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_users[4].users}}
                                    ${roles_users[4].users.length}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудников</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_users[5].users}}
                                    ${roles_users[5].users.length}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>


                        </div>
{{--                        <div class="br-green-light-2 p-3 br-20 mt-4">--}}
{{--                            <img src="/images/User_Card_ID-l.svg">--}}
{{--                            <p class="text-grey fs-14">Портфолио <span class="ps-4 fs-32 fw-700">${users.length}</span></p>--}}
{{--                            @{{each roles_users}}--}}
{{--                              @{{if slug!='employee' && slug!='admin'}}--}}
{{--                              <div class="d-flex justify-content-between brt-green-light-2 mt-4">--}}
{{--                                <p class="text-grey fs-14 mb-3 mt-1">${name}</p>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex justify-content-between">--}}
{{--                                <p class="text-grey fs-14 mb-2">Записи достижений:</p>--}}
{{--                                <p class="text-grey fs-14 mb-2">--}}
{{--                                 @{{if users}}--}}
{{--                                    ${getAchievementsCount(users)}--}}
{{--                                 @{{else}}--}}
{{--                                    0--}}
{{--                                 @{{/if}}--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                            <div class="d-flex justify-content-between brb-green-light-2">--}}
{{--                                <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>--}}
{{--                                <p class="text-grey fs-14 mb-2">--}}
{{--                                    @{{if users}}--}}
{{--                                    ${achievementsRecordsCount(users)}--}}
{{--                                 @{{else}}--}}
{{--                                    0--}}
{{--                                 @{{/if}}--}}

{{--                                </p>--}}
{{--                            </div>--}}
{{--                            @{{/if}}--}}
{{--                            @{{/each}}--}}


{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-xl-6">
                        <div class="br-green-light-2 p-3 br-20">
                            <img src="/images/File_Document.svg">

                            <p class="text-grey fs-14">Загруженных работ <span class="ps-4 fs-32 fw-700">${works.length}</span></p>
                             <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Сотрудниками:</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_works[0].works}}
                                    ${roles_users[0].works.length}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Преподавателями:</p>
                                <p class="text-grey fs-14 mb-2">
                                @{{if roles_works[1].works}}
                                    ${roles_users[1].works.length}
                                 @{{else}}
                                   0
                                @{{/if}}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-3 mt-1">Обучающимися</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Одобрено:</p>
                                <p class="text-grey fs-14 mb-2">2</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">Отправлено на доработку:</p>
                                <p class="text-grey fs-14 mb-2">1</p>
                            </div>
                            <div class="d-flex justify-content-between brb-green-light-2">
                                <p class="text-grey fs-14 mb-2">Ожидают одобрения:</p>
                                <p class="text-grey fs-14 mb-2">1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


  </script>





@endsection






