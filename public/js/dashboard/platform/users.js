var usersForm = $('#users_form');

$(document).ready(function () {

    $('#save-close').on('click', function () {
        $('#redirect').prop('checked', true);

        if (usersForm[0].checkValidity()) {
            usersForm.submit();
        }
        else {
            usersForm[0].reportValidity(); // Показать сообщение об ошибке
        }
    });

    $('#save').on('click', function () {
        if (usersForm[0].checkValidity()) {
            usersForm.submit();
        }
        else {
            usersForm[0].reportValidity(); // Показать сообщение об ошибке
        }
    });

    $('#close').on('click', function () {
        // Здесь можно добавить логику для отмены, например, переход на другую страницу
        window.location.href = '/dashboard/users/index'; // Перенаправление на главную страницу
    });

    $('.js-example-basic-single').select2();


});


function updateStatus(id) {
    const data = {
        id: id
    };
    $.ajax({
        url: "/dashboard/users/update/status",
        data: data,
        dataType: "json",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const user = response.data.user;
                $("#status_" + id).replaceWith($("#status_icon_tmpl").tmpl(user));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при обновлении статуса организации", "error");
        }
    });
}
