$(document).ready(function () {
    $('.js-example-basic-single').select2();
    $(".fancytree-title").on('click', function () {
        addBadge($(this));
    })
    $(".clicked").on('click', function () {
        deleteTreeElement($(this));
    });
    localStorage.setItem('selected_years', '');
    localStorage.setItem('selected_faculties', '');
    localStorage.setItem('selected_departments', '');
    getReport();
});
$('.btn-info-box').click(function () {
    $("#info_box").fadeToggle(100);
});


function getReport()
{
    const selectedYears = getArrayFromLocalStorage('selected_years');
    const selectedDepartments = getArrayFromLocalStorage('selected_departments');
    const selectedFaculties = getArrayFromLocalStorage('selected_faculties');
    const data = {
        selected_years: selectedYears,
        selected_departments: selectedDepartments,
        selected_faculties:selectedFaculties,
    };
    $.ajax({
        url: "/dashboard/reports/get",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#report_container").html($("#report_tmpl").tmpl(response.data));
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

function getAchievementsCount(users)
{
    let achievementsCount = 0;
    users.forEach(user => {
       const achievements = user.achievements;
       if(achievements)
       {
           achievementsCount += achievements.length;
       }
    });
    return achievementsCount;
}

function achievementsRecordsCount(users)
{
    let achievementsRecordsCount = 0;
    users.forEach(user => {
        const achievements = user.achievements;
        if(achievements)
        {
            achievements.forEach(achievement => {
                const records = achievement.records;
                if(records)
                {
                    achievementsRecordsCount+= records.length;
                }
            });
        }
    });
    return achievementsRecordsCount;
}

function getWorksCount(users)
{
    let worksCount = 0;
    users.forEach(user => {
        const works = user.works;
        if(works)
        {
            worksCount+=works.length;
        }
    });
    return worksCount;
}

function getRoleName(roleId)
{
    switch (roleId)
    {
        case 1:
            return 'Администраторы';
        case 2:
            return 'Студенты';
        case 3:
            return 'Сотрудники организации';
        case 5:
            return 'Проверяющие организации';
        case 6:
            return 'Преподаватели';
    }
}
