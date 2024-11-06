<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ВКР Смарт</title>
    <link href="{{'/css/bootstrap.min.css'}}" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <head>
        {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
        <link href="{{'/css/select2.min.css'}}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{'/css/bootstrap-select.css'}}">

        <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
              type="text/css"/>
        <link rel="stylesheet" type="text/css" href="{{'/css/dashboard.css'}}">
        <link rel="stylesheet" type="text/css" href="{{'/css/fancy_style.css'}}">
        <link rel="stylesheet" type="text/css" href="{{'/css/bootstrap-icons.css'}}">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        @yield('styles')
    </head>
<body class="h-100">
<header style="margin-bottom: 88px;">
    <nav class="desktop navbar navbar-expand-lg fixed-top header-nav bg-white brb-green-light-2 py-2 px-5">
        <button class="navbar-toggler collapsed box-shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false"
                aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="bi" fill="currentColor"
                 viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
            </svg>
        </button>
        <a class="navbar-brand brandName" href="{{route('home')}}">
            <img src="/images/VKR.svg" alt="">
        </a>
        <div class="navbar-collapse collapse justify-content-end" id="bdNavbar">
            <ul class="navbar-nav" style="align-items: baseline;">
                <li><a class="nav-link text-black-black" href="/home">Главная</a></li>
                <li><a class="nav-link text-black-black" href="/about/product">Хранение&nbsp;работ</a></li>

                <li><a class="nav-link text-black-black" href="/search/borrowings">Поиск&nbsp;заимствований</a></li>
                <li><a class="nav-link text-black-black" href="/portfolio">Портфолио</a></li>
                <li><a class="nav-link text-black-black" href="/check-reference">Проверка&nbsp;справки</a></li>
                <li><a class="nav-link text-black-black" href="https://api.vkr-vuz.ru" target="_blank">API</a></li>
            </ul>
            @include('layouts.common.menu.dropdown')
        </div>
    </nav>
</header>
<main class="position-relative h-100">
    <div class="row me-md-1 me-0 h-100">
        <div class="col-xl-3 col-lg-4 col-md-5 col-12 pe-md-3 pe-0">
            <div class="bg-grey-light p-5 menu">
                <div class="list-custom-1 accordion" id="accordionTwo">
                    @include('layouts.dashboard.include.headers.'.\Illuminate\Support\Facades\Auth::user()->roles()->first()->slug)
                </div>
            </div>
        </div>


        @yield('content')

        @if ($errors->any())
            <div class="alert alert-danger mb-0">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</main>

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
