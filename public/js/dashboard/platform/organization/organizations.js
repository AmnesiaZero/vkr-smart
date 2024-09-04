var mainPageUrl = '/dashboard/organizations';

$(document).ready(function () {
    $('#save-close').on('click', function() {
        // Здесь можно добавить логику для закрытия формы или перехода на другую страницу
        $('#redirect').prop('checked', true);

        $('#organization_form').submit(); // Сабмит формы
    });

    $('#save').on('click', function() {
        // Здесь можно добавить логику для сохранения данных без закрытия
        $('#organization_form').submit(); // Сабмит формы
    });

    $('#close').on('click', function() {
        // Здесь можно добавить логику для отмены, например, переход на другую страницу
        window.location.href = '/dashboard/platform/organizations'; // Перенаправление на главную страницу
    });

    $('.js-example-basic-single').select2();

});


function updateBasic(id)
{
    const data = {
        id:id
    };
    $.ajax({
        url: "/dashboard/organizations/update/basic",
        data:data,
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success)
            {
                const organization = response.data.organization;
                $("#basic_status_" + id).replaceWith($("#basic_status_tmpl").tmpl(organization));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при обновлении статуса организации", "error");
        }
    });
}




function openUpdateDepartmentModal(id)
{
    const data = {
        id:id
    };
    $.ajax({
        url: "/dashboard/organizations/find",
        dataType: "json",
        type: "GET",
        data: data,
        success: function (response) {
            if (response.success) {
                const department = response.data.department;
                $("#tmpl_container").html($("#update_department_tmpl").tmpl(department));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function (response) {
            $.notify("Ошибка при обновлении кафедры", "error");
        }
    });
}

function updateDepartment(id)
{
    let data = $("#department_update").serialize();
    let additionalData = {
        id: id,
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/organizations/update",
        dataType: "json",
        type: "post",
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const department = response.data.department;
                $("#department_" + id).replaceWith($("#department_tmpl").tmpl(department));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function (response) {
            $.notify("Ошибка при обновлении кафедры", "error");
        }
    });
}

function departmentInfo(id)
{
    const data = {
        id:id
    };
    $.ajax({
        url: "/dashboard/organizations/find",
        data:data,
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success) {
                const department = response.data.department;
                $("#tmpl_container").html($("#department_info_tmpl").tmpl(department));
                const modalElement = new bootstrap.Modal(document.getElementById('department_info'));
                modalElement.show();
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при загрузке подразделений", "error");
        }
    });
}

function searchDepartments(page=1)
{
    let data = $("#search_departments_form").serialize();
    const organizationId = $("#organizations_list").val();  // ID вашего select
    const additionalData = {
        page:page,
        organization_id:organizationId
    };
    data +='&' + $.param(additionalData);
    data = serializeRemoveNull(data);
    $.ajax({
        url: "/dashboard/organizations/search",
        data:data,
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.departments;
                updateOrganizationsPagination(pagination);
                const departments = pagination.data;
                $("#departments_list").html($("#department_tmpl").tmpl(departments));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при загрузке подразделений", "error");
        }
    });
}

function resetSearch()
{
    $("#default_organization").prop('selected',true);
    $("#name").val('');
    organizations();
}

function updateOrganizationsPagination(pagination)
{
    const totalItems = pagination.total;
    const displayedPages = pagination.links.length - 2; //Без Previous и Next
    $("#departments_pagination").pagination({
        items:  totalItems,
        itemsOnPage: pagination.per_page,
        currentPage: pagination.current_page, // Установка текущей страницы в начало после добавления новых элементов
        displayedPages: displayedPages,
        cssStyle: '',
        prevText: '<span class="page-link"> <i class="fa-solid fa-angle-left" aria-hidden="true"></i> </span>',
        nextText: '<span class="page-link"  rel="next"> <i class="fa-solid fa-angle-right" aria-hidden="true"></i> </span>',
        onPageClick: function(pageNumber) {
            searchDepartments(pageNumber);
        }
    });
}

function deleteDepartment(id)
{
    if(confirm('Вы действительно хотите удалить данное подразделение?'))
    {
        const data = {
            id:id
        };
        $.ajax({
            url: "/dashboard/organizations/delete",
            dataType: "json",
            data: data,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $("#department_" + id).remove();
                    $.notify(response.data.title + ":" + response.data.message, "success");
                }
                else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при выборе года", "error");
            }
        });

    }
}


$('#button-select-image').on('click', function () {
    selectFileWithCKFinder('logo');
});

$(document).on('focus', '.date', function() {
    $(this).mask('00.00.0000', {placeholder: "__.__.____"});
});
// jQuery(function(){
//     jQuery('#date_timepicker_start').datetimepicker({
//         lang: 'ru',
//         format:'Y/m/d',
//         scrollMonth: false,
//         onShow:function( ct ){
//             this.setOptions({
//                 maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
//             })
//         },
//         timepicker:false
//     });
//     jQuery('#date_timepicker_end').datetimepicker({
//         lang: 'ru',
//         format:'Y/m/d',
//         scrollMonth: false,
//         onShow:function( ct ){
//             this.setOptions({
//                 minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false
//             })
//         },
//         timepicker:false
//     });
// });

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

$(document).ready(function () {
    $('#button-select-image').on('click', function() {
        $('#logo_load').click();
    });

    $('#logo_load').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $('#logo').val(fileName);
    });
});
