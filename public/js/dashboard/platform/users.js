$(document).ready(function () {

    $('#save-close').on('click', function () {
        // Здесь можно добавить логику для закрытия формы или перехода на другую страницу
        $('#redirect').prop('checked', true);

        $('#users_form').submit(); // Сабмит формы
    });

    $('#save').on('click', function () {
        // Здесь можно добавить логику для сохранения данных без закрытия
        $('#users_form').submit(); // Сабмит формы
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
