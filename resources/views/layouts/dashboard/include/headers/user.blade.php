<div class="accordion-item">
    <p class="accordion-header work" id="headingOne">
        <button class="accordion-button fs-16 fw-600 box-shadow-none px-0 py-2 m-0 collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                aria-expanded="false" aria-controls="collapseOne">
            <span style="width: 40px; height: 24px;" class="pe-3"></span>
            Персональная информация
        </button>
    </p>
    <div id="collapseOne"
         class="accordion-collapse collapse @if(request()->is('dashboard/student/personal-cabinet')) show @endif"
         aria-labelledby="headingOne" data-bs-parent="#accordionTwo" style="">
        <div class="accordion-body p-0">
            <ul class="list-custom-1 m-0">
                <li class="list-select">
                    <a href="/dashboard/personal-cabinet"
                       class="select-a @if(request()->is('*/personal-cabinet')) nav-link-active @endif">
                        Профиль
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-item">
    <p class="accordion-header work" id="headingTwo">
        <button class="accordion-button fs-16 fw-600 box-shadow-none px-0 py-2 m-0 collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                aria-expanded="false" aria-controls="collapseTwo">
            <span style="width: 40px; height: 24px;" class="pe-3"></span>
            Работы
        </button>
    </p>
    <div id="collapseTwo" class="accordion-collapse collapse @if(request()->is('dashboard/works/*')) show @endif"
         aria-labelledby="headingTwo" data-bs-parent="#accordionTwo" style="">
        <div class="accordion-body p-0">
            <ul class="list-custom-1 m-0">
                <li class="list-select">
                    <a href="/dashboard/works/you"
                       class="select-a @if(request()->is('*/works/you')) nav-link-active @endif">
                        Загруженные<br>вами
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="accordion-item">
    <p class="accordion-header portfolio" id="headingThree">
        <button class="accordion-button fs-16 fw-600 box-shadow-none px-0 py-2 m-0 collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                aria-expanded="false" aria-controls="collapseThree">
            <span style="width: 40px; height: 24px;" class="pe-3"></span>
            Электронное <br>портфолио
        </button>
    </p>
    <div id="collapseThree"
         class="accordion-collapse collapse @if(request()->is('dashboard/portfolios/*')) show @endif"
         aria-labelledby="headingThree" data-bs-parent="#collapseThree" style="">
        <div class="accordion-body p-0">
            <ul class="list-custom-1 m-0">
                <li class="list-select">
                    <a href="/dashboard/portfolios/achievements/you"
                       class="select-a @if(request()->is('*/portfolios/achievements/you')) nav-link-active @endif">
                        Мои<br> достижения
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
