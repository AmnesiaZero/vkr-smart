<div class="text-grey fw-600 d-flex py-2">
    <img src="/images/File_Document.svg" alt="" class="pe-3">
    <a href="/dashboard/profile"
        class="text-grey text-grey-hover fw-600 td-none @if(request()->is('*/personal-cabinet')) nav-link-active @endif">
        Персональная&nbsp;информация
    </a>
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
                <li class="list-select"><a href="/dashboard/portfolios/teachers"
                                           class="select-a @if(request()->is('*/portfolios/teachers')) list-select-active @endif">Портфолио<br>преподавателей</a>
                </li>
                <li class="list-select"><a href="/dashboard/portfolios/students"
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
