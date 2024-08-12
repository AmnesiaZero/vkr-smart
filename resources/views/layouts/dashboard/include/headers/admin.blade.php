<div class="accordion-item">
    <p class="accordion-header setting" id="headingOne">
        <button class="accordion-button fs-16 fw-600 box-shadow-none px-0 py-2 m-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                aria-controls="collapseOne"><span style="width: 40px; height: 24px;"
                                                  class="pe-3"></span>Настройки
        </button>
    </p>
    <div id="collapseOne"
         class="accordion-collapse collapse @if(request()->is('dashboard/settings/*')) show @endif"
         aria-labelledby="headingOne" data-bs-parent="#collapseOne" style="">
        <div class="accordion-body p-0">
            <ul class="list-custom-1 m-0">
                <li class="list-select"><a href="/dashboard/settings/organizations-structure"
                                           class="select-a @if(request()->is('*/organizations-structure')) list-select-active @endif">Структура
                        <br>организации</a></li>
                <li class="list-select"><a href="/dashboard/settings/access"
                                           class="select-a @if(request()->is('*/access')) list-select-active @endif">Настройка
                        <br>доступа</a></li>
                <li class="list-select"><a href="/dashboard/settings/invite-codes"
                                           class="select-a @if(request()->is('*/invite-codes')) list-select-active @endif">Генерация
                        <br>кодов приглашений</a></li>
                <li class="list-select"><a href="/dashboard/settings/user-management"
                                           class="select-a @if(request()->is('*/user-management')) list-select-active @endif">Управление
                        <br>пользователями</a></li>
                <li class="list-select"><a href="/dashboard/settings/handbook-management"
                                           class="select-a @if(request()->is('*/handbook-management')) list-select-active @endif">Управление
                        <br>справочниками</a></li>
                <li class="list-select"><a href="/dashboard/settings/"
                                           class="select-a @if(request()->is('*/view')) list-select-active @endif">Оформление</a>
                </li>
                <li class="list-select"><a href="/dashboard/settings/integration"
                                           class="select-a @if(request()->is('*/integration')) list-select-active @endif">Интеграция</a>
                </li>
                <li class="list-select"><a href="/dashboard/settings/api"
                                           class="select-a @if(request()->is('*/api')) list-select-active @endif">API
                        ключ</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-item">
    <p class="accordion-header work" id="headingTwo">
        <button class="accordion-button fs-16 fw-600 box-shadow-none px-0 py-2 m-0 collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                aria-expanded="false" aria-controls="collapseTwo"><span
                style="width: 40px; height: 24px;" class="pe-3"></span>Работы
        </button>
    </p>
    <div id="collapseTwo"
         class="accordion-collapse collapse @if(request()->is('dashboard/works/*')) show @endif"
         aria-labelledby="headingTwo" data-bs-parent="#accordionTwo" style="">
        <div class="accordion-body p-0">
            <ul class="list-custom-1 m-0">
                <li class="list-select"><a href="/dashboard/works/employees"
                                           class="select-a @if(request()->is('*/works/employees')) list-select-active @endif">Загруженные
                        <br>сотрудниками</a></li>
                <li class="list-select"><a href="/dashboard/works/students"
                                           class="select-a  @if(request()->is('*/works/students')) list-select-active @endif">Загруженные
                        <br>студентами</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-item">
    <p class="accordion-header portfolio" id="headingThree">
        <button class="accordion-button fs-16 fw-600 box-shadow-none px-0 py-2 m-0 collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                aria-expanded="false" aria-controls="collapseThree"><span
                style="width: 40px; height: 24px;" class="pe-3"></span>Электронное <br>портфолио
        </button>
    </p>
    <div id="collapseThree"
         class="accordion-collapse collapse @if(request()->is('dashboard/portfolios/*')) show @endif"
         aria-labelledby="headingThree" data-bs-parent="#collapseThree" style="">
        <div class="accordion-body p-0">
            <ul class="list-custom-1 m-0">
                <li class="list-select"><a href="/dashboard/portfolio/teachers"
                                           class="select-a @if(request()->is('*/portfolios/teachers')) list-select-active @endif">Портфолио<br>преподавателей</a>
                </li>
                <li class="list-select"><a href="/dashboard/portfolio/students"
                                           class="select-a @if(request()->is('*/portfolios/students')) list-select-active @endif">Портфолио<br>обучающихся</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<p class="text-grey fw-600"><img src="/images/Chart_Line.svg" alt="" class="pe-3"><a
        href="/dashboard/reports"
        class="text-grey text-grey-hover fw-600 td-none @if(request()->is('dashboard/report')) list-select-active @endif">Отчеты</a>
</p>
<p class="text-grey fw-600"><img src="/images/File_Document.svg" alt="" class="pe-3"><a
        href="/dashboard/documentation"
        class="text-grey text-grey-hover fw-600 td-none @if(request()->is('dashboard/documentation')) list-select-active @endif">Документация</a>
</p>
