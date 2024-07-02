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
                                <a href="#profile-achivements" class="nav-link" aria-controls="profile-achivements" role="tab"
                                   data-bs-toggle="tab" aria-expanded="false">
                                    <i class="fas fa-th"></i> Достижения
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
                    <a onclick="window.print(); return false;" class="btn btn-block btn-primary btn-print" id="print-it-out-btn">
                        <i class="fas fa-print"></i> Распечатать
                    </a>
                </div>
            </div>
            <div class="col-sm-9 col-lg-9 col-xs-9">
                <div class="tab-content profile-content">
                    <div role="tabpanel" class="tab-pane active" id="profile-base">
                        <form class="form form-horizontal" action="staff-personal-info.html" method="post">
                            <h2>Основная информация:</h2>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14">Фамилия, имя, отчество</label>
                                    <div class="col-sm-8 col-xs-8 fs-14">
                                        @if(isset($user->name))
                                            {{$user->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14">Адрес электронной почты</label>
                                    <div class="col-sm-8 col-xs-8 fs-14">
                                        @if(isset($user->email))
                                            {{$user->email}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14">Организация</label>
                                    <div class="col-sm-8 col-xs-8 fs-14">
                                        @if(isset($user->organization->name))
                                            {{$user->organization->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14">Факультет (подразделение)</label>
                                    <div class="col-sm-8 col-xs-8 fs-14">
                                        @if(isset($user->faculty->name))
                                            {{$user->faculty->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14">Кафедра</label>
                                    <div class="col-sm-8 col-xs-8 fs-14">
                                        @if(isset($user->department->name))
                                            {{$user->department->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 col-xs-4 fw-bold fs-14">Позиция в организации</label>
                                    <div class="col-sm-8 col-xs-8 fs-14">
                                        @if(isset($user->roles[0]->name))
                                            {{$user->roles[0]->name}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile-achivements">
                        <h2>Портфолио достижений:</h2>
                        <table class="table table-bordered table-mini">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Достижение</th>
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
                        <h2>Образование:</h2>
                        <div id="my-educations">
                            <form class="form-horizontal row-life" id="row-life-131"> <span class="close-life"> <span
                                        onclick="removeLifePlace(131); return false;"
                                        class="glyphicon glyphicon-remove"></span> </span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Наименование организации</label>
                                        <div class="col-sm-8 col-xs-8"> Пошел в школу </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год начала обучения</label>
                                        <div class="col-sm-8 col-xs-8"> 1993 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год окончания обучения</label>
                                        <div class="col-sm-8 col-xs-8"> 2003 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год выпуска</label>
                                        <div class="col-sm-8 col-xs-8"> 2003 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Форма обучения</label>
                                        <div class="col-sm-8 col-xs-8"> Дневная </div>
                                    </div>
                                </div>
                            </form>
                            <form class="form-horizontal row-life" id="row-life-132"> <span class="close-life"> <span
                                        onclick="removeLifePlace(132); return false;"
                                        class="glyphicon glyphicon-remove"></span> </span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Наименование организации</label>
                                        <div class="col-sm-8 col-xs-8"> Пошел в университет </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год начала обучения</label>
                                        <div class="col-sm-8 col-xs-8"> 2003 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год окончания обучения</label>
                                        <div class="col-sm-8 col-xs-8"> 2008 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год выпуска</label>
                                        <div class="col-sm-8 col-xs-8"> 2008 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Форма обучения</label>
                                        <div class="col-sm-8 col-xs-8"> Дневная </div>
                                    </div>
                                </div>
                            </form>
                            <form class="form-horizontal row-life" id="row-life-464"> <span class="close-life"> <span
                                        onclick="removeLifePlace(464); return false;"
                                        class="glyphicon glyphicon-remove"></span> </span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Наименование организации</label>
                                        <div class="col-sm-8 col-xs-8"> Николай (тестирую) </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год начала обучения</label>
                                        <div class="col-sm-8 col-xs-8"> 2017 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год окончания обучения</label>
                                        <div class="col-sm-8 col-xs-8"> 2017 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год выпуска</label>
                                        <div class="col-sm-8 col-xs-8"> 2017 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Форма обучения</label>
                                        <div class="col-sm-8 col-xs-8"> Дневная </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form class="form form-horizontal form-well" id="educationForm"
                              onsubmit="addEducation(); return false;" method="post">
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
                                                name="date_start">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4">Год окончания обучения</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" data-live-search="true"
                                                name="date_end">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4">Год выпуска</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" data-live-search="true"
                                                name="date_issue">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4">Форма обучения</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" name="training_form_id">
                                            <option value="2">Очная</option>
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
                        <div id="my-career">
                            <form class="form-horizontal row-life" id="row-life-133">
                            <span class="close-life">
                                <span onclick="removeLifePlace(133); return false;"
                                      class="glyphicon glyphicon-remove"></span>
                            </span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Место работы</label>
                                        <div class="col-sm-8 col-xs-8">ТБ-Информ</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год начала работы</label>
                                        <div class="col-sm-8 col-xs-8">2009</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год окончания</label>
                                        <div class="col-sm-8 col-xs-8">2010</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Должность</label>
                                        <div class="col-sm-8 col-xs-8">Инженер 1й категории</div>
                                    </div>
                                </div>
                            </form>
                            <form class="form-horizontal row-life" id="row-life-134"> <span class="close-life"> <span
                                        onclick="removeLifePlace(134); return false;"
                                        class="glyphicon glyphicon-remove"></span> </span>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Место работы</label>
                                        <div class="col-sm-8 col-xs-8"> ИП Кузьмичев Н. В. </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год начала работы</label>
                                        <div class="col-sm-8 col-xs-8"> 2010 </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Год окончания</label>
                                        <div class="col-sm-8 col-xs-8"> Продолжаю работать </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-xs-4">Должность</label>
                                        <div class="col-sm-8 col-xs-8"> ИП Кузьмичев Н. В. </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <form class="form form-horizontal form-well" id="careerForm" onsubmit="addCareer(); return false;"
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
                                        <select class="selectpicker form-control bs-select-hidden" name="date_start">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4">Год окончания</label>
                                    <div class="col-sm-8">
                                        <select class="selectpicker form-control bs-select-hidden" name="date_end">
                                            <option value="0">Продолжаю работать...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4">Должность</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="position" required="">
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

    <script type="text/javascript">
        function getResourses(id) {
            $.ajax({
                url: "/achivements-actions",
                type: "post",
                data: "action=getResources&id=" + id + "&v=" + (new Date()).getTime(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        $("#resourses-" + id).html(response.data)
                    } else {
                        $.notify(response.message, "error");
                    }
                }
            });
        }
        function getResource(id) {
            $.ajax({
                url: "/achivements-actions",
                type: "post",
                data: "action=getResource&id=" + id + "&v=" + (new Date()).getTime(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        var data = response.data;
                        if (data.record_type_id == 3) {
                            $("#informationModalData").html(data.content)
                            $("#informationModal").modal("show");
                        }
                        if (data.record_type_id == 2) {
                            window.open(data.content, "_blank");
                        }
                        if (data.record_type_id == 1) {
                            $("#downloadFileForm input[name='id']").val(id);
                            $("#downloadFileForm").submit();
                        }
                    } else {
                        $.notify(response.message, "error");
                    }
                }
            });
        }
    </script>

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

@endsection


@section('scripts')
    <script src="{{'/js/dashboard/portfolios/card.js'}}"></script>
@endsection
