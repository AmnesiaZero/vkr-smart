@extends('layouts.dashboard.admin')

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
            <script src="/js/dashboard/admin/reports.js"></script>

            <script id="report_tmpl" type="text/x-jquery-tmpl">
         <div class="col">

                <div class="row g-4">
                    <div class="col-xl-6">
                        <div class="br-green-light-2 p-3 br-20">
                            <div class="text-grey fw-600 fs-16 d-flex align-items-center gap-3 mb-3">
                                <img src="/images/Users_Group-l.svg">
                                Пользователей всего
                                <span class="fs-24 text-grey fw-600">
                                    ${users.length}
                                </span>
                            </div>

                            @{{each roles_users}}
                              <div class="d-flex justify-content-between">
                                <p class="text-grey fs-14 mb-2">${getRoleName(role_id)}</p>
                                <p class="text-grey fs-14 mb-2">
{{--                                @{{if roles_users[0]}}--}}
                {{--                                    ${roles_users[0].users.length}--}}
                {{--                                 @{{else}}--}}
                {{--                                   0--}}
                {{--                                @{{/if}}--}}

                ${users.length}
               </p>
           </div>
           @{{/each}}


{{--                            <div class="d-flex justify-content-between">--}}
                {{--                                <p class="text-grey fs-14 mb-2">Студентов</p>--}}
                {{--                                <p class="text-grey fs-14 mb-2">--}}
                {{--                                @{{if roles_users[1]}}--}}
                {{--                                    ${roles_users[1].users.length}--}}
                {{--                                 @{{else}}--}}
                {{--                                   0--}}
                {{--                                @{{/if}}--}}
                {{--                                </p>--}}
                {{--                            </div>--}}
                {{--                            <div class="d-flex justify-content-between">--}}
                {{--                                <p class="text-grey fs-14 mb-2">Сотрудников организации</p>--}}
                {{--                                <p class="text-grey fs-14 mb-2">--}}
                {{--                                @{{if roles_users[3]}}--}}
                {{--                                    ${roles_users[3].users.length}--}}
                {{--                                 @{{else}}--}}
                {{--                                   0--}}
                {{--                                @{{/if}}--}}
                {{--                                </p>--}}
                {{--                            </div>--}}
                {{--                            <div class="d-flex justify-content-between">--}}
                {{--                                <p class="text-grey fs-14 mb-2">Преподавателей</p>--}}
                {{--                                <p class="text-grey fs-14 mb-2">--}}
                {{--                                @{{if roles_users[6]}}--}}
                {{--                                    ${roles_users[6].users.length}--}}
                {{--                                 @{{else}}--}}
                {{--                                   0--}}
                {{--                                @{{/if}}--}}
                {{--                                </p>--}}
                {{--                            </div>--}}


                </div>
                <div class="br-green-light-2 p-3 br-20 mt-4">
                    <div class="text-grey fs-16 fw-600 d-flex align-items-center gap-3 mb-3">
                        <img src="/images/User_Card_ID-l.svg">
                        Портфолио всего
                        <span class="fs-24 text-grey fw-600">${users.length}</span>
                    </div>
{{--                             <div class="d-flex justify-content-between brt-green-light-2 mt-4">--}}
                {{--                                <p class="text-grey fs-14 mb-3 mt-1">${name}</p>--}}
                {{--                            </div>--}}
                {{--                            <div class="d-flex justify-content-between">--}}
                {{--                                <p class="text-grey fs-14 mb-2">Записи достижений:</p>--}}
                {{--                                <p class="text-grey fs-14 mb-2">--}}
                {{--                                 @{{if roles_users}}--}}
                {{--                                    ${getAchievementsCount(roles_users)}--}}
                {{--                                 @{{else}}--}}
                {{--                                    0--}}
                {{--                                 @{{/if}}--}}
                {{--                                </p>--}}
                {{--                            </div>--}}
                {{--                            <div class="d-flex justify-content-between brb-green-light-2">--}}
                {{--                                <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>--}}
                {{--                                <p class="text-grey fs-14 mb-2">--}}
                {{--                                    @{{if roles_users}}--}}
                {{--                                    ${achievementsRecordsCount(roles_users)}--}}
                {{--                                 @{{else}}--}}
                {{--                                    0--}}
                {{--                                 @{{/if}}--}}

                {{--                                </p>--}}
                {{--                            </div>--}}

                @{{each roles_users}}
                <div class="d-flex justify-content-between brt-green-light-2 mt-3">
                        <p class="text-grey fs-14 mb-3 mt-1">${getRoleName(role_id)}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-grey fs-14 mb-2">Записи достижений:</p>
                        <p class="text-grey fs-14 mb-2">
                           ${getAchievementsCount(users)}
                        </p>
                    </div>
                    <div class="d-flex justify-content-between brb-green-light-2">
                        <p class="text-grey fs-14 mb-2">Прикреплено ресурсов:</p>
                        <p class="text-grey fs-14 mb-2">
                            ${achievementsRecordsCount(users)}

                        </p>
                    </div>
                @{{/each}}

                </div>
            </div>
            <div class="col-xl-6">
                <div class="br-green-light-2 p-3 br-20">

                    <div class="text-grey fs-16 fw-600 d-flex align-items-center gap-3 mb-3">
                        <img src="/images/File_Document.svg">
                        Загруженных работ всего
                        <span class="fs-24 text-grey fw-600">${works.length}</span>
                    </div>
                     @{{each roles_works}}
                        <div class="d-flex justify-content-between">
                        <p class="text-grey fs-14 mb-2">${getRoleName(role_id)}:</p>
                        <p class="text-grey fs-14 mb-2">
{{--                                @{{if roles_works[0]}}--}}
                {{--                                    ${roles_works[0].works.length}--}}
                {{--                                 @{{else}}--}}
                {{--                                   0--}}
                {{--                                @{{/if}}--}}
                ${works.length}
              </p>
             </div>
           @{{/each}}

{{--                            <div class="d-flex justify-content-between">--}}
                {{--                               <p class="text-grey fs-14 mb-2">Администраторами:</p>--}}
                {{--                               <p class="text-grey fs-14 mb-2">--}}
                {{--                               @{{if roles_works[0]}}--}}
                {{--                                   ${roles_works[0].works.length}--}}
                {{--                                @{{else}}--}}
                {{--                                  0--}}
                {{--                               @{{/if}}--}}
                {{--                               </p>--}}
                {{--                           </div>--}}
                {{--                            <div class="d-flex justify-content-between">--}}
                {{--                               <p class="text-grey fs-14 mb-2">Сотрудниками организации:</p>--}}
                {{--                               <p class="text-grey fs-14 mb-2">--}}
                {{--                               @{{if roles_works[2]}}--}}
                {{--                                   ${roles_works[2].works.length}--}}
                {{--                                @{{else}}--}}
                {{--                                  0--}}
                {{--                               @{{/if}}--}}
                {{--                               </p>--}}
                {{--                           </div>--}}
                {{--                           <div class="d-flex justify-content-between">--}}
                {{--                               <p class="text-grey fs-14 mb-2">Преподавателями:</p>--}}
                {{--                               <p class="text-grey fs-14 mb-2">--}}
                {{--                               @{{if roles_works[6]}}--}}
                {{--                                   ${roles_works[6].works.length}--}}
                {{--                                @{{else}}--}}
                {{--                                  0--}}
                {{--                               @{{/if}}--}}
                {{--                               </p>--}}
                {{--                           </div>--}}
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






