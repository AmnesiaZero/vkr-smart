@extends('layouts.dashboard.main')

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row px-5 pt-5 g-3">

        </div>
        <div class="row">
            <form class="row"
                  @if(!isset($organization->secret_key))
                      onsubmit="generateApiKey();return false"
                  @endif
                  id="generate_key_form">
                <div class="col-xxl-5 col-xl-6 col-lg-7 mb-lg-0 mb-md-5 mb-0 p-5 col-12">
                    <p class="fw-600">«Подключение и настройка»</p>
                    <p class="fs-14 text-grey lh-17">Для подключения к сервису Вам необходимы 3 параметра:<br>2
                        специальных
                        ключа и идентификатор клиента, которые вы передадите в отдел разработки ПО вашей организации.
                    </p>
                    <p class="fs-14 text-grey lh-17">Сформировать ключи и получить ID клиента:</p>
                    <div class="mb-3">
                        <label for="id" class="form-label">ID клиента</label>
                        <input type="text" name="id" class="form-control bg-grey-form" id="id" value="{{$organization->id}}"
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label for="X_APIKey" class="form-label">X-APIKey</label>
                        <input type="text" class="form-control bg-grey-form" name="api_key" value="{{$api_key}}"
                               readonly>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">SECRET KEY</label>
                        <div class="password">
                            <input type="text" id="secret_key" class="form-control bg-grey-form"
                                   name="secret_key"
                                   value="{{$organization->secret_key}}" readonly>
                            <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                        </div>
                    </div>
                    <div id="form_submit_container">
                    @if(isset($organization->secret_key))
                        Ранее вы уже выполнили запрос на их получение..
                    @else
                        <button class="btn btn-secondary w-100 mt-3 text-grey">
                            Создать ключ защиты API
                        </button>
                    @endif
                    </div>
                </div>
                <div id="vkr-logo" class="col-xxl-6 col-lg-10 col-12">
                    <div class="br-green-light-2 br-15 p-3 mb-3">
                        <div class="row g-4">
                            <div class="col">
                                <img src="/images/VKR-logo.svg" alt="">
                            </div>
                            <div class="col d-flex flex-column justify-content-between">
                                <p class="fs-16 m-0">
                                    <img src="/images/href.svg" alt="" class="pe-2">
                                    <a href="#" class="text-grey td-none text-grey-hover fw-600">
                                        ВКР-СМАРТ API
                                    </a>
                                </p>
                                <div class="mt-3">
                                    <p class="fs-16 m-0">
                                        <img src="/images/href.svg" alt="" class="pe-2">
                                        <a href="#" class="text-grey td-none text-grey-hover fw-600">
                                            Документация к сервису
                                        </a>
                                    </p>
                                    <p class="text-grey fs-14 mt-2 mb-0">Основной перечень запросов ВКР-СМАРТ API</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/dashboard/settings/api.js"></script>

@endsection
