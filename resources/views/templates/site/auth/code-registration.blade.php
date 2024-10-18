@extends('layouts.site.main')

@section('content')
    <div class="container bc-post p-5">
        <h2 class="bc-post-title mb-0" id="bc-post-title">Регистрация по коду приглашения</h2>
        <div id="ajax-content">
            <div class="row mt-4">
                <div class="col-sm-6" id="code_registration">
                    <form class="form-horizontal d-flex flex-column gap-2" id="registration_form" onsubmit="registration(); return false;">
                        <div class="row">
                            <div class="col-auto">
                                <label class="form-label">
                                    <span class="fs-16">Ваша организация:</span>
                                </label>
                            </div>

                            <span class="col">
                                {{$organization_name}}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-auto">
                                <label class="form-label"><span class="fs-16">Ваш тип пользователя:</span></label>
                            </div>
                            @if($code->type==1)
                                <span class="col">Студент</span>
                            @else
                                <span class="col">Преподаватель</span>
                            @endif
                        </div>

                        <div class="row pt-4">
                            <div class="col-sm-12">
                                <h4 class="bc-post-title-xs">
                                    <span>Укажите сведения о себе:</span>
                                </h4>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">
                                <span class="fs-16">Год выпуска</span>
                            </label>
                            <div class="col-sm-8">
                                <select class="selectpicker form-control" id="years_list" name="year_id"
                                        title="Выбрать..." required>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">
                                <span class="fs-16">Факультет</span>
                            </label>
                            <div class="col-sm-8">
                                <select class="selectpicker form-control" id="faculties_list" name="faculty_id"
                                        title="Выбрать..." required>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">
                                <span class="fs-16">Кафедры</span>
                            </label>
                            <div class="col-sm-8">
                                @if($code->type==1)
                                    <select class="selectpicker form-control" id="departments_list" name="department_id"
                                    title="Выбрать..." required>
                                    </select>
                                @else
                                    <select name="departments_ids[]" id="departments_list_multiple"
                                            class="selectpicker form-control bs-select-hidden"
                                            data-title="Выбрать несколько..." data-width="100%"
                                            multiple>
                                        <option value="" selected>Выбрать</option>

                                    </select>
                                @endif
                            </div>
                        </div>

                        @if($code->type==1)
                            <div class="row">
                                <label class="col-sm-4">
                                    <span class="fs-16">Выберите направление подготовки</span>
                                </label>
                                <div class="col-sm-8">
                                    <select class="selectpicker form-control" name="specialty_id"
                                            id="programs_specialties_list" title="Выбрать..." required>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-4">
                                    <span class="fs-16">Укажите вашу группу</span>
                                </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="group"
                                           placeholder="Уточните группу, в которой вы обучаетесь..." required>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <label class="form-label col-sm-4"><span class="fs-16">Укажите ваше ФИО:</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" placeholder="ФИО" required>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-4">
                                <span class="fs-16">Номер телефона</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" placeholder="+7 999 999 99 99">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">
                                <span class="fs-16">Дата рождения</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_of_birth">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4">
                                <span class="fs-16">Пол</span>
                            </label>
                            <div class="col-sm-8">
                                <select name="gender" class="selectpicker form-control" required>
                                    <option value="1">Муж.</option>
                                    <option value="2">Жен.</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <label class="form-label col-sm-4">
                                <span class="fs-16">Укажите ваш email-адрес:</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email"
                                       placeholder="Ввод..."
                                       required>
                            </div>
                        </div>

                        <div class="row">
                            <label class="form-label col-sm-4">
                                <span class="fs-16">Придумайте пароль:</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="password" id="password" class="form-control" name="password"
                                       placeholder="Не менее 8 символов..."
                                       required aria-autocomplete="list">
                            </div>
                        </div>

                        <div class="row">
                            <label class="form-label col-sm-4">
                                <span class="fs-16">Повторите ввод пароля:</span>
                            </label>
                            <div class="col-sm-8">
                                <input type="password" id="repassword" class="form-control" name="repassword"
                                       placeholder="Подтвердите пароль"
                                       required>
                            </div>
                        </div>

                        <div class="row pt-2 justify-content-end">
                            <div class="col-sm-8 mb-2 text-end">
                                <button class="btn btn-primary btn-block" id="registration-button" type="submit">
                                    Зарегистрироваться
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-6" id="welcome-message">
                    <blockquote>
                        <p>Добро пожаловать в систему персональной регистрации пользователей комплекса систем хранения и
                            проверок на
                            замствования ВКР-СМАРТ. </p>
                        <p>Специально для наших пользователей мы разработали модуль персональной регистрации, после
                            прохождения
                            которой становятся доступными дополнительные возможности при работе в системе.</p>
                        <p>На данную страницу участники попадают автоматически при указании временного кода
                            приглашения.</p>
                        <p>Для прохождения регистрации заполните все необходимые поля формы. Если вы уже
                            регистрировались в системе
                            ранее или авторизованы автоматически в Вашем вузе, нажмите кнопку "Авторизация", вы будете
                            перемещены на
                            форму входа.</p>
                        <div class="text-end">
                            <a href="/login" class="btn btn-primary btn-block">Авторизоваться</a>
                        </div>
                    </blockquote>
                </div>

                <div id="success_registration"></div>
                <input id="code_id" style="display: none" value="{{\Illuminate\Support\Facades\Cookie::get('invite_code_id')}}">
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript" src="/js/jquery/jquery.cookie.js"></script>

    <script id="year_tmpl" type="text/x-jquery-tmpl">
                    <option value="${id}" onclick="faculties(${id})">${year}</option>



                </script>

    <script id="faculty_tmpl" type="text/x-jquery-tmpl">
                    <option value="${id}">${name}</option>



                </script>
    <script id="program_specialty_tmpl" type="text/x-jquery-tmpl">
                <option value="${id}">${code}|${name}</option>

                </script>

    <script id="department_list_tmpl" type="text/x-jquery-tmpl">
                    <option value="${id}">${name}</option>

                </script>

    <script id="success_registration_tmpl" type="text/x-jquery-tmpl">
                    <div class="alert px-0">
                        <p>Вы успешно прошли регистрацию в комплексе систем по размещению и проверке работ на заимствования.</p>

                        <p>Ваши учетные данные для авторизации на платформе:</p>

                        <p>
                            Имя пользователя:
                            <strong id="reg-name">${login}</strong>
                        </p>
                        <p>
                            Пароль: <strong id="reg-password"></strong>
                        </p>

                        <p>Данные также были отправлены на адрес Вашей электронной почты.</p>

                        <p class="mt-5">
                            <a href="/login" class="btn btn-primary btn-block">Авторизоваться по логину и паролю</a>
                        </p>
                    </div>

                </script>

    <script src="/js/site/code-register.js"></script>
@endsection

