@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/achievements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-card.css') }}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-select.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('content')
    <div id="user-data" data-uid="1573"></div>
    <div class="container-filter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-lg-3 col-xs-3">
                    <a href="http://www.vkr-vuz.ru/">
                        <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="ВКР-ВУЗ">
                    </a>
                </div>
                <div class="col-sm-9 col-lg-9 col-xs-9">
                    <p class="logotype-subtext">
                        «Портфолио достижений»
                        <span class="sub-text">Основная информация о достижениях, образовании и карьере</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-lg-3 col-xs-3">
                <div class="profile-sidebar">
                    <div class="profile-userpic d-flex align-items-center justify-content-center">
                        <img id="user-avatar" src="{{ asset('images/default.png') }}" alt=""
                             class="img-responsive" style="border-radius: 6px;">
                    </div>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name fs-14 fw-bold text-grey">
                            {{$user->name}}
                        </div>
                    </div>
                    <div class="profile-usermenu">
                        <ul class="nav d-flex flex-column" role="tablist">
                            <li role="presentation" class="nav-item">
                                <a href="#profile-base" class="nav-link text-grey  active" aria-controls="profile-base" role="tab" data-bs-toggle="tab"
                                   aria-expanded="false">
                                    <i class="fas fa-home"></i> Основная информация
                                </a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a href="#profile-achivements" class="nav-link text-grey " aria-controls="profile-achivements" role="tab"
                                   data-bs-toggle="tab" aria-expanded="false">
                                    <i class="fas fa-th"></i> Достижения
                                </a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a href="#profile-main" class="nav-link text-grey " aria-controls="profile-main" role="tab" data-bs-toggle="tab"
                                   aria-expanded="false">
                                    <i class="fas fa-graduation-cap"></i> Образование
                                </a>
                            </li>
                            <li role="presentation" class="nav-item">
                                <a href="#profile-career" class="nav-link text-grey " aria-controls="profile-career" role="tab" data-bs-toggle="tab"
                                   aria-expanded="true">
                                    <i class="fas fa-briefcase"></i> Карьера
                                </a>
                            </li>
                        </ul>
                    </div>
                    <hr class="hr-sm">
                    <a onclick="window.print(); return false;" class="btn btn-block btn-primary btn-print text-grey br-none" id="print-it-out-btn">
                        <i class="fas fa-print" style="padding-right: 4px"></i> Распечатать
                    </a>
                </div>
            </div>
            <div class="col-sm-9 col-lg-9 col-xs-9">
                <div class="tab-content profile-content">
                    <div role="tabpanel" class="tab-pane active" id="profile-base">
                        <form class="form form-horizontal" method="post">
                            <h2 class="text-grey">Основная информация:</h2>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14 text-grey">Фамилия, имя, отчество</label>
                                    <div class="col-sm-8 col-xs-8 fs-14 fw-500">
                                        @if(isset($user->name))
                                            {{$user->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14 text-grey">Адрес электронной почты</label>
                                    <div class="col-sm-8 col-xs-8 fs-14 fw-500">
                                        @if(isset($user->email))
                                            {{$user->email}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14 text-grey">Организация</label>
                                    <div class="col-sm-8 col-xs-8 fs-14 fw-500">
                                        @if(isset($user->organization->name))
                                            {{$user->organization->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14 text-grey">Факультет (подразделение)</label>
                                    <div class="col-sm-8 col-xs-8 fs-14 fw-500">
                                        @if(isset($user->faculty->name))
                                            {{$user->faculty->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14 text-grey">Кафедра</label>
                                    <div class="col-sm-8 col-xs-8 fs-14 fw-500">
                                        @if(isset($user->department->name))
                                            {{$user->department->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14 text-grey">Позиция в организации</label>
                                    <div class="col-sm-8 col-xs-8 fs-14 fw-500">
                                        @if(isset($user->roles[0]->name))
                                            {{$user->roles[0]->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile-achivements">
                        <h2 class="text-grey">Портфолио достижений:</h2>
                        <table class="table table-bordered table-mini">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="fw-500">Достижение</th>
                                <th>Вид деятельности</th>
                                <th>Дата достижения</th>
                            </tr>
                            </thead>
                            <tbody id="my-achivements">
                            @if(isset($user->achievements) and is_iterable($user->achievements))
                                @foreach($user->achievements as $achievement)
                                    @include('layouts.dashboard.include.elements.portfolio.achievement',['achievement' =>
                                    $achievement,'loop' => $loop])
                                @endforeach
                            @endif
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile-main">
                        <h2 class="text-grey">Образование:</h2>
                        <div id="educations_list">

                        </div>

                        <form class="form form-horizontal form-well" id="add_education_form"
                              onsubmit="addEducation(); return false;">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Наименование организации</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Год начала обучения</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" data-live-search="true"
                                                name="start_year">
                                            @include('layouts.dashboard.include.elements.years_list')
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Год окончания обучения</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" data-live-search="true"
                                                name="end_year">
                                            @include('layouts.dashboard.include.elements.years_list')
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Год выпуска</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" data-live-search="true"
                                                name="graduation_year">
                                            @include('layouts.dashboard.include.elements.years_list')
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Форма обучения</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" name="education_form">
                                            <option value="0">Очная</option>
                                            <option value="1">Заочная</option>
                                            <option value="2">Дистанционное образование</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary br-none text-grey w-100 fs-16 py-2">
                                <img src="/images/Plus.svg" class="ps-3" alt="" style="padding-right: 4px;">
                                Добавить место обучения
                            </button>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile-career">
                        <h2 class="text-grey">Профессиональная деятельность:</h2>
                        <div id="careers_list">

                        </div>

                        <form class="form form-horizontal form-well" id="add_career_form" onsubmit="addCareer(); return false;"
                              method="post">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Место работы</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="name" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Год начала работы</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" name="start_year">
                                            @include('layouts.dashboard.include.elements.years_list')
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Год окончания</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" name="end_year">
                                            <option value="0">Продолжаю работать...</option>
                                            @include('layouts.dashboard.include.elements.years_list')
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 text-grey fw-bold">Должность</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="post" required="">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary br-none text-grey w-100 fs-16 py-2 br-none">
                                <img src="/images/Plus.svg" class="ps-3" alt="" style="padding-right: 4px;">
                                Добавить место обучения
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="informationModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h3>Описание ресурса</h3>
                </div>
                <div class="modal-body">
                    <div id="informationModalData"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Закрыть
                        окно</button>
                </div>
            </div>
        </div>
    </div>
    <div id="resoursesModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h3>Обзор ресурсов достижения</h3>
                </div>
                <div class="modal-body">
                    <div id="resoursesModalData"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Закрыть
                        окно</button>
                </div>
            </div>
        </div>
    </div>
    <form id="downloadFileForm" class="hide" method="post" action="/achivements-actions">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="action" value="getFile">
    </form>



@endsection


@section('scripts')
    <script src="{{'/js/dashboard/portfolios/card.js'}}"></script>
    <script id="achievement_tmpl" type="text/x-jquery-tmpl">
        <tr id="achievement_${id}">
            <td>
                <strong></strong>
            </td>
            <td>      ${name}
                <span class="desc">${description}</span>
                <span class="desc">       Подтверждающих документов: ${records.length}
                <a href="#" class="get-resourses-link" onclick="getResourses(10608); return false;">Обзор</a>
                <div id="resourses-10608" class="resourses-block"></div>
            </span>
            </td>
            <td>${type.name}</td>
            <td>${record_date}</td>
        </tr>
    </script>

    <script id="education_tmpl" type="text/x-jquery-tmpl">
        <form class="form-horizontal row-life" id="education_${id}">
        <span class="close-life">
        <span onclick="deleteEducation(${id}); return false;" class="bi bi-x"></span> </span>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Наименование организации</label>
                    <div class="col-sm-8 col-xs-8 text-black">${name}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Год начала обучения</label>
                    <div class="col-sm-8 col-xs-8">${start_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Год окончания обучения</label>
                    <div class="col-sm-8 col-xs-8">${end_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Год выпуска</label>
                    <div class="col-sm-8 col-xs-8">${graduation_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Форма обучения</label>
                    <div class="col-sm-8 col-xs-8">${getEducationForm(education_form)}</div>
                </div>
            </div>
        </form>
    </script>

    <script id="career_tmpl" type="text/x-jquery-tmpl">
        <form class="form-horizontal row-life" id="career_${id}">
                            <span class="close-life">
                                <span onclick="deleteCareer(${id}); return false;" class="bi bi-x"></span>
                            </span>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Место работы</label>
                    <div class="col-sm-8 col-xs-8">${name}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Год начала работы</label>
                    <div class="col-sm-8 col-xs-8">${start_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Год окончания</label>
                    <div class="col-sm-8 col-xs-8">
                    @{{if end_year==0}}
                      Продолжаю работать
                    @{{else}}
                    ${end_year}
                    @{{/if}}
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4 text-grey fw-bold">Должность</label>
                    <div class="col-sm-8 col-xs-8">${post}</div>
                </div>
            </div>
        </form>
    </script>
@endsection
