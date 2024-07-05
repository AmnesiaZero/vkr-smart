var userId;

var achievementId;

$(document).ready(function () {
    const path = window.location.pathname;
    userId = path.split("/").pop(); // Получаем последний сегмент URL

    achievements();
});

function achievements()
{
    const data = {
        user_id:userId
    };
    $.ajax({
        url: "/dashboard/portfolio/achievements/get",
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
        url: "/dashboard/portfolio/achievements/records/get",
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

function addAchievement()
{
   let data = $("#add_achievement_form").serialize();
   const additionalData = {
       user_id:userId
   };
   data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolio/achievements/create",
        data:data,
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
                if (typeof index=='undefined')
                {
                    index = 1;
                }
                console.log('index = ' + index);
                achievement.index = index;
                achievementsList.append($("#achievement_tmpl").tmpl(achievement));
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

function openUpdateAchievementModal()
{
    const data = {
        id:achievementId
    };
    $.ajax({
        url: "/dashboard/portfolio/achievements/find",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievement = response.data.achievement;
                $("#tmpl_container").html($("#update_achievement_modal_tmpl").tmpl(achievement));
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

function updateAchievement()
{
    let data = $("#update_achievement_form").serialize();
    const additionalData = {
      id:achievementId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolio/achievements/update",
        data:data,
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

function openInfoBox(id)
{
    $("#info_box").fadeToggle(100);
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
           url: "/dashboard/portfolio/achievements/delete",
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
    let data = $("#add_link_form").serialize();
    const additionalData = {
       achievement_id:achievementId,
        user_id:userId,
        record_type_id:recordTypeId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolio/achievements/records/create",
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
    let column = false;
    console.log('category id = ' + categoryId);
    switch (categoryId)
    {
        case 1:
            column = $("#confirm_achievements_column");
            break;
        case 2:
            column = $("#reviews_column");
            break;
        case 3:
            column = $("#works_column");
            break;
        case 4:
            column = $("#others_column");
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
        url: "/dashboard/portfolio/achievements/search",
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

function resetSearch()
{
    $("#default_achievement").prop('selected',true);
    $("#achievement_name").val('');
    achievements();
}

function openPortfolio()
{
    window.location.href = '/dashboard/portfolio/' + userId;
}
