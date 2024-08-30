var mainPageUrl = '/dashboard/organizations/departments';

$(document).ready(function () {
    departments();

    $('#organizations_list').change(function () {
        const organizationId = $(this).val();
        const data = {
            organization_id: organizationId
        };
        console.log('изменение');
        years(data);
    });

    $('#years_list').change(function () {
        const yearId = $(this).val();
        const data = {
            year_id: yearId
        };
        console.log('изменение');
        faculties(data);
    });

    $('.js-example-basic-single').select2();

});



function departments(page=1) {
    const data = {
        paginate:1,
        page:page
    };
    $.ajax({
        url: "/dashboard/organizations/departments/get",
        data:data,
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.departments;
                updateDepartmentsPagination(pagination);
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

function years(organizationId)
{
    const data = {
       organization_id: organizationId
    };
    $.ajax({
        url: "/dashboard/organizations/years/get",
        data:data,
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success) {
                const years = response.data.years;
                const yearsList = $("#years_list");
                yearsList.html($("#year_tmpl").tmpl(years));
                yearsList.prepend('<option value="" selected>Выберите.......</option>');
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при загрузке годов", "error");
        }
    });
}

function faculties(data) {
    console.log('faculties');
    $.ajax({
        url: "/dashboard/organizations/faculties/get",
        dataType: "json",
        data: data,
        type: "get",
        success: function (response) {
            if (response.success) {
                const faculties = response.data.faculties;
                const facultiesList = $("#faculties_list");
                facultiesList.html($("#faculty_tmpl").tmpl(faculties));
                facultiesList.prepend('<option value="" selected>Выберите.......</option>');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при загрузке факультета", "error");
        }
    });
}

function createDepartment()
{
    let data = $("#create_department_form").serialize();
    $.ajax({
        url: "/dashboard/organizations/departments/create",
        dataType: "json",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const department = response.data.department;
                $("#departments_list").append($("#department_tmpl").tmpl(department));
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



function openUpdateDepartmentModal(id)
{
    const data = {
        id:id
    };
    $.ajax({
        url: "/dashboard/organizations/departments/find",
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
        url: "/dashboard/organizations/departments/update",
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
        url: "/dashboard/organizations/departments/find",
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
        url: "/dashboard/organizations/departments/search",
        data:data,
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.departments;
                updateDepartmentsPagination(pagination);
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
    departments();
}

function updateDepartmentsPagination(pagination)
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
        url: "/dashboard/organizations/departments/delete",
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
