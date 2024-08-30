@extends('templates.dashboard.' . config('settings.dashboard_theme') . '.index')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование организации: {{ $item->name }}</h2>
        </div>
        <form id="formContent" action="{{ route('dashboard.organizations.update', $item->id) }}" data-action-index="{{ route('dashboard.organizations.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-8">
                    <div class="post">
                        <div class="form-group">
                            <label for="title">Название организации</label>
                            <input id="title" type="text" name="name" value="{{ $item->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Является связанной для организации:</label>
                            <select id="parent_id" name="parent_id" class="form-control">
                                <option value="">--Выберите--</option>
                                @if(isset($parents) && !empty($parents))
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" @if($parent->id == $item->parent_id) selected @endif>{{ $parent->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="logo">Логотип</label>
                            <div class="input-group">
                                <input id="logo" type="text" name="logo" value="{{ $item->logo }}" class="form-control" placeholder="Выберите изображение" aria-label="Выберите изображение" aria-describedby="button-select-image">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-select-image">Загрузить</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Адрес</label>
                            <input id="address" type="text" name="address" value="{{ $item->address }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input id="phone" type="text" name="phone" value="{{ $item->phone }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="website">Сайт</label>
                            <input id="website" type="text" name="website" value="{{ $item->website }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="text" name="email" value="{{ $item->email }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="info">Дополнительная информация</label>
                            <textarea id="info" name="info" rows="4" class="form-control editor">{{ $item->info }}</textarea>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="date_start">Дата начала доступа</label>--}}
{{--                            <div class="input-group">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <span id="date-start" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>--}}
{{--                                </div>--}}
{{--                                <input id="date_timepicker_start" type="text" name="date_start" value="@if($item->date_start){!! date('Y/m/d', $item->date_start) !!}@endif" aria-describedby="date-start" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="date_end">Дата окончания доступа</label>--}}
{{--                            <div class="input-group">--}}
{{--                                <div class="input-group-prepend">--}}
{{--                                    <span id="date-end" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>--}}
{{--                                </div>--}}
{{--                                <input id="date_timepicker_end" type="text" name="date_end" value="@if($item->date_end){!! date('Y/m/d', $item->date_end) !!}@endif" aria-describedby="date-end" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_head">Голованя организация</label>--}}
{{--                            <select id="is_head" name="is_head" class="form-control">--}}
{{--                                <option value="0" @if(!$item->is_head) selected @endif>Нет</option>--}}
{{--                                <option value="1" @if($item->is_head) selected @endif>Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_premium">Доступ Premium (все издания доступны)</label>--}}
{{--                            <select id="is_premium" name="is_premium" class="form-control">--}}
{{--                                <option value="0" @if(!$item->is_premium) selected @endif>Нет</option>--}}
{{--                                <option value="1" @if($item->is_premium) selected @endif>Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_testing">Тестовый доступ</label>--}}
{{--                            <select id="is_testing" name="is_testing" class="form-control">--}}
{{--                                <option value="0" @if(!$item->is_testing) selected @endif>Нет</option>--}}
{{--                                <option value="1" @if($item->is_testing) selected @endif>Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_demo">Демо-организация (для презентаций и технических работ)</label>--}}
{{--                            <select name="is_demo" class="form-control" id="published">--}}
{{--                                <option value="0" @if(!$item->is_demo) selected @endif>Нет</option>--}}
{{--                                <option value="1" @if($item->is_demo) selected @endif>Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="is_blocked">Организация заблокирована</label>--}}
{{--                            <select id="is_blocked" name="is_blocked" class="form-control">--}}
{{--                                <option value="0" @if(!$item->is_blocked) selected @endif>Нет</option>--}}
{{--                                <option value="1" @if($item->is_blocked) selected @endif>Да</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" value="{{ $item->id }}">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="is_blocked">Организация заблокирована</label>
                        <select id="is_blocked" name="is_blocked" class="form-control">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_start">Дата начала доступа</label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span id="date-start" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="date_timepicker_start" type="text" name="date_start" value="{!! DateHelper::format('Y/m/d', $item->date_start) !!}" aria-describedby="date-start" class="form-control" autocomplete="off">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Укажите дату в формате <strong>yyyy/mm/dd</strong></small>
                    </div>
                    <div class="form-group">
                        <label for="date_end">Дата окончания доступа</label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span id="date-end" class="input-group-text" style="font-size: 16px;"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input id="date_timepicker_end" type="text" name="date_end" value="{!! DateHelper::format('Y/m/d', $item->date_end) !!}" aria-describedby="date-end" class="form-control" autocomplete="off">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">Укажите дату в формате <strong>yyyy/mm/dd</strong></small>
                    </div>
                    <h3 class="mb-3">Доп. параметры</h3>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_head" type="checkbox" name="is_head" value="1" class="custom-control-input" @if($item->is_head) checked @endif>
                            <label for="is_head" class="custom-control-label" style="font-size: 14px; font-weight: normal">Головная организация</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_basic" type="checkbox" name="is_basic" value="1" class="custom-control-input" @if($item->is_basic) checked @endif>
                            <label for="is_basic" class="custom-control-label" style="font-size: 14px; font-weight: normal">Базовый доступ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_premium" type="checkbox" name="is_premium" value="1" class="custom-control-input" @if($item->is_premium) checked @endif>
                            <label for="is_premium" class="custom-control-label" style="font-size: 14px; font-weight: normal">Доступ Premium (все издания доступны)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_testing" type="checkbox" name="is_testing" value="1" class="custom-control-input" @if($item->is_testing) checked @endif>
                            <label for="is_testing" class="custom-control-label" style="font-size: 14px; font-weight: normal">Тестовый доступ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="is_demo" type="checkbox" name="is_demo" value="1" class="custom-control-input" @if($item->is_demo) checked @endif>
                            <label for="is_demo" class="custom-control-label" style="font-size: 14px; font-weight: normal">Демо-организация (для презентаций и технических работ)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="member_transfer_network" type="checkbox" name="member_transfer_network" value="1" class="custom-control-input" @if($item->member_transfer_network) checked @endif>
                            <label for="member_transfer_network" class="custom-control-label" style="font-size: 14px; font-weight: normal">Участник сети трансферов</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input id="show_catalog" type="checkbox" name="show_catalog" value="1" class="custom-control-input" @if($item->show_catalog) checked @endif>
                            <label for="show_catalog" class="custom-control-label" style="font-size: 14px; font-weight: normal">Показывать в каталоге</label>
                        </div>
                    </div>
                    <h3 class="mb-3">Структура организации</h3>
                    <div class="d-flex justify-content-between">
                        <button type="button" data-toggle="modal" data-target="#modalDepartments" data-organization-id="{{ $item->id }}" class="btn btn-info" style="width: 48%;"><i class="fas fa-network-wired"></i> Отделения</button>
                        <button type="button" data-toggle="modal" data-target="#modalDepartments" data-organization-id="{{ $item->id }}" class="btn btn-info" style="width: 48%;"><i class="fas fa-users"></i> Группы</button>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <table class="table">
                        <thead>
                        <tr class="thead-dark">
                            <th colspan="4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Подключенные коллекции</h5>
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalAddCollections"><i class="fas fa-plus"></i> Добавить</button>
                                </div>
                            </th>
                        </tr>
                        <tr style="background: #f1f1f1">
                            <th scope="col" style="padding: 5px 0.75rem">Название коллекции</th>
                            <th scope="col" class="text-center" style="width: 220px; padding: 5px 0.75rem">Дата начала доступа</th>
                            <th scope="col" class="text-center" style="width: 220px; padding: 5px 0.75rem">Дата окончания доступа</th>
                            <th scope="col" class="text-center" style="width: 135px; padding: 5px 0.75rem">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($collections))
                            @foreach($collections as $collection)
                                <tr>
                                    <td style="vertical-align: middle">
                                        {{ $collection->title }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        {{ $collection->date_start }}
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        {{ $collection->date_end }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger delete-collection" data-collection-id="{{ $collection->collection_id }}"><i class="fas fa-times"></i> Удалить</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
                                    Данная организация не имеет доступа ни к одной из коллекций
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @if(isset($collections))
                        {!! $collections->appends(request()->input())->links() !!}
                    @endif
                </div>

                <div class="col-12 my-5">
                    <table class="table">
                        <thead>
                        <tr class="thead-dark">
                            <th colspan="4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Книги организации</h5>
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalAddBooks"><i class="fas fa-plus"></i> Добавить</button>
                                </div>
                            </th>
                        </tr>
                        <tr style="background: #f1f1f1">
                            <th scope="col" style="padding: 5px 0.75rem">Название книги</th>
                            <th scope="col" class="text-center" style="width: 135px; padding: 5px 0.75rem">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($organizationBooks))
                            @foreach($organizationBooks as $book)
                                <tr>
                                    <td style="vertical-align: middle">
                                        {{ $book->title }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger delete-book" data-book-id="{{ $book->book_id }}"><i class="fas fa-times"></i> Удалить</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">
                                    Нет изданий, связанных с данной организацией
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    @if(isset($collections))
                        {!! $collections->appends(request()->input())->links() !!}
                    @endif
                </div>
            </div>
        </form>
        <div class="form-group">
            <button id="save-close" class="btn btn-primary">Сохранить и закрыть</button>
            <button id="save" class="btn btn-primary">Сохранить</button>
            <button id="close" class="btn btn-secondary">Отмена</button>
        </div>
    </div>
    @include('templates.dashboard.' . config('settings.dashboard_theme') . '.pages.organizations.inc.modal_departments')
    @include('templates.dashboard.' . config('settings.dashboard_theme') . '.pages.organizations.inc.modalAddCollections')
    @include('templates.dashboard.' . config('settings.dashboard_theme') . '.pages.organizations.inc.modalAddBooks')
    {{--    @include('templates.dashboard.' . config('settings.dashboard_theme') . '.pages.organizations.inc.modal_groups')--}}
@endsection

@section('scripts')
    <script src="{{ secure_asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ secure_asset('/plugins/jquery/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ secure_asset('/plugins/editors/CKEditor/v5/ckeditor.js') }}"></script>
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script>CKFinder.config({connectorPath: '/ckfinder/connector'});</script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script>
        $('#button-select-image').on('click', function () {
            selectFileWithCKFinder('logo');
        });

        $(document).on('focus', '.date', function() {
            $(this).mask('00.00.0000', {placeholder: "__.__.____"});
        });
        jQuery(function(){
            jQuery('#date_timepicker_start').datetimepicker({
                lang: 'ru',
                format:'Y/m/d',
                scrollMonth: false,
                onShow:function( ct ){
                    this.setOptions({
                        maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
                    })
                },
                timepicker:false
            });
            jQuery('#date_timepicker_end').datetimepicker({
                lang: 'ru',
                format:'Y/m/d',
                scrollMonth: false,
                onShow:function( ct ){
                    this.setOptions({
                        minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
                    })
                },
                timepicker:false
            });
        });

        $('#modalDepartments').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let organizationID = button.data('organization-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/departments',
                data: '',
                dataType: 'json',
                success: function(result) {
                    console.log(result);
                },
                error: function(jqXHR, Exception) {
                    console.log(jqXHR);
                }
            });
            // let modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            // modal.find('.modal-body input').val(recipient)
        });

        $(document).delegate('#collectionsList .pagination a', 'click', function (e) {
            e.preventDefault();
            let page = $(this).text();
            searchCollections(page);
        });

        $(document).delegate('#booksList .pagination a', 'click', function (e) {
            e.preventDefault();
            let page = $(this).text();
            searchBooks(page);
        });

        let searchCollections = function (page = 1) {
            let filterForm = $('#filterForm');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/dashboard/organizations/search-collections",
                data: filterForm.serialize() + '&page=' + page,
                dataType: "json",
                success: function (result) {
                    // let itemsPage = 20;
                    // let viewMode = 'list';
                    // $('#num_of_publications').text(result.info.total)
                    $('#collectionsList').html(result.view);
                    // $('.items-per-page button.collection-' + itemsPage).removeClass('btn-outline-secondary').addClass('btn-info');
                    // $('.viewMode-' + viewMode).addClass('active');
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            });
        }

        let searchBooks = function (page = 1) {
            let filterForm = $('#filterFormBooks');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/dashboard/organizations/search-books",
                data: filterForm.serialize() + '&page=' + page,
                dataType: "json",
                success: function (result) {
                    $('#booksList').html(result.view);
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            });
        }

        $('#modalAddCollections').on('shown.bs.modal', function (event) {
            searchCollections();
        });

        $('#modalAddBooks').on('shown.bs.modal', function(event) {
            searchBooks();
        })

        $(document).delegate('.add-collection', 'click', function () {
            let btn = $(this);
            let collection_id = btn.data('collection-id');
            let organization_id = $('input[name="id"]').val();
            let startDate = $(btn).closest('tr').find('input[name="subscription_start_date"]').val();
            let endDate = $(btn).closest('tr').find('input[name="subscription_end_date"]').val();

            let collections = [
                {
                    'collection_id': collection_id,
                    'organization_id': organization_id,
                    'date_start': startDate,
                    'date_end': endDate
                }
            ];

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/add-collections',
                data: {
                    'collections': collections,
                },
                dataType: 'json',
                success: function (result) {
                    if (!result.error) {
                        btn.removeClass('btn-success').addClass('btn-outline-secondary').attr('disabled', 'disabled').html('<i class="fas fa-check"></i> Добавлена');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-danger').attr('disabled', 'disabled').html('<i class="fas fa-exclamation-triangle"></i> Ошибка');
                    }

                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            })
        });

        $(document).delegate('.add-collections', 'click', function () {
            let btn = $(this);

            let collections = [];

            $('input.collections:checked').each((i, elem) => {
                let startDate = $(elem).closest('tr').find('input[name="subscription_start_date"]').val();
                let endDate = $(elem).closest('tr').find('input[name="subscription_end_date"]').val();
                collections.push({
                    'collection_id': $(elem).val(),
                    'organization_id': $('input[name="id"]').val(),
                    'date_start': startDate,
                    'date_end': endDate
                });
            })

            // let collections = $('input.collections:checked').map(function (i, el) {
            //     let startDate = $(el).closest('tr').find('input[name="subscription_start_date"]').val();
            //     let endDate = $(el).closest('tr').find('input[name="subscription_end_date"]').val();
            //     return [$(el).val(), startDate, endDate];
            // }).get();
            // let organization_id = $('input[name="id"]').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/add-collections',
                data: {
                    'collections': collections,
                    // 'organization_id': organization_id
                },
                dataType: 'json',
                success: function (result) {
                    if (!result.error) {
                        let toaster = $('#toaster');
                        let redirectUrl = window.location.href;
                        if (toaster.length > 0) {
                            callToaster("success", result.successTitle, result.successMessage, redirectUrl);
                        }
                    } else {
                        btn.removeClass('btn-primary').addClass('btn-danger').attr('disabled', 'disabled').html('<i class="fas fa-exclamation-triangle"></i> Ошибка');
                    }
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            })
        });

        $(document).delegate('.delete-collection', 'click', function (e) {
            e.preventDefault();
            let collection_id = $(this).data('collection-id');
            let organization_id = $('input[name="id"]').val();
            let link = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/delete-collection',
                data: {
                    'collection': collection_id,
                    'organization_id': organization_id,
                },
                dataType: 'json',
                success: function (result) {
                    if (!result.error) {
                        let toaster = $('#toaster');
                        if (toaster.length != 0) {
                            callToaster("success", result.successTitle, result.successMessage);
                            link.closest('tr').fadeOut();
                        }
                    }
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            });
        });

        $(document).delegate('.filter-books', 'click', function() {
            searchBooks();
        })

        $(document).delegate('.add-book', 'click', function () {
            let btn = $(this);
            let book_id = btn.data('book-id');
            let organization_id = $('input[name="id"]').val();

            let books = [
                {
                    'book_id': book_id,
                    'organization_id': organization_id,
                }
            ];

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/add-books',
                data: {
                    'books': books,
                },
                dataType: 'json',
                success: function (result) {
                    if (!result.error) {
                        btn.removeClass('btn-success').addClass('btn-outline-secondary').attr('disabled', 'disabled').html('<i class="fas fa-check"></i> Добавлена');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-danger').attr('disabled', 'disabled').html('<i class="fas fa-exclamation-triangle"></i> Ошибка');
                    }

                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            })
        });

        $(document).delegate('.add-books', 'click', function () {
            let btn = $(this);

            let books = [];

            $('input.books:checked').each((i, elem) => {
                books.push({
                    'book_id': $(elem).val(),
                    'organization_id': $('input[name="id"]').val(),
                });
            })
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/add-books',
                data: {
                    'books': books,
                },
                dataType: 'json',
                success: function (result) {
                    if (!result.error) {
                        let toaster = $('#toaster');
                        let redirectUrl = window.location.href;
                        if (toaster.length > 0) {
                            callToaster("success", result.successTitle, result.successMessage, redirectUrl);
                        }
                    } else {
                        btn.removeClass('btn-primary').addClass('btn-danger').attr('disabled', 'disabled').html('<i class="fas fa-exclamation-triangle"></i> Ошибка');
                    }
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            })
        });

        $(document).delegate('.delete-book', 'click', function (e) {
            e.preventDefault();
            let book_id = $(this).data('book-id');
            let organization_id = $('input[name="id"]').val();
            let link = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/organizations/delete-book',
                data: {
                    'book': book_id,
                    'organization_id': organization_id,
                },
                dataType: 'json',
                success: function (result) {
                    if (!result.error) {
                        let toaster = $('#toaster');
                        if (toaster.length != 0) {
                            callToaster("success", result.successTitle, result.successMessage);
                            link.closest('tr').fadeOut();
                        }
                    }
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            });
        });
    </script>
@endsection
