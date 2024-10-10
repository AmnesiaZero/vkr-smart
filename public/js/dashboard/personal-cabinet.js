var userId;

$(document).ready(function () {

    function getUser() {
        var deferred = $.Deferred();

        $.ajax({
            url: "/dashboard/users/you",
            dataType: "json",
            type: "get",
            success: function(response) {
                if (response.success) {
                    userId = response.data.you.id;
                    deferred.resolve(); // Сообщаем, что функция завершена
                } else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                    deferred.reject(); // Сообщаем об ошибке
                }
            },
            error: function() {
                $.notify("Произошла ошибка при выборе года", "error");
                deferred.reject(); // Сообщаем об ошибке
            }
        });

        return deferred.promise();
    }


    $.when(getUser()).done(function() {
        educations();
        careers();
    });

    $('#change_avatar_button').on('click', function() {
        $('#avatar_input').click(); // Открываем диалог выбора файла
    });

    $('#avatar_input').on('change', function() {
        const file = this.files[0];

        if (file) {
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


function getResourses(id) {
    $.ajax({
        url: "/achivements-actions",
        type: "post",
        data: "action=getResources&id=" + id + "&v=" + (new Date()).getTime(),
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#resourses-" + id).html(response.data)
            } else {
                $.notify(response.message, "error");
            }
        }
    });
}
function getResource(id) {
    $.ajax({
        url: "/achivements-actions",
        type: "post",
        data: "action=getResource&id=" + id + "&v=" + (new Date()).getTime(),
        dataType: "json",
        success: function (response) {
            if (response.success) {
                var data = response.data;
                if (data.record_type_id == 3) {
                    $("#informationModalData").html(data.content)
                    $("#informationModal").modal("show");
                }
                if (data.record_type_id == 2) {
                    window.open(data.content, "_blank");
                }
                if (data.record_type_id == 1) {
                    $("#downloadFileForm input[name='id']").val(id);
                    $("#downloadFileForm").submit();
                }
            } else {
                $.notify(response.message, "error");
            }
        }
    });
}

function educations()
{
    const data = {
        user_id:userId
    };
    $.ajax({
        url: "/dashboard/portfolios/educations/get",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const educations = response.data.educations;
                $("#educations_list").html($("#education_tmpl").tmpl(educations));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function addEducation()
{
    let data = $("#add_education_form").serialize();
    const additionalData = {
        user_id:userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/educations/create",
        data:data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const education = response.data.education;
                $("#educations_list").append($("#education_tmpl").tmpl(education));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function deleteEducation(educationId)
{
    const data = {
        id:educationId
    };
    $.ajax({
        url: "/dashboard/portfolios/educations/delete",
        data:data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#education_" + educationId).remove();
                $.notify(response.data.title + ":" + response.data.message, "success");
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function getEducationForm(educationFormId)
{
    switch (educationFormId)
    {
        case 0:
        case '0':
            return 'Очная';
        case 1:
        case '1':
            return 'Заочная'
        case 2:
        case '2':
            return  'Дистанционная';
    }
}

function careers()
{
    const data = {
        user_id:userId
    };
    $.ajax({
        url: "/dashboard/portfolios/careers/get",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const careers = response.data.careers;
                $("#careers_list").html($("#career_tmpl").tmpl(careers));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении карьер", "error");
        }
    });
}

function addCareer()
{
    let data = $("#add_career_form").serialize();
    const additionalData = {
        user_id:userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/careers/create",
        data:data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const career = response.data.career;
                $("#careers_list").append($("#career_tmpl").tmpl(career));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function deleteCareer(careerId)
{
    const data = {
        id:careerId
    };
    $.ajax({
        url: "/dashboard/portfolios/careers/delete",
        data:data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#career_" + careerId).remove();
                $.notify(response.data.title + ":" + response.data.message, "success");
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}






