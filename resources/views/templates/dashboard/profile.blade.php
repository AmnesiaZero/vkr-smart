@extends('layouts.dashboard.main')

@section('content')
    <div class="col-xl-9 col-lg-8 col-md-7 col-12 pe-md-3 pe-0 ">
        <div class="form form-horizontal pt-4 gap-3 d-flex flex-column">
            <h3 class="row-bb">Персональная информация:</h3>
            <div class="row">
                <label class="col-sm-3 fs-16">Фамилия, имя, отчество</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="fullname" placeholder="" value="{{$user->name}}">
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 fs-16">Адрес электронной почты</label>
                <div class="col-sm-9">
                    {{$user->email}}
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 fs-16">Организация</label>
                <div class="col-sm-9">
                    {{$user->organization->name}}
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 fs-16">Роль</label>
                <div class="col-sm-9">
                    {{$user->roles[0]->name}}
                </div>
            </div>
            <h3 class="bc-post-title pt-4 mb-0">Информация о доступе:</h3>
            <div class="form-group">
                <label class="col-sm-4 fs-16">Список управляемых подразделений</label>
                <div class="col-sm-9 pt-3">
                    <table class="table table-bordered table-mini">
                        <thead>
                        <tr>
                            <th class="bg-green-light">Год обучения</th>
                            <th class="bg-green-light">Подразделение</th>
                            <th class="bg-green-light">Кафедра</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($user->departments))
                            @foreach($user->departments as $department)
                                <tr>
                                    <td>{{$department->year->year}}</td>
                                    <td>{{$department->faculty->name}}</td>
                                    <td>{{$department->name}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
