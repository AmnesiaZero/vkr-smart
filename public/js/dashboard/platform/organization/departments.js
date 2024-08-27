var mainPageUrl = '/dashboard/organizations/departments';

$(document).ready(function () {
    departments();
});


function departments() {
    $.ajax({
        url: "/dashboard/organizations/departments/all",
        dataType: "json",
        type: "get",
        success: function (response) {
            if (response.success) {
                const departments = response.data.departments;
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

function searchDepartments()
{

}
