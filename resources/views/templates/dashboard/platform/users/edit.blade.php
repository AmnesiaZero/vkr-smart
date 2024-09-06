@extends('layouts.dashboard.platform')

@section('content')
    <div class="list">
        <div class="list-header">
            <h2 class="block-title">Редактирование пользователя: {{ $user->name }}</h2>
        </div>
        <form id="formContent" action="{{ route('users.update', $user->id) }}" data-action-index="{{ route('users.index') }}" method="POST">
            {{ csrf_field() }}
            <div class="post">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="name">ФИО пользователя</label>
                            <input id="name" type="text" name="name" value="{{ $user->name }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="text" name="email" value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="login">Логин</label>
                            <input id="login" type="text" name="login" value="{{ $user->login }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="organization_id">Организация</label>
                            <select id="organization_id" name="organization_id" class="form-control">
                                <option value="">-- Выберите --</option>
                                @isset($organizations)
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" @if($user->organization_id == $organization->id) selected @endif>{{ $organization->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Подтвердите пароль</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="role">Тип учетной записи</label>
                            <select id="role" name="role" class="form-control">
                                <option value="">-- Выберите --</option>
                                @isset($roles)
                                    @foreach($roles as $role)
                                        <option value="{{ $role->slug }}" @if($user->role_slug == $role->slug) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="post">Должность</label>
                            <input id="post" type="text" name="post" value="{{ $user->post }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Аватар</label>
                            <div class="input-group">
                                <input id="avatar" type="text" name="avatar" value="{{ $user->avatar }}" class="form-control" placeholder="Выберите изображение" aria-label="Выберите изображение" aria-describedby="button-select-image">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-select-image">Выбрать</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_leading" type="checkbox" name="is_leading" value="1" class="custom-control-input" @if($user->is_leading == 1) checked @endif>
                                <label for="is_leading" class="custom-control-label" style="font-size: 14px; font-weight: normal">Ведущий мероприятий</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_lector" type="checkbox" name="is_lector" value="1" class="custom-control-input" @if($user->is_lector == 1) checked @endif>
                                <label for="is_lector" class="custom-control-label" style="font-size: 14px; font-weight: normal">Лектор</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_approved" type="checkbox" name="is_approved" value="1" class="custom-control-input" @if($user->is_approved == 1) checked @endif>
                                <label for="is_approved" class="custom-control-label" style="font-size: 14px; font-weight: normal">Пользователь одобрен</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input id="is_blocked" type="checkbox" name="is_blocked" value="1" class="custom-control-input" @if($user->is_blocked == 1) checked @endif>
                                <label for="is_blocked" class="custom-control-label" style="font-size: 14px; font-weight: normal">Пользователь заблокирован</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="info">Информация о пользователе</label>
                            <textarea id="info" name="info" rows="7" class="form-control">{{ $user->info }}</textarea>
                        </div>
                    </div>
                    @if($user->role_slug != 'student')
                        <div class="col-12 my-5">
                        <table class="table">
                            <thead>
                            <tr class="thead-dark">
                                <th colspan="4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Книги пользователя</h5>
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
                            @if(isset($userBooks))
                                @foreach($userBooks as $book)
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
                                        Нет изданий, связанных с данным пользователем
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if(isset($books))
                            {!! $books->appends(request()->input())->links() !!}
                        @endif
                    </div>
                    @endif
                    <div>
                        <div class="form-group">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                        </div>
                    </div>
                    @if($user->role_slug == 'registrator')
                        <div class="col-12">
                            <h3 class="mb-4">Авторизация по IP</h3>
                            <div class="collection_resources list-body">
                                <table class="table table-responsive table-ip-ranges">
                                    <thead class="thead-light">
                                        <tr>
                                            <th colspan="6">
                                                <div class="d-flex" style="justify-content: space-between; align-items: center">
                                                    <span>IP-адреса</span>
                                                    <button type="button" data-toggle="modal" data-target="#addIPModal" class="btn btn-sm btn-danger">
                                                        Добавить IP
                                                    </button>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="col-title">
                                            <th>
                                                Диапазон IP-адресов
                                            </th>
                                            <th class="text-center">
                                                Действия
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($ip_ranges) && count($ip_ranges) > 0)
                                            @foreach($ip_ranges as $ip)
                                                @include('templates.' . config('settings.dashboard_theme') . '.pages.users.inc.ip-row', array(
                                                    'ip'=>$ip,
                                                ))
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    IP-адреса не заданы
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </form>
        <div class="modal fade" id="addIPModal" tabindex="-1" aria-labelledby="addIPModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addIPModalLabel">Диапазоны IP для авторизации</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addIPForm" action="" method="POST">
                            <div class="error"></div>
                            <div class="form-row">
                                <div class="col-md-6 col-12">
                                    <input type="text" name="ip_left" class="form-control" placeholder="IP от..." />
                                </div>
                                <div class="col-md-6 col-12">
                                    <input type="text" name="ip_right" class="form-control" placeholder="IP до..." />
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button" data-form="addIPForm" class="btn btn-primary add-ip">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button id="save-close" class="btn btn-primary">Сохранить и закрыть</button>
            <button id="save" class="btn btn-primary">Сохранить</button>
            <button id="close" class="btn btn-secondary">Отмена</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ secure_asset('/plugins/ckfinder/ckfinder.js') }}"></script>
    <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
    <script src="{{ secure_asset('/dashboards/sleek/js/cke_init.js') }}"></script>
    <script>
        $('#button-select-image').on('click', function() {
            selectFileWithCKFinder('avatar');
        });

        $('button.add-ip').on('click', function(e) {
            e.preventDefault();
            let form = $('#' + $(this).data('form'));
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (response) {
                    if (!response.error) {
                        $('#addIPModal').modal('hide');
                        callToaster('success', response.successTitle, response.successMessage);
                        $('.table-ip-ranges tbody').append(
                            '<tr>' +
                            '<td class="ip-ranges font-weight-normal">' +
                            response.data.ip_left + ' &mdash; ' + response.data.ip_right +
                            '</td>' +
                            '<td class="actions text-center">' +
                            '<a href="/dashboard/users/ip/delete/'+response.data.id+'" data-item-id="'+response.data.id+'" class="delete-ip d-inline"><i class="icon far fa-trash-alt"></i></a>' +
                            '</td>' +
                            '</tr>'
                        ).trigger('refresh');
                    } else {
                        if (response.errorType === 'overlap') {
                            if (response.left) {
                                $('input[name="ip_left"]').css('border-color', 'red');
                            }

                            if (response.right) {
                                $('input[name="ip_right"]').css('border-color', 'red');
                            }

                            $('div.error').text('Один из указанных адресов уже занят и не может быть зарезервирован.')
                        }
                    }
                },
                error: function (jqXHR, Exception) {
                    console.log(jqXHR);
                }
            })
        })

        $(document).on('click', 'a.delete-ip', function(e) {
            e.preventDefault();
            let link = $(this);
            let id = link.data('item-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: link.attr('href'),
                method: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    if (!response.error) {
                        callToaster('success', response.successTitle, response.successMessage);
                        link.closest('tr').fadeOut();
                    }
                },
                error: function (jqXHR, Exception) {

                }
            })
        })

        $(document).delegate('#booksList .pagination a', 'click', function (e) {
            e.preventDefault();
            let page = $(this).text();
            searchBooks(page);
        });

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

        $('#modalAddBooks').on('shown.bs.modal', function(event) {
            searchBooks();
        });

        $(document).delegate('.filter-books', 'click', function() {
            searchBooks();
        })

        $(document).delegate('.add-book', 'click', function () {
            let btn = $(this);
            let book_id = btn.data('book-id');
            let user_id = $('input[name="id"]').val();

            let books = [
                {
                    'book_id': book_id,
                    'user_id': user_id,
                }
            ];

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/users/add-books',
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
                    'user_id': $('input[name="id"]').val(),
                });
            })
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/users/add-books',
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
            let user_id = $('input[name="id"]').val();
            let link = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                url: '/dashboard/users/delete-book',
                data: {
                    'book': book_id,
                    'user_id': user_id,
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
