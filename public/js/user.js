function updateUser(id) {
    // Проверяем, прошла ли форма валидацию
    let form = $("#update_user_form");

    if (form[0].checkValidity() === false) {
        form[0].reportValidity(); // Показать сообщение браузера о валидации
        return; // Останавливаем выполнение, если валидация не пройдена
    }

    // Если валидация успешна, сериализуем данные
    let data = form.serialize();
    let additionalData = { id: id };
    data += '&' + $.param(additionalData);

    // Выполняем основное действие
    updateUserCore(id, data);

    // Программно закрываем модалку
    $('#update_user').modal('hide');
    console.log(123)
}

function blockUser(id) {
    const data = {
        id: id,
        is_active: 0
    }
    updateUserCore(id, data);
}

function unblockUser(id) {
    const data = {
        id: id,
        is_active: 1
    }
    updateUserCore(id, data);
}


function updateUserCore(id, data) {
    $.ajax({
        url: "/dashboard/users/update",
        data: data,
        type: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const user = response.data.user;
                const userHtml = $("#user_" + id);
                const updatedContent = $("#user_tmpl").tmpl(user);
                userHtml.replaceWith(updatedContent);
                $.notify("Пользователь успешно изменен", "success");
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }

        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function resetUserPassword(email) {
    const data = {
        email: email,
    }
    $.ajax({
        url: "/mail/reset-password",
        data: data,
        type: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                $.notify(response.data.title + ":" + response.data.message, "success");
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }

        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

