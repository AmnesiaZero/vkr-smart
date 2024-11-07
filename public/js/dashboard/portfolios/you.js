var userId;

var user;

var achievementId;

$(document).ready(function () {

    $("#add_file_form").on('submit', function (e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы
        const formData = new FormData(this);
        formData.append('achievement_id', achievementId);
        formData.append('user_id', userId);
        formData.append('record_type_id', 1);


        // Проверка заполнения обязательных полей
        let isValid = true;

        $('#add_file_form [data-reqiured="true"]').each(function () {
            if(!this.val()) {
                isValid = false
            }
        });

        if(!isValid) {
            return;
        }

        $.ajax({
            url: "/dashboard/portfolios/achievements/records/create",
            data: formData,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // Не обрабатываем файлы (не превращаем в строку)
            contentType: false, // Не устанавливаем заголовок Content-Type

            success: function (response) {
                if (response.success) {
                    const achievementRecord = response.data.achievement_record;
                    printAchievementRecord(achievementRecord);

                } else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при редактировании пользователя", "error");
            }
        });
    });

    $("#add_work_form").on('submit', function (e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы
        const formData = new FormData(this);
        formData.append('achievement_id', achievementId);
        formData.append('user_id', userId);
        formData.append('record_type_id', 1);
        $.ajax({
            url: "/dashboard/portfolios/achievements/records/create",
            data: formData,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // Не обрабатываем файлы (не превращаем в строку)
            contentType: false, // Не устанавливаем заголовок Content-Type
            success: function (response) {
                if (response.success) {
                    const achievementRecord = response.data.achievement_record;
                    printAchievementRecord(achievementRecord);

                    $('#add_work_modal').modal('hide');
                } else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при редактировании пользователя", "error");
            }
        });
    });

    function getUser() {
        var deferred = $.Deferred();

        $.ajax({
            url: "/dashboard/users/you",
            dataType: "json",
            type: "get",
            success: function (response) {
                if (response.success) {
                    user = response.data.you;
                    console.log(user);
                    userId = response.data.you.id;
                    console.log('user id = ' + userId);
                    deferred.resolve(); // Сообщаем, что функция завершена
                } else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                    deferred.reject(); // Сообщаем об ошибке
                }
            },
            error: function () {
                $.notify("Произошла ошибка при выборе года", "error");
                deferred.reject(); // Сообщаем об ошибке
            }
        });

        return deferred.promise();
    }


    $.when(getUser()).done(function () {
        achievements();
    });
});

function achievements() {
    const data = {
        user_id: userId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/get",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievements = response.data.achievements;
                printAchievements(achievements);
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function printAchievements(achievements) {
    $("#achievements_list").empty();
    let index = 1;
    achievements.forEach(achievement => {
        achievement.index = index;
        $("#achievements_list").append($("#achievement_tmpl").tmpl(achievement));
        achievementRecords(achievement.id);
        index++;
    });
}

function achievementRecords(achievementId) {
    const data = {
        achievement_id: achievementId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/records/get",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievementsRecords = response.data.achievements_records;
                achievementsRecords.forEach(achievementRecord => {
                    printAchievementRecord(achievementRecord);
                });
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function addAchievement() {
    let data = $("#add_achievement_form").serialize();
    const additionalData = {
        user_id: userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/achievements/create",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievement = response.data.achievement;
                const achievementsList = $("#achievements_list");
                const lastRow = $("#achievements_list tr").last();
                let index = lastRow.find('td').first().text();
                index++;
                if (typeof index == 'undefined') {
                    index = 1;
                }
                console.log('index = ' + index);
                achievement.index = index;
                achievementsList.append($("#achievement_tmpl").tmpl(achievement));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function openUpdateAchievementModal() {
    const data = {
        id: achievementId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/find",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievement = response.data.achievement;
                $("#tmpl_container").html($("#update_achievement_modal_tmpl").tmpl(achievement));

                $('.selectpicker').selectpicker();

                let modal = new bootstrap.Modal($('#update_achievement_modal'));
                modal.show();

            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function updateAchievement() {

    // Проверка обязательных полей
    let isValid = true;

    $('#update_achievement_form [data-reqiured="true"]').each(function () {
        if(!this.val()) {
            isValid = false
        }
    });

    if(!isValid) {
        return;
    }

    let data = $("#update_achievement_form").serialize();
    const additionalData = {
        id: achievementId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/achievements/update",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievement = response.data.achievement;
                $("#achievement_" + achievementId).replaceWith($("#achievement_tmpl").tmpl(achievement));
                $.notify(response.data.title + ":" + response.data.message, "success");

                $('#update_achievement_modal').modal('hide');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function openInfoBox(id) {
    achievementId = id;
}

function deleteAchievement() {
    if (confirm('Вы уверены,что хотите удалить достижение')) {
        const data = {
            id: achievementId
        };
        $.ajax({
            url: "/dashboard/portfolios/achievements/delete",
            data: data,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#achievement_" + achievementId).next().remove();
                    $("#achievement_" + achievementId).remove();
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
}

function addRecord(recordTypeId) {
    let formId = '';
    let modalId = '';

    const additionalData = {
        achievement_id: achievementId,
        user_id: userId,
        record_type_id: recordTypeId
    };
    switch (recordTypeId) {
        case 2:
            formId = $("#add_link_form");
            modalId = $("#add_link_modal");

            $('#add_link_form [data-reqiured="true"]').each(function () {
                if(!this.val()) {
                    return;
                }
            });
            break;
        case 3:
            formId = $("#add_text_form");
            modalId = $("#add_text_modal");

            $('#add_text_form [data-reqiured="true"]').each(function () {
                if(!this.val()) {
                    return;
                }
            });
            break;
    }
    let data = formId.serialize();
    data += '&' + $.param(additionalData);

    $.ajax({
        url: "/dashboard/portfolios/achievements/records/create",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievementRecord = response.data.achievement_record;
                printAchievementRecord(achievementRecord);
                modalId.modal('hide');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}


function printAchievementRecord(achievementRecord) {
    const categoryId = achievementRecord.type.category_id;
    const achievementId = achievementRecord.achievement_id;
    let column = false;
    console.log('category id = ' + categoryId);
    switch (categoryId) {
        case 1:
            column = $("#confirm_achievements_column_" + achievementId);
            break;
        case 2:
            column = $("#reviews_column_" + achievementId);
            break;
        case 3:
            column = $("#works_column_" + achievementId);
            break;
        case 4:
            column = $("#others_column_" + achievementId);
            break;
    }
    if (!column) {
        $.notify('У записи указана неправильная категория', "error");
        return;
    }
    column.append($("#record_tmpl").tmpl(achievementRecord));
}

function searchAchievements() {
    let data = $("#search_achievements_form").serialize();
    const additionalData = {
        user_id: userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/achievements/search",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievements = response.data.achievements;
                printAchievements(achievements);
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function openTextRecord(recordId) {
    const data = {
        id: recordId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/records/find",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const record = response.data.achievement_record;
                $("#tmpl_container").html($("#text_tmpl").tmpl(record));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}


function resetSearch() {
    $("#default_achievement").prop('selected', true);
    $("#achievement_name").val('');
    achievements();
}

function openPortfolio() {
    window.location.href = '/dashboard/portfolios/' + userId;
}

function deleteAchievementRecord(id) {
    if (confirm('Вы уверены,что хотите удалить достижение')) {
        const data = {
            id: id
        };
        $.ajax({
            url: "/dashboard/portfolios/achievements/records/delete",
            data: data,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#achievement_record_" + id).remove();
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
}

function openAddWorksModal() {
    openModal('add_work_modal');
    works();
}



function works(page = 1) {
    const data = {
        page: page,
        user_id: userId
    };
    $.ajax({
        url: "/dashboard/works/get",
        type: 'GET',
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.works;
                const works = pagination.data;
                const worksTable = $("#works_table");
                worksTable.html($("#work_tmpl").tmpl(works));
                updateWorksPagination(pagination);
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function openOverView() {
    const data = {
        id: userId
    };
    $.ajax({
        url: "/dashboard/users/find",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const user = response.data.user;

                $("#tmpl_container").html($("#overview_tmpl").tmpl(user));
                const achievements = user.achievements;
                console.log('achievements');
                console.log(achievements);

                $("#overview_achievements_list").html($("#overview_achievement_tmpl").tmpl(achievements));
                const educations = user.educations;
                console.log('educations');
                console.log(educations);

                $("#overview_educations_list").html($("#overview_education_tmpl").tmpl(educations));
                const careers = user.careers;
                console.log('careers');
                console.log(careers);

                $("#overview_careers_list").html($("#overview_career_tmpl").tmpl(careers));

                const modalElement = new bootstrap.Modal(document.getElementById('overview_modal'));
                modalElement.show();
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

