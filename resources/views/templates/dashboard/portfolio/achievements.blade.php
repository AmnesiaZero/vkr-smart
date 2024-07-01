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
                        onclick="openModal('add_achievement_form')">добавить
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
                    <tbody class="lh-17 brb-green-light-2" id="achievements_list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('layouts.dashboard.include.modal.add.achievement')
@endsection

@section('scripts')
    <script id="achievement_tmpl" type="text/x-jquery-tmpl">
  <tr>
     <td>
        ${index + 1}
    </td>
    <td>
        ${name}
    </td>
    <td>
        ${mode.name}
    </td>
    <td>
        ${record_date}
    </td>
   </tr>
    </script>
@endsection

