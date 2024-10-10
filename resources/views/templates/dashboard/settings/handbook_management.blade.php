@extends('layouts.dashboard.main')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12">
        <div class="row pt-5 px-0 px-sm-4 mx-sm-0 mx-4">
            <div class="col-xl-6 col-lg-8 col-md-10 col-12 br-green-light-2 br-15 p-3 mb-3" id="works_types_list">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="/images/Lock.svg" alt="">
                    <p class="m-0">Неизменяемые типы работ:</p>
                </div>
                @if(isset($works_types) and is_iterable($works_types))
                    @foreach($works_types as $works_type)
                        <div class="badge text-black-black bg-green-light br-100 fs-14 me-1 mb-1"
                             id="work_type_{{$works_type->id}}">
                             {{$works_type->name}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row px-0 px-sm-4 mx-sm-0 mx-4">
            <div class="col-xl-6 col-lg-8 col-md-10 col-12 br-green-light-2 br-15 p-3 mb-3"
                 id="scientific_supervisors_list">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="/images/Lock.svg" alt="">
                    <p class="m-0">Научные руководители:</p>
                </div>
                @if(isset($scientific_supervisors) and is_iterable($scientific_supervisors))
                    @foreach($scientific_supervisors as $scientific_supervisor)
                        <div class="badge text-black-black bg-green-light br-100 fs-14 me-1 mb-1"
                             id="scientific_supervisor_{{$scientific_supervisor->id}}">
                             {{$scientific_supervisor->name}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row px-0 px-sm-4 mx-sm-0 mx-4 pt-4">
            <div class="col-xl-6 col-lg-8 col-md-10 col-12 br-green-light-2 br-15 p-3 mb-3">
                <form onsubmit="addWorksType();return false" id="add_works_type_form" class="mb-3">
                    <p class="mb-2">Добавление типов работ:</p>
                    <div class="out-kod my-2"></div>

                    <div class="input-group">
                        <input type="text" name="name" id="content" class="form-control" placeholder="Наименование" onkeydown="checkForEnter(event)">
                        <button type="submit" class="fs-14 btn text-grey btn-secondary">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row px-0 px-sm-4 mx-sm-0 mx-4">
            <div class="col-xl-6 col-lg-8 col-md-10 col-12 br-green-light-2 br-15 p-3 mb-3">
                <form onsubmit="addScientificAdvisor();return false" id="add_scientific_advisor_form" class="mb-3">
                    <p class="mb-2">Научные руководители</p>
                    <div class="out-kod_1 my-2"></div>

                    <div class="input-group">
                        <input type="text" name="name" id="content_1" class="form-control" placeholder="ФИО" onkeydown="checkForEnter_1(event)">
                        <button type="submit" class="fs-14 btn text-grey btn-secondary">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/dashboard/settings/handbook_management.js">

    </script>

    <script id="scientific_supervisor_tmpl" type="text/x-jquery-tmpl">
       <div class="badge text-black-black bg-green-light br-100 fs-14 me-1 mb-1" onclick="deleteScientificSupervisor(${id})" id="scientific_supervisor_${id}">${name}</div>
    </script>

    <script id="works_type_tmpl" type="text/x-jquery-tmpl">
       <div class="badge text-black-black bg-green-light br-100 fs-14 me-1 mb-1" onclick="deleteWorkType(${id})" id="work_type_${id}">${name}</div>
    </script>
@endsection
