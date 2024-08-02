@extends('layouts.dashboard.main')
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/achievements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile-card.css') }}">
    <link rel="stylesheet" href="{{asset('/css/bootstrap-select.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">

        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-lg-3 col-xs-3">
                    <div class="profile-sidebar">
                        <div class="profile-userpic d-flex align-items-center justify-content-center" id="avatar_container">
                            <img id="user_avatar" src="{{asset($user->avatar_path)}}" alt=""
                                 class="img-fluid img-responsive" style="border-radius: 6px;">
                        </div>
                        <a href="#" id="change_avatar_button"  class="btn btn-avatar btn-block">
                            <span class="glyphicon glyphicon-camera"></span>
                            Заменить фотографию
                        </a>
                        <input type="file" style="display: none" id="avatar_input">
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name fs-14 fw-bold">
                                {{$user->name}}
                            </div>
                        </div>
                        <div class="profile-usermenu">
                            <ul class="nav d-flex flex-column" role="tablist">
                                <li role="presentation" class="nav-item">
                                    <a href="#profile-base" class="nav-link active" aria-controls="profile-base" role="tab" data-bs-toggle="tab"
                                       aria-expanded="false">
                                        <i class="fas fa-home"></i> Основная информация
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#profile-security" class="nav-link" aria-controls="profile-achivements" role="tab"
                                       data-bs-toggle="tab" aria-expanded="false">
                                        <i class="fas fa-th"></i>
                                        Безопасность
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#profile-main" class="nav-link" aria-controls="profile-main" role="tab" data-bs-toggle="tab"
                                       aria-expanded="false">
                                        <i class="fas fa-graduation-cap"></i> Образование
                                    </a>
                                </li>
                                <li role="presentation" class="nav-item">
                                    <a href="#profile-career" class="nav-link" aria-controls="profile-career" role="tab" data-bs-toggle="tab"
                                       aria-expanded="true">
                                        <i class="fas fa-briefcase"></i> Карьера
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <hr class="hr-sm">
                    </div>
                </div>
                <div class="col-sm-9 col-lg-9 col-xs-9">
                    <div class="tab-content profile-content">
                        <div role="tabpanel" class="tab-pane active" id="profile-base">
                            <form id="personal_form" class="form form-horizontal" action="staff-personal-info.html" method="post" onsubmit="updatePersonalInfo(); return false;">
                                <h2>Основная информация:</h2><hr>
                                <div id="about_content">
                                <div class="form-group">
                                    <label class="col-sm-4">Фамилия, имя, отчество</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="name" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Доступность ФИО на странице информации</label>
                                    <div class="col-sm-8">
                                        <select class="form-control selectpicker bs-select-hidden" name="name_visibility">
                                            <option value="0" selected="">Отображение ФИО отключено</option>
                                            <option value="1">Фамилия, имя, отчество доступны на странице</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Адрес электронной почты</label>
                                    <div class="col-sm-8">
                                        {{$user->email}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Доступность email-адреса на странице информации</label>
                                    <div class="col-sm-8">
                                        <select class="form-control selectpicker bs-select-hidden" name="email_visibility">
                                            <option value="0" @if($user->email_visibility==0) selected @endif>Отображение адреса отключено</option>
                                            <option value="1"  @if($user->email_visibility==1) selected @endif>Email виден на странице</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Организация</label>
                                    <div class="col-sm-8">
                                        {{$user->organization->name}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Роль</label>
                                    <div class="col-sm-8">
                                        {{$user->roles[0]->name}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4">Доступ к карточке портфолио</label>
                                    <div class="col-sm-8">
                                        <select class="form-control selectpicker bs-select-hidden" name="portfolio_card_access">
                                            <option value="0" @if($user->portfolio_card_access==0) selected @endif>Доступ к карточке закрыт</option>
                                            <option value="1" @if($user->portfolio_card_access==1) selected @endif>Доступ к карточке открыт</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4"></label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-success" type="submit">Обновить информацию</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label col-sm-4"></label>
                                    <div class="col-sm-8">
                                        <div id="personal-alert"></div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile-security">
                            <h2>Смена пароля:</h2><hr>
                            <form id="reset_password_form" onsubmit="resetPassword();return false" class="form form-horizontal" action="staff-personal-info.html" method="post">
                                <div class="form-group">
                                    <label for="password" class="form-label col-sm-4">Новый пароль:</label>
                                    <div class="col-sm-8">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="Не менее 8 символов..." required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="repassword" class="form-label col-sm-4">Повторите пароль:</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Во избежание ошибок" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label col-sm-4"></label>
                                    <div class="col-sm-8">
                                        <button class="btn btn-success" onclick="changePassword(); return false;"><span class="glyphicon glyphicon-refresh"></span> Изменить пароль
                                        </button></div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label col-sm-4"></label>
                                    <div class="col-sm-8">
                                        <div id="password-alert"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile-main">
                            <h2>Образование:</h2>
                            <div id="educations_list">

                            </div>

                            <form class="form form-horizontal form-well" id="add_education_form"
                                  onsubmit="addEducation(); return false;">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4">Наименование организации</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4">Год начала обучения</label>
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
                                        <label class="col-sm-4">Год окончания обучения</label>
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
                                        <label class="col-sm-4">Год выпуска</label>
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
                                        <label class="col-sm-4">Форма обучения</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker form-control bs-select-hidden" name="education_form">
                                                <option value="0">Очная</option>
                                                <option value="1">Заочная</option>
                                                <option value="2">Дистанционное образование</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-resume-add">
                                    <span class="fas fa-plus"></span> Добавить место обучения
                                </button>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile-career">
                            <h2>Профессиональная деятельность:</h2>
                            <div id="careers_list">

                            </div>

                            <form class="form form-horizontal form-well" id="add_career_form" onsubmit="addCareer(); return false;"
                                  method="post">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4">Место работы</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="name" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4">Год начала работы</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker form-control bs-select-hidden" name="start_year">
                                                @include('layouts.dashboard.include.elements.years_list')
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4">Год окончания</label>
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
                                        <label class="col-sm-4">Должность</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="post" required="">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-resume-add">
                                    <span class="fas fa-plus"></span>Добавить место работы</button>
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
    </div>
@endsection


@section('scripts')
    <script src="{{'/js/dashboard/portfolios/card.js'}}"></script>
    <script src="{{'/js/dashboard//personal-cabinet.js'}}"></script>


    <script id="about_tmpl" type="text/x-jquery-tmpl">
          <div class="form-group">
        <label class="col-sm-4">Фамилия, имя, отчество</label>
        <div class="col-sm-8">
            <input class="form-control" name="name" value="${name}">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Доступность ФИО на странице информации</label>
        <div class="col-sm-8">
            <select class="form-control selectpicker bs-select-hidden" name="name_visibility">
                <option value="0" @{{if name_visibility==0}} selected @{{/if}}>Отображение ФИО отключено</option>
                <option value="1" @{{if name_visibility==1}} selected @{{/if}}>Фамилия, имя, отчество доступны на странице</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Адрес электронной почты</label>
        <div class="col-sm-8">
            ${email}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Доступность email-адреса на странице информации</label>
        <div class="col-sm-8">
            <select class="form-control selectpicker bs-select-hidden" name="email_visibility">
                <option value="0" @{{if email_visibility==0}} selected @{{/if}}>Отображение адреса отключено</option>
                <option value="1"  @{{if email_visibility==0}} selected @{{/if}}>Email виден на странице</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Организация</label>
        <div class="col-sm-8">
            ${organization.name}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Роль</label>
        <div class="col-sm-8">
            ${roles[0].name}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-4">Доступ к карточке портфолио</label>
        <div class="col-sm-8">
            <select class="form-control selectpicker bs-select-hidden" name="portfolio_card_access">
                <option value="0" @{{if portfolio_card_access==0}} selected @{{/if}}>Доступ к карточке закрыт</option>
                <option value="1" @{{if portfolio_card_access==1}} selected @{{/if}}>Доступ к карточке открыт</option>
            </select>
        </div>
    </div>

    </script>

    <script id="education_tmpl" type="text/x-jquery-tmpl">
        <form class="form-horizontal row-life" id="education_${id}">
        <span class="close-life">
        <span onclick="deleteEducation(${id}); return false;" class="bi bi-x"></span> </span>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Наименование организации</label>
                    <div class="col-sm-8 col-xs-8">${name}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Год начала обучения</label>
                    <div class="col-sm-8 col-xs-8">${start_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Год окончания обучения</label>
                    <div class="col-sm-8 col-xs-8">${end_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Год выпуска</label>
                    <div class="col-sm-8 col-xs-8">${graduation_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Форма обучения</label>
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
                    <label class="col-sm-4 col-xs-4">Место работы</label>
                    <div class="col-sm-8 col-xs-8">${name}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Год начала работы</label>
                    <div class="col-sm-8 col-xs-8">${start_year}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4 col-xs-4">Год окончания</label>
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
                    <label class="col-sm-4 col-xs-4">Должность</label>
                    <div class="col-sm-8 col-xs-8">${post}</div>
                </div>
            </div>
        </form>
    </script>

    <script id="avatar_tmpl" type="text/x-jquery-tmpl">
       <img id="user_avatar" src="${avatar_path}" alt="" class="img-responsive" style="border-radius: 6px;">
    </script>
@endsection
