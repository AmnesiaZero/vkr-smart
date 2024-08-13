@extends('layouts.dashboard.main')

@section('content')
<div class="form form-horizontal">
    <h3 class="row-bb">Персональная информация:</h3>
    <div class="form-group form-group-lg row-bb">
        <label class="col-sm-4">Фамилия, имя, отчество</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="fullname" placeholder="" value="{{$user->name}}">
        </div>
    </div>
    <div class="form-group row-bb">
        <label class="col-sm-4">Адрес электронной почты</label>
        <div class="col-sm-8">
            {{$user->email}}
        </div>
    </div>
    <div class="form-group row-bb">
        <label class="col-sm-4">Организация</label>
        <div class="col-sm-8">
            {{$user->organization->name}}
        </div>
    </div>
    <div class="form-group row-bb">
        <label class="col-sm-4">Роль</label>
        <div class="col-sm-8">
            {{$user->roles[0]->name}}
        </div>
    </div>
    <h3 class="bc-post-title">Информация о доступе:</h3>
    <div class="form-group row-bb">
        <label class="col-sm-4">Список управляемых подразделений</label>
        <div class="col-sm-8">
            <table class="table table-bordered table-mini">
                <thead>
                <tr>
                    <th>Год обучения</th>
                    <th>Подразделение</th>
                    <th>Кафедра</th>
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
@endsection
