var mainPageUrl = '/dashboard/organizations/departments';

$(document).ready(function () {

    $('#save-close').on('click', function() {
        // Здесь можно добавить логику для закрытия формы или перехода на другую страницу
        $('#redirect').prop('checked', true);

        $('#departments_form').submit(); // Сабмит формы
    });

    $('#save').on('click', function() {
        // Здесь можно добавить логику для сохранения данных без закрытия
        $('#departments_form').submit(); // Сабмит формы
    });

    $('#close').on('click', function() {
        // Здесь можно добавить логику для отмены, например, переход на другую страницу
        window.location.href = '/dashboard/platform/organizations/departments'; // Перенаправление на главную страницу
    });

    $('.js-example-basic-single').select2();


    $('#organizations_list').change(function () {
        const organizationId = $(this).val();
        const data = {
            organization_id: organizationId
        };
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

});

function years(data) {
    console.log('faculties');
    $.ajax({
        url: "/dashboard/organizations/years/get",
        dataType: "json",
        data: data,
        type: "get",
        success: function (response) {
            if (response.success) {
                const years = response.data.years;
                const yearsList = $("#years_list");
                yearsList.html($("#year_tmpl").tmpl(years));
                yearsList.prepend('<option value="" selected>Выберите.......</option>');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе года", "error");
        }
    });
}

function faculties(data) {
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


function updateStatus(id)
{
    const data = {
        id:id
    };
    $.ajax({
        url: "/dashboard/organizations/departments/update/status",
        data:data,
        dataType: "json",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success)
            {
                const department = response.data.department;
                $("#status_" + id).replaceWith($("#status_tmpl").tmpl(department));
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



