@extends('layouts.dashboard.admin')

@section('styles')
    <link rel="stylesheet" href="{{'/css/achievements.css'}}">
    <link rel="stylesheet" href="{{'/css/profile.css'}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            <div class="col">
                <div class="out-kod"></div>
                <form action="" class="pt-4 col-xxl-4 col-xl-5 col-md-8" id="search_achievements_form"
                      onsubmit="searchAchievements();return false">
                    <p class="text-grey mb-2 fs-14">Наименование достижения</p>
                    <div class="input-group input-group-lg br-100 br-green-light-2 focus-form mb-3">
                        <input type="text" name="name" value="" class="form-control search br-none fs-14 form-small-p"
                               placeholder="Поиск" id="achievement_name">
                        <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                            <img src="/images/Search.svg" alt="search">
                        </button>
                    </div>
                    <p class="text-grey mb-2 fs-14">Тип документа</p>
                    <div>
                        <div class="col-sm-8">
                            <select name="achievement_mode_id" class="selectpicker bs-select-hidden">
                                <option value="" id="default_achievement">Выбрать</option>
                                @if(isset($modes) and is_iterable($modes))
                                    @foreach($modes as $mode)
                                        <option value="{{$mode->id}}">{{$mode->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mt-auto d-flex gap-3">
                        <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1">Применить</button>
                        <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1"
                                onclick="resetSearch();return false">Сбросить
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex gap-3 mt-5">
            <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 w-75"
                    data-bs-target="#add_achievement_modal" data-bs-toggle="modal">
                Добавить
                <img src="/images/Plus.svg" class="ps-2" alt="">
            </button>
            <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 w-25"
                    onclick="openOverView()"
            >
                Обзор
                <img src="/images/File_Download_green.svg" alt="" class="ps-2">
            </button>
            <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 w-25" onclick="openPortfolio()">Карточка<img
                    src="/images/File_Download_green.svg" alt="" class="ps-2"></button>
        </div>
        <div class="pt-5 px-md-0 px-3">
            <div class="big-table">
                <table class="table table-mini table-striped fs-14">
                    <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                    <tr class="text-grey">
                        <th scope="col">Номер</th>
                        <th scope="col">Наименование/Описание</th>
                        <th scope="col">Тип деятельности</th>
                        <th scope="col">Дата достижения</th>
                        <th scope="col">Управление</th>
                    </tr>
                    </thead>
                    <tbody class="lh-17 brb-green-light-2" id="achievements_list">
                    </tbody>
                </table>
                <div id="tmpl_container">

                </div>
            </div>
        </div>
    </div>
    @include('layouts.dashboard.include.modal.add.portfolio.achievement')
    @include('layouts.dashboard.include.modal.add.portfolio.link')
    @include('layouts.dashboard.include.modal.add.portfolio.file')
    @include('layouts.dashboard.include.modal.add.portfolio.text')
    @include('layouts.dashboard.include.modal.add.portfolio.work')
@endsection

@section('scripts')
    <script src="/js/dashboard/portfolios/achievement.js"></script>
    <script id="achievement_tmpl" type="text/x-jquery-tmpl">
        <tr id="achievement_${id}">
           <td>
              ${index}
          </td>
          <td>
              ${name}
              <br>
              ${description}
          </td>
          <td>
              ${mode.name}
          </td>
          <td>
              ${record_date}
          </td>
          <td>
            <img src="/images/three_dots.svg" alt="" aria-haspopup="true" data-bs-toggle="dropdown" class="btn-info-box cursor-p" onclick="openInfoBox(${id})">
            @include('layouts.dashboard.include.menu.achievement')
          </td>
         </tr>
         <tr>
           <td class="nopadding" colspan="5">
             <table class="table table-condensed table-bordered">
                 <thead>
                     <tr>
                         <th>Отзыв</th>
                         <th>Подтверждение достижения</th>
                         <th>Работа</th>
                         <th>Другое</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr style="flex:row">
                       <td id="reviews_column_${id}"> </td>
                       <td id="confirm_achievements_column_${id}"> </td>
                       <td id="works_column_${id}"> </td>
                       <td id="others_column_${id}"> </td>
                     </tr>
                 </tbody>

           </td>
         </tr>

    </script>

    <script id="update_achievement_modal_tmpl" type="text/x-jquery-tmpl">
        <div id="update_achievement_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" onclick="closeTmplModal('update_achievement_modal')">×</span></button>
                    <h3>Изменить достижение</h3>
                </div>
                <div class="modal-body">
                    <form id="update_achievement_form" onsubmit="updateAchievement(); return false;" class="form-inline">
                        <div class="form-group">
                            <label class="col-sm-4">Введите наименование достижения</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" value="${name}" class="form-control fullwidth" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Выберите тип деятельности:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="achievement_mode_id">
                                    <option value="3" @{{if achievement_mode_id==3}} selected @{{/if}}>Научная деятельность</option>
                                    <option value="2" @{{if achievement_mode_id==2}} selected @{{/if}}>Производственная деятельность</option>
                                    <option value="5" @{{if achievement_mode_id==5}} selected @{{/if}}>Социальная деятельность</option>
                                    <option value="6" @{{if achievement_mode_id==6}} selected @{{/if}}>Спортивная деятельность</option>
                                    <option value="4" @{{if achievement_mode_id==4}} selected @{{/if}}>Творческая деятельность</option>
                                    <option value="1" @{{if achievement_mode_id==1}} selected @{{/if}}>Учебная деятельность</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Уточните уровень образования:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="educational_level">
                                    <option value="1" @{{if educational_level==1}} selected @{{/if}>Дошкольное образование</option>
                                    <option value="2" @{{if educational_level==2}} selected @{{/if}>Начальное общее образование</option>
                                    <option value="3" @{{if educational_level==3}} selected @{{/if}>Основное общее образование</option>
                                    <option value="4" @{{if educational_level==4}} selected @{{/if}>Среднее общее образование</option>
                                    <option value="5" @{{if educational_level==5}} selected @{{/if}>Среднее профессиональное образование</option>
                                    <option value="6" @{{if educational_level==6}} selected @{{/if}>Высшее образование - бакалавриат</option>
                                    <option value="7" @{{if educational_level==7}} selected @{{/if}>Высшее образование - специалитет, магистратура</option>
                                    <option value="8" @{{if educational_level==8}} selected @{{/if}>Высшее образование - подготовка кадров высшей квалификации</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Введите описание</label>
                            <div class="col-sm-8">
                                <textarea rows="8" name="description" class="form-control fullwidth">${description}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Укажите дату достижения</label>
                            <div class="col-sm-8">
                                <input type="date" name="record_date" value="${record_date}" class="form-control datepick" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Кому доступно достижение:</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="access_level">
                                    <option value="1" @{{if access_level==1}} selected @{{/if}>Всем</option>
                                    <option value="2" @{{if access_level==2}} selected @{{/if}>Только сотрудникам организации</option>
                                    <option value="3" @{{if access_level==3}} selected @{{/if}>Только мне</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success" onclick="closeTmplModal('update_achievement_modal')">Добавить достижение</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="closeTmplModal('update_achievement_modal')">Закрыть окно</button>
                </div>
            </div>
        </div>
    </div>





    </script>

    <script id="record_tmpl" type="text/x-jquery-tmpl">
        <div class="dropdown" id="achievement_record_${id}">

          <a data-bs-toggle="dropdown" aria-expanded="false" class="list-group-item d-flex align-items-center gap-2"
          data-bs-toggle="tooltip" title="${type.name}">
              @{{if record_type_id==1}}
                  <i class="bi bi-save"></i>
                  Файл
              @{{/if}}

              @{{if record_type_id==2}}
                  <i class="bi bi-link-45deg"></i>
                  Ссылка
              @{{/if}}

              @{{if record_type_id==3}}
                  <i class="bi bi-eye" onclick="openTextRecord(${id})"></i>
                  Текст
              @{{/if}}
          </a>

          <ul class="dropdown-menu">
              <li>
                  @{{if record_type_id==1}}
                      <a href="/dashboard/portfolio/achievements/records/download?id=${id}"  class="text-decoration-none text-grey">
                          <span class="d-flex align-items-center gap-2">
                              <i class="bi bi-pencil"></i>
                              Открыть
                          </span>
                      </a>
                  @{{/if}}

                  @{{if record_type_id==2}}
                      <a href="${content}" target="_blank"   class="text-decoration-none text-grey">
                          <span class="d-flex align-items-center gap-2">
                              <i class="bi bi-pencil"></i>
                              Открыть
                          </span>
                      </a>
                  @{{/if}}

                  @{{if record_type_id==3}}
                      <a onclick="openTextRecord(${id}); return false;"  class="text-decoration-none text-grey">
                          <span class="d-flex align-items-center gap-2">
                              <i class="bi bi-pencil"></i>
                              Открыть
                          </span>
                      </a>
                  @{{/if}}
              </li>
              <li>
                  <a onclick="deleteAchievementRecord(${id}); return false;"  class="text-decoration-none text-grey">
                      <span class="d-flex align-items-center gap-2">
                          <i class="bi bi-x"></i>
                          Удалить
                      </span>
                  </a>
              </li>
          </ul>
      </div>
    </script>

    <script id="text_tmpl" type="text/x-jquery-tmpl">
        <div id="text_modal" style="padding-right: 20px;">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                     <h3>Описание ресурса</h3>
                 </div>
                 <div class="modal-body">
                     <div id="informationModalData">${content}</div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" onclick="closeTmplModal('text_modal')">Закрыть окно</button>
                 </div>
             </div>
         </div>
     </div>


    </script>

    <script id="work_tmpl" type="text/x-jquery-tmpl">
        <tr id="work_${id}" @{{if deleted_at!=null}} class="deleted" @{{/if}}>
       <td><input type="radio" name="work_id" value="${id}"></td>

       <th scope="row">${specialty.name}</th>
       <td>${student}</td>
       <td>${group}</td>
       <td>${protect_date}</td>
       <td>${name}</td>
       <td>${getAssessmentDescription(assessment)}</td>
       </tr>

    </script>

    <script id="overview_tmpl" type="text/x-jquery-tmpl">
    <div id="overview_modal" class="modal fade" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h3 class="modal-title">Портфолио Ваших достижений</h3>
                 </div>
                 <div class="modal-body">
                     <div id="user-achivements">
                         <div class="row">
                             <div class="col-sm-4">
                                 <div class="profile-sidebar">
                                     <div class="profile-userpic">
                                         <img src="/images/default.png" alt="" class="img-responsive">
                                     </div>
                                     <div class="profile-usertitle">
                                         <div class="profile-usertitle-name">
                                             ${name}
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-sm-8">
                                 <form class="form form-horizontal d-flex flex-column gap-3" action="staff-personal-info.html" method="post">
                                     <div class="row">
                                         <label class="col-sm-4 fw-bold text-grey fs-16">
                                            Фамилия, имя, отчество
                                         </label>
                                         <div class="col-sm-8 fw-500 text-black">
                                             ${name}
                                         </div>
                                     </div>
                                     <div class="row">
                                         <label class="col-sm-4 fw-bold text-grey fs-16">Адрес электронной почты</label>
                                         <div class="col-sm-8 fw-500 text-black">
                                             ${email}								</div>
                                     </div>
                                     <div class="row">
                                         <label class="col-sm-4 fw-bold text-grey fs-16">Организация</label>
                                         <div class="col-sm-8 fw-500 text-black">
                                             ${organization.name}
                                         </div>
                                     </div>
                                     <div class="row">
                                         <label class="col-sm-4"></label>
                                         <div class="col-sm-8">
                                             <div class="dropdown non-printable text-end">
                                                 <button class="btn btn-default text-grey fw-500" id="dLabel" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     <i class="bi bi-printer"></i>
                                                     Печать
                                                 </button>
                                                 <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                     <li><a href="#" class="text-grey fw-500 text-decoration-none" onclick="$('#achievements-tab').printThis(); return false;">Портфолио</a></li>
                                                     <li><a href="#" class="text-grey fw-500 text-decoration-none" onclick="$('#careers-tab').printThis(); return false;">Резюме</a></li>
                                                     <li><a href="#" class="text-grey fw-500 text-decoration-none" onclick="$('#user-achivements').printThis(); return false;">Все на одной странице</a></li>
                                                 </ul>

                                             </div>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                         <div class="row mt-4">
                             <div class="col-sm-12">
                                 <ul class="nav nav-tabs non-printable" role="tablist">
                                     <li role="presentation" class="nav-item">
                                         <a href="#achievements-tab" class="nav-link active" aria-controls="profile-base" role="tab" data-bs-toggle="tab"
                                            aria-expanded="false">
                                             <i class="fas fa-home"></i> Портфолио достижений
                                         </a>
                                     </li>
                                     <li role="presentation" class="nav-item">
                                         <a href="#educations-tab" class="nav-link" aria-controls="profile-achivements" role="tab"
                                            data-bs-toggle="tab" aria-expanded="false">
                                             <i class="fas fa-th"></i> Образование
                                         </a>
                                     </li>
                                     <li role="presentation" class="nav-item">
                                         <a href="#careers-tab" class="nav-link" aria-controls="profile-main" role="tab" data-bs-toggle="tab"
                                            aria-expanded="false">
                                             <i class="fas fa-graduation-cap"></i> Карьера
                                         </a>
                                     </li>
                                 </ul>
                                 <div class="tab-content">
                                     <div role="tabpanel" class="tab-pane active" id="achievements-tab">
                                         <h3 class="">Ваши достижения</h3>
                                         <table class="table table-bordered">
                                             <tbody id="overview_achievements_list"></tbody>
                                         </table>
                                     </div>
                                     <div role="tabpanel" class="tab-pane" id="educations-tab">
                                         <h3 class="">Ваше образование</h3>
                                         <div id="overview_educations_list">
                                         </div>
                                     </div>
                                     <div role="tabpanel" class="tab-pane" id="careers-tab">
                                         <h3 class="">Ваша профессиональная деятельность</h3>
                                         <div id="overview_careers_list">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-grey border-radius-5 fs-14 text-grey py-1" data-bs-dismiss="modal">
                        Закрыть
                    </button>
                </div>
             </div>
         </div>
     </div>
    </script>

    <script id="overview_achievement_tmpl" type="text/x-jquery-tmpl">
        <tr id="achievement_${id}">
          <td>
              ${name}
              <br>
              ${description}
          </td>
          <td>
              ${mode.name}
          </td>
          <td>
              ${record_date}
          </td>
         </tr>
    </script>

    <script id="overview_education_tmpl" type="text/x-jquery-tmpl">
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

    <script id="overview_career_tmpl" type="text/x-jquery-tmpl">
        <form class="form-horizontal row-life" id="career_${id}">
                           <span class="close-life">
                               <span onclick="deleteCareer(${id}); return false;" class="bi bi-x"></span>
                           </span>
           <div class="form-group">
               <div class="row">
                   <label class="col-sm-4 col-xs-4 fw-bold">Место работы</label>
                   <div class="col-sm-8 col-xs-8">${name}</div>
               </div>
           </div>
           <div class="form-group">
               <div class="row">
                   <label class="col-sm-4 col-xs-4 fw-bold">Год начала работы</label>
                   <div class="col-sm-8 col-xs-8">${start_year}</div>
               </div>
           </div>
           <div class="form-group">
               <div class="row">
                   <label class="col-sm-4 col-xs-4 fw-bold">Год окончания</label>
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
                   <label class="col-sm-4 col-xs-4 fw-bold">Должность</label>
                   <div class="col-sm-8 col-xs-8">${post}</div>
               </div>
           </div>
       </form>
    </script>
@endsection


