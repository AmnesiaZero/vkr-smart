var userId;

var achievementId;

$(document).ready(function () {
    const path = window.location.pathname;
    userId = path.split("/").pop(); // Получаем последний сегмент URL

    $("#add_file_form").on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы
        const formData = new FormData(this);
        formData.append('achievement_id',achievementId);
        formData.append('user_id',userId);
        formData.append('record_type_id',1);
        $.ajax({
            url: "/dashboard/portfolios/achievements/records/create",
            data:formData,
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
                    $('#add_file_form').modal('hide'); // Закрываем модальное окно
                }
                else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при редактировании пользователя", "error");
            }
        });
    });

    $("#add_work_form").on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы
        const formData = new FormData(this);
        formData.append('achievement_id',achievementId);
        formData.append('user_id',userId);
        formData.append('record_type_id',1);
        $.ajax({
            url: "/dashboard/portfolios/achievements/records/create",
            data:formData,
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
                    $('#add_work_form').modal('hide'); // Закрываем модальное окно

                }
                else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при редактировании пользователя", "error");
            }
        });
    });

    achievements();
});


function achievements()
{
    const data = {
        user_id:userId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/get",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievements = response.data.achievements;
                printAchievements(achievements);
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function printAchievements(achievements)
{
    $("#achievements_list").empty();
    let index = 1;
    achievements.forEach(achievement => {
        achievement.index = index;
        $("#achievements_list").append($("#achievement_tmpl").tmpl(achievement));
        achievementRecords(achievement.id);
        index++;
    });
}

function achievementRecords(achievementId)
{
    const data = {
        achievement_id:achievementId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/records/get",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievementsRecords = response.data.achievements_records;
                achievementsRecords.forEach(achievementRecord => {
                    printAchievementRecord(achievementRecord);
                });
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function addAchievement() {
    // Валидация обязательных полей
    if ($("#add_achievement_form")[0].checkValidity()) {
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
                    if (typeof index == 'undefined' || index === '') {
                        index = 1;
                    }
                    console.log('index = ' + index);
                    achievement.index = index;
                    achievementsList.append($("#achievement_tmpl").tmpl(achievement));

                    // Закрытие модального окна
                    $('#add_achievement_modal').modal('hide'); // Закрываем модальное окно
                } else {
                    $.notify(response.data.title + ": " + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при редактировании пользователя", "error");
            }
        });
    } else {
        // Если форма невалидна, покажите сообщение
        $.notify("Пожалуйста, заполните все обязательные поля.", "error");
    }
}

function openUpdateAchievementModal()
{
    const data = {
        id:achievementId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/find",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievement = response.data.achievement;
                $("#tmpl_container").html($("#update_achievement_modal_tmpl").tmpl(achievement));

                $('.selectpicker').selectpicker();

                const modal = new bootstrap.Modal(document.getElementById('update_achievement_modal'));
                modal.show();
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function updateAchievement() {
    // Проверяем заполнены ли все обязательные поля
    const name = $('input[name="name"]').val();
    const achievementModeId = $('select[name="achievement_mode_id"]').val();
    const educationalLevel = $('select[name="educational_level"]').val();
    const description = $('textarea[name="description"]').val();
    const recordDate = $('input[name="record_date"]').val();
    const accessLevel = $('select[name="access_level"]').val();

    if (!name || !achievementModeId || !educationalLevel || !description || !recordDate || !accessLevel) {
        $.notify("Пожалуйста, заполните все обязательные поля.", "error");
        return; // Прерываем выполнение функции, если есть незаполненные поля
    }

    console.log('achievement id = ' + achievementId);
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
                closeTmplModal('update_achievement_modal'); // Закрыть модальное окно после успешного обновления
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}


function openInfoBox(id)
{
    // $("#info_box").fadeToggle(100);
    achievementId = id;
}

function deleteAchievement()
{
   if(confirm('Вы уверены,что хотите удалить достижение'))
   {
      const data = {
           id:achievementId
       };
       $.ajax({
           url: "/dashboard/portfolios/achievements/delete",
           data:data,
           type: "POST",
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           dataType: "json",
           success: function (response) {
               if (response.success) {
                   $("#achievement_" + achievementId).remove();
                   $.notify(response.data.title + ":" + response.data.message, "success");
               }
               else {
                   $.notify(response.data.title + ":" + response.data.message, "error");
               }
           },
           error: function () {
               $.notify("Произошла ошибка при редактировании пользователя", "error");
           }
       });
   }
}

function addRecord(recordTypeId)
{
    let form = '';
    let modal = '';
    const additionalData = {
        achievement_id:achievementId,
        user_id:userId,
        record_type_id:recordTypeId
    };
    switch (recordTypeId)
    {
        case 2:
            form = $("#add_link_form");
            modal = $("#add_link_modal");
            break;
        case 3:
            form = $("#add_text_form");
            modal = $("#add_text_modal");
            break;
    }
    let data = form.serialize();
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/achievements/records/create",
        data:data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievementRecord = response.data.achievement_record;
                printAchievementRecord(achievementRecord);
                modal.modal('hide'); // Закрываем модальное окно
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}


function printAchievementRecord(achievementRecord)
{
    const categoryId = achievementRecord.type.category_id;
    const achievementId = achievementRecord.achievement_id;
    let column = false;
    console.log('category id = ' + categoryId);
    switch (categoryId)
    {
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
    if(!column)
    {
        $.notify('У записи указана неправильная категория', "error");
        return;
    }
    column.append($("#record_tmpl").tmpl(achievementRecord));
}

function searchAchievements()
{
    let data = $("#search_achievements_form").serialize();
    const additionalData = {
       user_id:userId
    };
    data+= '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/achievements/search",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievements = response.data.achievements;
                printAchievements(achievements);
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}



function openTextRecord(recordId)
{
    const data = {
        id:recordId
    };
    $.ajax({
        url: "/dashboard/portfolios/achievements/records/find",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const record = response.data.achievement_record;
                $("#tmpl_container").html($("#text_tmpl").tmpl(record));
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}


function resetSearch()
{
    $("#default_achievement").prop('selected',true);
    $("#achievement_name").val('');
    achievements();
}

function resetAchievementSearch()
{
    $("#achievement_mode_id").selectpicker('val', '');
    $("#achievement_name").val('');
    achievements();
}

function openPortfolio()
{
    window.location.href = '/dashboard/portfolios/' + userId;
}

function deleteAchievementRecord(id)
{
    if(confirm('Вы уверены,что хотите удалить достижение'))
    {
        const data = {
            id:id
        };
        $.ajax({
            url: "/dashboard/portfolios/achievements/records/delete",
            data:data,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $("#achievement_record_" + id).remove();
                    $.notify(response.data.title + ":" + response.data.message, "success");
                }
                else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function () {
                $.notify("Произошла ошибка при редактировании пользователя", "error");
            }
        });
    }
}

function openAddWorksModal()
{
    openModal('add_work_modal');
    works();
}




function works(page=1)
{
    const data = {
        page:page,
        user_type:2,
        user_id:userId
    };
    $.ajax({
        url: "/dashboard/works/search",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const pagination = response.data.works;
                const links = pagination.links;
                //Обрезаем из массива линков Previos и Next
                links.shift();
                links.pop();
                pagination.links = links;
                const works = pagination.data;
                const worksTable = $("#works_table");
                worksTable.html($("#work_tmpl").tmpl(works));
                const currentPage = pagination.current_page;
                const perPage = pagination.per_page;
                const totalItems = pagination.total;
                const totalPages = pagination.links.length;
                updateWorksPagination(currentPage,totalItems,totalPages,perPage);
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function openOverView()
{
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
            }
            else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

