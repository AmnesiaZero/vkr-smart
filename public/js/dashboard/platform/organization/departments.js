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
