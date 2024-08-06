var userId;

$(document).ready(function () {
    const path = window.location.pathname;
    userId = path.split("/").pop(); // Получаем последний сегмент URL

    $('#change_avatar_button').on('click', function() {
        $('#avatar_input').click(); // Открываем диалог выбора файла
    });

    $('#avatar_input').on('change', function() {
        const file = this.files[0];
        if (file) {
            const userId = localStorage.getItem('user_id');
            const formData = new FormData();
            formData.append('id', userId);
            formData.append('avatar', file);
            $.ajax({
                url: '/dashboard/users/update', // URL к вашему серверному скрипту
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false, // Обязательно установить false для передачи данных как FormData
                processData: false, // Обязательно установить false для передачи данных как FormData
                success: function (response) {
                    if (response.success) {
                        let avatarPath = response.data.user.avatar_path;
                        $("#user_avatar").attr('src','/' + avatarPath);
                    } else {
                        $.notify(response.data.title + ":" + response.data.message, "error");
                    }
                },
                error: function () {
                    $.notify("Произошла ошибка при загрузке файла", "error");
                }
            });
        }
    });
});




function updatePersonalInfo()
{
    let data = $("#personal_form").serialize();
    const additionalData = {
        id: userId
    };
    data+= '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/users/update",
        dataType: "json",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const user = response.data.user;
                $("#about_content").html($("#about_tmpl").tmpl(user));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе факультета", "error");
        }
    });
}

function resetPassword()
{
    let data = $("#reset_password_form").serialize();
    const additionalData = {
        id: userId
    };
    data+= '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/users/update",
        dataType: "json",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                $.notify("Пароль был успешно изменен","success");
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе факультета", "error");
        }
    });
}


