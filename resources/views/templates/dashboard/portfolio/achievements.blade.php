@extends('layouts.dashboard.main')
@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-4 g-3 px-md-0 px-3">
            <div class="col">
                <div class="out-kod"></div>
                <form action="" method="" class="pt-4 col-xxl-4 col-xl-5 col-md-8">
                    <p class="text-grey mb-2 fs-14">ФИО обучающегося</p>
                    <div class="input-group input-group-lg br-100 br-green-light-2 focus-form mb-3">
                        <input type="text" name="q" value="" class="form-control search br-none fs-14 form-small-p"
                               placeholder="">
                        <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                            <img src="/images/Search.svg" alt="search">
                        </button>
                    </div>
                    <p class="text-grey mb-2 fs-14">Поиск по email</p>
                    <div class="input-group input-group-lg br-100 br-green-light-2 focus-form mb-3">
                        <input type="text" name="q" value="" class="form-control search br-none fs-14 form-small-p"
                               placeholder="">
                        <button class="btn pe-3 py-0 fs-14" type="submit" id="search">
                            <img src="/images/Search.svg" alt="search">
                        </button>
                    </div>
                    <div class="mt-auto">
                        <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1">применить</button>
                        <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1">сбросить</button>
                    </div>
                </form>
            </div>
        </div>
            <div class="d-flex mt-5">
                <button class="btn btn-secondary br-100 br-none text-grey fs-14 py-1 w-75 me-3"
                        onclick="openModal('add_achievement_modal')">добавить
                    <img src="/images/pl-green.svg" alt="" class="ps-2"></button>
                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 w-25"
                        onclick="openModal('import_work_modal')">Обзор<img
                        src="/images/File_Download_green.svg" alt="" class="ps-2"></button>
                <button class="btn br-green-light-2 br-100 text-grey fs-14 py-1 w-25"
                        onclick="openModal('import_work_modal')">Карточка<img
                        src="/images/File_Download_green.svg" alt="" class="ps-2"></button>
            </div>
        <div class="pt-5 px-md-0 px-3">
            <div class="big-table">
                <table class="table fs-14">
                    <thead class="brt-green-light-2 brb-green-light-2 lh-17">
                    <tr class="text-grey">
                        <th scope="col">Номер</th>
                        <th scope="col">Наименование/Описание</th>
                        <th scope="col">Тип деятельности</th>
                        <th scope="col">Дата достижения</th>
                        <th scope="col">Управление</th>
                    </tr>
                    </thead>
                    @include('layouts.dashboard.include.menu.achievement')
                    <tbody class="lh-17 brb-green-light-2" id="achievements_list">
                    </tbody>
                </table>
                <div id="tmpl_container">

                </div>
            </div>
        </div>
    </div>
    @include('layouts.dashboard.include.modal.add.achievement')
    @include('layouts.dashboard.include.modal.add.file')
    @include('layouts.dashboard.include.modal.add.link')
    @include('layouts.dashboard.include.modal.add.file')
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
      <img src="/images/three_dots.svg" alt="" class="btn-info-box cursor-p" onclick="openInfoBox(${id})">
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
             <td id="reviews_column" class="list-group"> </td>
             <td id="confirm_achievements_column" class="list-group"> </td>
             <td id="works_column" class="list-group"> </td>
             <td id="others_column" class="list-group"> </td>
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
       <div class="dropdown">
       <a onclick="getRecord(${id},${achievement_type_id})" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="list-group-item">
        @{{if record_type_id==1}}
          <span class="glyphicon glyphicon-save-file"></span>
          Файл
        @{{/if}}

        @{{if record_type_id==2}}
         <span class="glyphicon glyphicon-link">
          </span>
          Ссылка
        @{{/if}}

        @{{if record_type_id==3}}
         <span class="glyphicon glyphicon-eye-open"></span>
          Текст
        @{{/if}}
        <span class="gree">(${type.name})</span>
       </a>
       <ul class="dropdown-menu">
       <li><a onclick="getResource(111257); return false;" class="green">
       <span class="glyphicon glyphicon-edit"></span>
       Открыть</a>
       </li>
       <li>
       <a onclick="removeResource(111257); return false;" class="red">
       <span class="glyphicon glyphicon-remove"></span>
       Удалить</a>
       </li>
       </ul>
       </div>
    </script>



@endsection

