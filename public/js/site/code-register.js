$(document).ready(function () {
    console.log('Страница загрузилась');
    findCode();
    years();
    $('#years_list').change(function () {
        const yearId = $(this).val();
        const data = {
            year_id: yearId
        };
        faculties(data, 'faculties_list');
    });


    $('#faculties_list').change(function () {
        const facultyId = $(this).val();
        const data = {
            faculty_id: facultyId
        };
        departments(data, 'departments_list');
    });

    $('#departments_list').change(function () {
        const departmentId = $(this).val();
        const data = {
            department_id: departmentId
        };
        programsSpecialties(data);
    });
});

function findCode()
{
     const cookieId = $("#code_id").val();
     console.log('cookie id = ' + cookieId);
     const data = {
         id:cookieId
     };
    $.ajax({
        url: "/dashboard/invite-codes/find",
        dataType: "json",
        type: "get",
        data: data,
        success: function (response) {
           const code = response.data.code;
            console.log(code);
            const organizationId = code.organization_id;
            localStorage.setItem('organization_id',organizationId);
        },
        error: function (response) {
            $.notify(response.data.title + ":" + response.data.message, "error");
        }
    });

}


function years() {

    const organizationId = localStorage.getItem('organization_id');
    const data = {
        organization_id:organizationId
    };
    $.ajax({
        url: "/dashboard/organizations/years/get",
        dataType: "json",
        data: data,
        success: function (response) {
            const years = response.data.years;
            const yearsList = $("#years_list");
            yearsList.empty();
            yearsList.selectpicker('destroy');
            yearsList.html($("#year_tmpl").tmpl(years));
            yearsList.selectpicker('render');
        },
        error: function () {
            $.notify("Произошла ошибка при выборе года", "error");
        }
    });
}

function faculties(data, htmlId) {
    $.ajax({
        url: "/dashboard/organizations/faculties/get",
        dataType: "json",
        data: data,
        type: "get",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const faculties = response.data.faculties;
                const facultiesList = $("#" + htmlId);
                facultiesList.empty();
                facultiesList.selectpicker('destroy');
                facultiesList.html($("#faculty_tmpl").tmpl(faculties));
                facultiesList.selectpicker('render');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе факультета", "error");
        }
    });
}

function departments(data) {
    $.ajax({
        url: "/dashboard/organizations/departments/get",
        dataType: "json",
        data: data,
        type: "get",
        success: function (response) {
            if (response.success) {
                const departments = response.data.departments
                console.log(departments);
                let departmentsList = '';
                if ($("#departments_list").length > 0) {
                    departmentsList = $("#departments_list");
                    departmentsList.empty();
                    departmentsList.selectpicker('destroy');
                    departmentsList.html($("#department_list_tmpl").tmpl(departments));
                    departmentsList.selectpicker('render');
                } else {
                    departmentsList = $("#departments_list_multiple");
                    departmentsList.empty();
                    departmentsList.selectpicker('destroy');
                    departmentsList.html($("#department_list_tmpl").tmpl(departments));
                    departmentsList.selectpicker('render');
                }
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе кафедры", "error");
        }
    });
}

function programsSpecialties(data) {
    $.ajax({
        url: "/dashboard/organizations/departments/program-specialties",
        dataType: "json",
        data: data,
        type: "GET",
        success: function (response) {
            if (response.success) {
                const programSpecialties = response.data.program_specialties;
                const programsSpecialtiesList = $("#programs_specialties_list");
                programsSpecialtiesList.empty();
                programsSpecialtiesList.selectpicker('destroy');
                programsSpecialtiesList.html($("#program_specialty_tmpl").tmpl(programSpecialties));
                programsSpecialtiesList.selectpicker('render');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе специальности", "error");
        }
    });

}


function registration() {
    let password = $('#password').val();
    let repassword = $('#repassword').val();

    if (password !== repassword) {
        $.notify("Введенные пароли не совпадают", "error");
        return false;
    }

    const data = $("#registration_form").serialize();
    $.ajax({
        url: "/registration/by-code",
        dataType: "json",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                $("#welcome-message").empty()
                $("#code_registration").empty()
                const user = response.data.user;
                console.log('user = ' + user);
                $("#success_registration").html($("#success_registration_tmpl").tmpl(user));
                const password = data.password;
                console.log('password - ' + password);
                $("#reg-password").text(password);
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при регистрации", "error");
        }
    });

}

