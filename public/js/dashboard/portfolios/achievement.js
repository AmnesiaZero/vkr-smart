var userId;

$(document).ready(function () {
    const path = window.location.pathname;
    userId = path.split("/").pop(); // Получаем последний сегмент URL
});


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
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const achievement = response.data.achievement;
                $("#achievements_list").append($("#achievement_tmpl").tmpl(achievement));
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
