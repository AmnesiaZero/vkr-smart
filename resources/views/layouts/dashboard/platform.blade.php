<!DOCTYPE html>
<html lang="ru" dir="ltr">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="DataLIB Dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>DataLIB Dashboard</title>
    <!-- GOOGLE FONTS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="{{'/css/bootstrap.min.css'}}" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{'/css/select2.min.css'}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{'/css/bootstrap-select.css'}}">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500"
          rel="stylesheet"/>
    <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet"/>
    <link href="{{ secure_asset('fonts/awesome/v5.15.1/css/all.min.css') }}" rel="stylesheet"/>
    <!-- PLUGINS CSS STYLE -->
    <!-- SLEEK CSS -->
    <link rel="stylesheet" href="/css/platform/sleek.css"/>
    @yield('styles')
    <link rel="stylesheet" href="/css/platform/main.css"/>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
          type="text/css"/>
{{--    <link rel="stylesheet" type="text/css" href="{{'/css/dashboard.css'}}">--}}
    <link rel="stylesheet" type="text/css" href="{{'/css/fancy_style.css'}}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

</head>
<body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
<div id="toaster"></div>
<div class="wrapper">
    <aside class="left-sidebar bg-sidebar">
        <div id="sidebar" class="sidebar sidebar-with-footer">
            <div class="app-brand">
                <a href="">
                    <img src="/images/logo/logo-book-5-crop.png" alt="datalib logo" style="max-width: 45px;">
                    <span class="brand-name">ВКР СМАРТ</span>
                </a>
            </div>
            <div class="sidebar-scrollbar">
                <ul class="nav sidebar-inner" id="sidebar-menu">
                    <li class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <a href="" class="sidenav-item-link">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span class="nav-text">Главная</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.news.index') ? 'active' : '' }}">
                        <a href="" class="sidenav-item-link">
                            <i class="mdi mdi-library-books"></i>
                            <span class="nav-text">Новости</span>
                        </a>
                    </li>
                    <li class="has-sub {{ (request()->segment(2) == 'organizations') ? 'expand' : '' }}">
                        <a href="javascript:void(0)" class="sidenav-item-link {{ (request()->segment(2) == 'organizations') ? 'collapsed' : '' }}" data-toggle="collapse" data-target="#organizations" aria-expanded="{{ (request()->segment(2) == 'organizations') ? 'true' : 'false' }}" aria-controls="organizations">
                            <i class="mdi mdi-rhombus-split"></i>
                            <span class="nav-text">Организации</span> <span class="caret"></span>
                        </a>
                        <ul id="organizations" class="collapse {{ (request()->segment(2) == 'organizations') ? 'show' : ''}}">
                            <div class="sub-menu">
                                <li class="{{ request()->routeIs('dashboard.organizations.index') ? 'active' : '' }}">
                                    <a href="" class="sidenav-item-link">
                                        <span class="nav-text">Организации</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('dashboard.organizations.departments.index') ? 'active' : '' }}">
                                    <a href="" class="sidenav-item-link">
                                        <span class="nav-text">Отделения</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('dashboard.organizations.groups.index') ? 'active' : '' }}">
                                    <a href="" class="sidenav-item-link">
                                        <span class="nav-text">Группы</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('dashboard.organizations.digital-departments.index') ? 'active' : '' }}">
                                    <a href="" class="sidenav-item-link">
                                        <span class="nav-text">Цифровые кафедры</span>
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </li>



                    <li class="{{ request()->routeIs('dashboard.users.index') ? 'active' : '' }}">
                        <a href="" class="sidenav-item-link">
                            <i class="mdi mdi-book-open-page-variant"></i>
                            <span class="nav-text">Пользователи</span>
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </aside>
    <div class="page-wrapper">
        <header class="main-header " id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg">
                <button id="sidebar-toggler" class="sidebar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <div class="search-form d-none d-lg-inline-block">
                    <div class="input-group">
                        <button type="button" name="search" id="search-btn" class="btn btn-flat">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                        <input type="text" name="query" id="search-input" class="form-control"
                               placeholder="'button', 'chart' etc." autofocus autocomplete="off"/>
                    </div>
                    <div id="search-results-container">
                        <ul id="search-results"></ul>
                    </div>
                </div>
                <div class="navbar-right ">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user-menu">
                            <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <img src="/images/no-user-image.jpg" class="user-image" alt="{{ $user->name }}"/>
                                <span class="d-none d-lg-inline-block">{{ $user->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <!-- User image -->
                                <li class="dropdown-header">
                                    <img src="/images/no-user-image.jpg" class="img-circle" alt="{{ $user->email }}"/>
                                    <div class="d-inline-block">
                                        {{ $user->name }} <small class="pt-1">{{ $user->email }}</small>
                                    </div>
                                </li>
                                <li>
                                    <a href="user-profile.html">
                                        <i class="mdi mdi-account"></i> Мой профиль
                                    </a>
                                </li>
                                <!-- <li class="right-sidebar-in">
                                    <a href="javascript:0"> <i class="mdi mdi-settings"></i> Setting </a>
                                </li> -->
{{--                                <li class="dropdown-footer">--}}
{{--                                    <form method="POST" action=">--}}
{{--                                        {{ csrf_field() }}--}}
{{--                              --}}
{{--                                           onclick="event.preventDefault(); this.closest('form').submit();">--}}
{{--                                            <i class="mdi mdi-logout"></i> Выйти--}}
{{--                                        </a>--}}
{{--                                    </form>--}}
{{--                                </li>--}}
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div id="content" class="content-wrapper">
            <div class="content">
                @yield('content')
            </div>
        </div>
        <footer class="footer mt-auto">
            <div class="copyright bg-white">
                <p>
                    &copy; <span id="copy-year">2019</span> Copyright Sleek Dashboard Bootstrap Template by
                    <a class="text-primary" href="https://izamax.net/" target="_blank">IzaMAX</a>
                </p>
            </div>
            <script>
                let d = new Date();
                let year = d.getFullYear();
                document.getElementById("copy-year").innerHTML = year;
            </script>
        </footer>
    </div>
</div>
<div id="tmpl_container">

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="{{'/js/select2.min.js'}}"></script>
<script type="text/javascript" src="/js/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>--}}
{{--<script src="http://www.vkr-vuz.ru/assets/templates/c/js/jquery.fancytree.min.js"></script>--}}
<script src="/js/jquery/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>


<script src="/js/bootstrap-select.js"></script>



<script src="/js/app.js"></script>

<script src="/js/jquery/jquery.tmpl.min.js"></script>
<script src="/js/jquery/jquery.simplePagination.js"></script>


@yield('scripts')
</body>
</html>
