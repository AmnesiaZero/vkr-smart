@extends('layouts.dashboard.main')

@section('content')
<div class="col-xl-9 col-lg-8 col-md-7 col-12">

    <div class="container pt-5">
        <h2 class="bc-post-title">Настройка доступных подразделений организации</h2>

        <h3 class="bc-post-title-xs mt-4 fs-24 fw-600">
            Отметьте те подразделения, по которым вы бы хотели <br> получать информацию и нажмите «Сохранить»
        </h3>

        <div class="row mt-5">
            <div class="col-sm-12">
                <form id="access_departments_form" onsubmit="saveDepartments(); return false;">
                    @foreach($years as $year)
                        <div class="mt-4">
                            <hr>
                            <span class="department-year-title">{{$year->year}}</span>
                            @if(isset($year->faculties) and is_iterable($year->faculties))
                                @foreach($year->faculties as $faculty)
                                    @if(isset($faculty->departments) and is_iterable($faculty->departments))
                                        @foreach($faculty->departments as $department)
                                            <div class="row row-bb">
                                                <div class="checkbox col-sm-12">
                                                    <label class="text-success">
                                                        <input type="checkbox" value="{{$department->id}}"
                                                               name="departments_ids[]" @if(in_array($department->id,$departments_ids)) checked @endif>
                                                        {{$faculty->name}} / {{$department->name}}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div>Кафедры не назначены</div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary d-block px-5 mt-5">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="/js/dashboard/settings/departments.js"></script>
@endsection
