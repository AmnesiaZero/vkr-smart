@extends('layouts.dashboard.teacher')

<div class="container">
    <h2 class="bc-post-title">Настройка доступных подразделений организации</h2>
    <h2 class="bc-post-title-xs">Отметьте те подразделения, по которым вы бы хотели получать информацию и нажмите «Сохранить»</h2>
    <div class="row">
        <div class="col-sm-12">
            <form id="access_departments_form" onsubmit="saveDepartments(); return false;">
                    @foreach($years as $year)
                        <span class="department-year-title">{{$year->year}}</span>
                        @if(isset($year->faculties) and is_iterable($year->faculties))
                            @foreach($year->faculties as $faculty)
                                @if(isset($faculty->departments) and is_iterable($faculty->departments))
                                    @foreach($faculty->departments as $department)
                                        <div class="row row-bb">
                                            <div class="checkbox col-sm-12">
                                                <label class="text-success"><input type="checkbox" value="{{$department->id}}" name="departments_ids[]" @if(in_array($department->id,$departments_ids)) checked @endif> {{$faculty->name}}/ {{$department->name}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                  @else
                                      <div> Кафедры не назначены</div>

                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <button type="submit" class="btn btn-success">Сохранить изменения</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script src="/js/dashboard/teacher/settings/departments.js"></script>
@endsection
