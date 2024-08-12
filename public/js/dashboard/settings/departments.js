var userId;

$(document).ready(function () {
   getUser();
});

function saveDepartments()
{
    let data = $("#access_departments_form").serialize();
    let additionalData = {
        id: userId,
    };
    data += '&' + $.param(additionalData);
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
                $.notify("Кафедры успешно изменены","success");
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }

        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function getUser()
{
    $.ajax({
        url: "/dashboard/users/you",
        dataType: "json",
        type: "get",
        success: function(response) {
            if (response.success) {
                userId = response.data.you.id;
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Произошла ошибка при выборе года", "error");
        }
    });
}
