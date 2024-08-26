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

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500"
          rel="stylesheet"/>
    <link href="https://cdn.materialdesignicons.com/4.4.95/css/materialdesignicons.min.css" rel="stylesheet"/>
    <link href="{{ secure_asset('fonts/awesome/v5.15.1/css/all.min.css') }}" rel="stylesheet"/>
    <!-- PLUGINS CSS STYLE -->
    <link href="{{ secure_asset('plugins/nprogress/css/nprogress.css') }}" rel="stylesheet"/>
    <!-- No Extra plugin used -->
    <link href="{{ secure_asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet"/>
    <link href="{{ secure_asset('plugins/toastr/css/toastr.min.css') }}" rel="stylesheet"/>
    <link href="{{ secure_asset('plugins/datetimepicker/jquery.datetimepicker.min.css') }}" rel="stylesheet">
    <!-- SLEEK CSS -->
    <link id="sleek-css" rel="stylesheet" href="/css/platform/sleek.css"/>
    @yield('styles')
    <link id="sleek-css" rel="stylesheet" href="/css/platform/main.css"/>
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" sizes="16x16 32x32 48x48 64x64 128x128" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="188x188" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/favicon.ico">

    <link rel="shortcut icon" type="image/x-icon" sizes="16x16 32x32 48x48 64x64 128x128" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="188x188" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/favicon.ico">
    <!--
        HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ secure_asset('plugins/nprogress/js/nprogress.js') }}"></script>
</head>
<body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
<script>
    NProgress.configure({
        showSpinner: false
    });
    NProgress.start();
</script>
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

<script src="{{ secure_asset('plugins/jquery/jquery/v3.5.1/jquery-3.5.1.min.js') }}"></script>
<script src="{{ secure_asset('plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
<script src="{{ secure_asset('plugins/jekyll-search/jekyll-search.min.js') }}"></script>
<script src="{{ secure_asset('plugins/moment/moment.js') }}"></script>
<script src="{{ secure_asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ secure_asset('plugins/toastr/js/toastr.min.js') }}"></script>
<script src="{{ secure_asset('dashboards/sleek/js/sleek.bundle.js') }}"></script>
<script src="{{ secure_asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ secure_asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script>
    jQuery.validator.setDefaults({
        errorPlacement: function (error, element) {
            $(element).closest("form").find("label[for='" + element.attr("id") + "']").append(error);
        },
        errorElement: "span",
        messages: {
            name: {
                required: " (это поле обязательно)"
            },
            email: {
                required: " (это поле обязательно)"
            }
        }
    });

    let getUsers = function (event_id, page = 1) {
        $('#listUsers').css({opacity: .5});
        $.ajax({
            type: "POST",
            url: "/dashboard/events/users",
            data: {
                "_token": "{{ csrf_token() }}",
                "event_id": event_id,
            },
            dataType: "json",
            success: function (result) {
                // $('#num_of_publications').text(result.info.total)
                $('#listUsers').html(result.view).css({opacity: 1});
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    }

    function callToaster(type, title, message, redirectUrl = false, redirectCallback = null) {
        let positionClass;

        if (document.dir != "rtl") {
            positionClass = "toast-top-right";
        } else {
            positionClass = "toast-top-left";
        }

        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: positionClass,
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "2000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };

        switch (type) {
            case 'info':
                toastr.info(message, title);
                break;
            case 'success':
                if (redirectUrl) {
                    toastr.options.onHidden = function () {
                        document.location.href = redirectUrl;
                    }
                }

                if (redirectCallback) {
                    toastr.options.onHidden = function () {
                        redirectCallback();
                    }
                }

                toastr.success(message, title);

                break;
            case 'error':
                toastr.error(message, title);
                break;
            default:
                toastr.success(message, title);
                break;
        }
    }

    function escapeHtml(string) {
        let entityMap = {
            '<p>&nbsp;<\/p>': '',
        };
        return String(string).replace(/<p>&nbsp;<\/p>/gi, function (s) {
            return entityMap[s];
        });
    }

    $(document).on('click', '#save-close', function (e) {
        e.preventDefault();
        let form = $('#formContent');
        let redirectUrl = form.data('action-index');

        if (form.valid()) {
            $(this).attr('disabled', 'disabled');
            let editorFieldName = $('#formContent textarea.editor').attr('name');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: form.attr('action'),
                data: (window.editor) ? form.serialize() + '&' + editorFieldName + '=' + encodeURIComponent(escapeHtml(window.editor.getData())) : form.serialize(),
                dataType: "json",
                success: function (result) {
                    if (!result.error) {
                        callToaster("success", result.successTitle, result.successMessage, redirectUrl);
                    }
                },
                error: function (jqXHR, Exception) {
                    $('div#ajaxMessages').removeClass().addClass('alert alert-danger');
                    setTimeout(function () {
                        $('div#ajaxMessages').html('<p><i class="fa fa-check"></i>При выполнении AJAX-запроса произошла ошибка</p>');
                        $('div#ajaxMessages').slideDown('slow');
                    }, 250);
                    setTimeout(function () {
                        $('div#ajaxMessages').slideUp('slow');
                    }, 3000);
                }
            });
        } else {
            $("html, body").animate({scrollTop: 0}, "slow");
        }
    });

    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        let form = $('#formContent');
        if (form.valid()) {
            let editorFieldName = $('#formContent textarea.editor').attr('name');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: form.attr('action'),
                data: (window.editor) ? form.serialize() + '&' + editorFieldName + '=' + encodeURIComponent(escapeHtml(window.editor.getData())) : form.serialize(),
                dataType: "json",
                success: function (result) {
                    if (!result.error) {
                        let toaster = $('#toaster');
                        if (toaster.length != 0) {
                            if ($("input[name='id']").val() == 0) {
                                let redirectUrl = result.id + '/edit';
                                callToaster("success", result.successTitle, result.successMessage, redirectUrl);
                            } else {
                                callToaster("success", result.successTitle, result.successMessage);
                            }
                        }
                    } else {

                    }
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                    callToaster("error", "Error", jqXHR);
                }
            });
        } else {
            $("html, body").animate({scrollTop: 0}, "slow");
        }
    });

    $(document).on('click', '#close', function (e) {
        e.preventDefault();
        document.location.href = $('#formContent').data('action-index');
    });

    $(document).on('click', '.destroy', function (e) {
        e.preventDefault();
        let link = $(this);
        let id = link.attr('data-item-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: link.attr('href'),
            data: {
                "_method": "delete"
            },
            dataType: "json",
            success: function (result) {
                if (!result.error) {
                    let toaster = $('#toaster');

                    if (toaster.length != 0) {
                        callToaster("success", result.successTitle, result.successMessage);
                    }

                    let restoreLink = $('<a>')
                        .html('<i id="stat_' + id + '" class="icon fas fa-trash-restore"></i>')
                        .attr('data-item-id', id)
                        .attr('href', result.restoreLink)
                        .addClass('restore d-inline mr-2');

                    let deleteLink = $('<a>')
                        .html('<i id="stat_' + id + '" class="icon far fa-trash-alt"></i>')
                        .attr('data-item-id', id)
                        .attr('href', result.deleteLink)
                        .addClass('delete d-inline');



                    link.closest('tr').addClass('deleted');
                    link.closest('tr').find('td.status').find('a').removeAttr('href').find('i').addClass('disabled');
                    link.closest('tr').find('td.actions').hide().html('').append(restoreLink).append(deleteLink).fadeIn();

                }
            },
            error: function (jqXHR, Exception) {
                console.log('error?');
                console.log(jqXHR);
            }
        });
    });

    $(document).on('click', '.restore', function (e) {
        e.preventDefault();
        let link = $(this);
        let id = link.attr('data-item-id');
        console.log(id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: link.attr('href'),
            data: {},
            dataType: "json",
            success: function (result) {
                if (!result.error) {
                    let toaster = $('#toaster');

                    if (toaster.length != 0) {
                        callToaster("success", result.successTitle, result.successMessage);
                    }

                    let editLink = $('<a>')
                        .html('<i class="icon fas fa-edit"></i>')
                        .attr('href', result.editLink)
                        .addClass('d-inline mr-2');

                    let destroyLink = $('<a>')
                        .html('<i class="far fa-trash-alt"></i>')
                        .attr('data-item-id', id)
                        .attr('href', result.destroyLink)
                        .addClass('destroy');

                    link.closest('tr').removeClass('deleted');
                    link.closest('tr').find('td.status').find('a').attr('href', result.updateStatusLink).find('i').removeClass('disabled');
                    link.closest('tr').find('td.actions').hide().html('').append(editLink).append(destroyLink).fadeIn();
                }
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $('body').on('click', '.delete', function (e) {
        e.preventDefault();
        let link = $(this);
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: link.attr('href'),
            data: {
                "_method": "delete"
            },
            dataType: "json",
            success: function (result) {
                if (!result.error) {
                    let toaster = $('#toaster');

                    if (toaster.length != 0) {
                        callToaster("success", result.successTitle, result.successMessage);
                    }

                    link.closest('tr').fadeOut();
                }
            },
            error: function (jqXHR, Exception) {

            }
        });
    });

    /*$('body').on('click', '.delete', function(e) {
        e.preventDefault();
        let link = $(this);
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: link.attr('href'),
            data: {
                "_token": csrf_token,
                "_method": "delete"
            },
            dataType: "json",
            success: function(result) {
                if (!result.error) {
                    let toaster = $('#toaster');
                    if(toaster.length != 0) {
                        callToaster("success", result.successTitle, result.successMessage);
                        link.closest('tr').fadeOut();
                    }
                }
            },
            error: function(jqXHR, Exception) {

            }
        });
    });*/

    $('body').on('click', '.updStatus', function (e) {
        e.preventDefault();
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        let link = $(this);
        $.ajax({
            type: "POST",
            url: link.attr('href'),
            data: {"_token": csrf_token},
            dataType: "json",
            success: function (result) {
                $('#stat_' + link.data('item-id')).fadeOut('slow', function () {
                    $('#stat_' + link.data('item-id')).removeClass().addClass(result.class).attr('title', result.attr_title).fadeIn();
                });
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $('body').on('click', '.toggle-blocked-status', function (e) {
        e.preventDefault();
        let link = $(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: link.attr('href'),
            data: {
                "item": link.data('item-id')
            },
            dataType: "json",
            success: function (result) {
                $('#stat_' + link.data('item-id')).fadeOut('slow', function () {
                    $('#stat_' + link.data('item-id')).removeClass().addClass(result.class).attr('title', result.attr_title).fadeIn();
                });
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $('body').on('click', '.toggle-premium-status', function (e) {
        e.preventDefault();
        let link = $(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: link.attr('href'),
            data: {
                "item": link.data('item-id')
            },
            dataType: "json",
            success: function (result) {
                $('#prem_' + link.data('item-id')).fadeOut('slow', function () {
                    $('#prem_' + link.data('item-id')).removeClass().addClass(result.class).attr('title', result.attr_title).fadeIn();
                });
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $('body').on('click', '.toggle-basic-status', function (e) {
        e.preventDefault();
        let link = $(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: link.attr('href'),
            data: {
                "item": link.data('item-id')
            },
            dataType: "json",
            success: function (result) {
                $('#basic_' + link.data('item-id')).fadeOut('slow', function () {
                    $('#basic_' + link.data('item-id')).removeClass().addClass(result.class).attr('title', result.attr_title).fadeIn();
                });
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $(document).delegate('.cancel-registration', 'click', function (e) {
        e.preventDefault();
        let event_id = $(this).data('event-id');
        $.ajax({
            type: "POST",
            url: $(this).data('href'),
            data: {
                "_token": "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (result) {
                if (!result.error) {
                    getUsers(event_id);
                } else {

                }
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $(document).on('click', '.toggle-mainpage', function (e) {
        e.preventDefault();
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        let link = $(this);
        $.ajax({
            type: "POST",
            url: link.attr('href'),
            data: {"_token": csrf_token},
            dataType: "json",
            success: function (result) {
                $('#mainpage_stat_' + link.data('item-id')).fadeOut('slow', function () {
                    $('#mainpage_stat_' + link.data('item-id')).removeClass().addClass(result.class).attr('title', result.attr_title).fadeIn();
                });
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });

    $(document).on('click', '.toggle-approved', function (e) {
        e.preventDefault();
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        let link = $(this);
        $.ajax({
            type: "POST",
            url: link.attr('href'),
            data: {"_token": csrf_token},
            dataType: "json",
            success: function (result) {
                $('#approved_stat_' + link.data('item-id')).fadeOut('slow', function () {
                    $('#approved_stat_' + link.data('item-id')).removeClass().addClass(result.class).attr('title', result.attr_title).fadeIn();
                });
            },
            error: function (jqXHR, Exception) {
                console.log(jqXHR);
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>
