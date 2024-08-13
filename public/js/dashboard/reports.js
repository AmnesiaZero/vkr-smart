$(document).ready(function () {
    $('.js-example-basic-single').select2();
    $(".fancytree-title").on('click', function () {
        addElement($(this));
    })
    $(".clicked").on('click', function () {
        deleteTreeElement($(this));
    });
    getReport();
});
$('.btn-info-box').click(function () {
    $("#info_box").fadeToggle(100);
});

// Открытие и закрытие ветвей
$(".fancytree-node").click(function() {
    $(this).next("ul").toggle();
});

const addElement = function (clickedElement) {
    console.log(clickedElement);
    const fullId = clickedElement.attr('id');
    let data = '';
    if (fullId.includes('year_')) {
        const match = fullId.match(/\d+/); // Находим все последовательности цифр в строке
        const id = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        data = {
            year_id:id
        };
    }
    else if (fullId.includes('faculty_')) {
        const match = fullId.match(/\d+/); // Находим все последовательности цифр в строке
        const id = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        data = {
            faculty_id:id
        };
    }
    else if (fullId.includes('department_')) {
        const match = fullId.match(/\d+/); // Находим все последовательности цифр в строке
        const id = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        data = {
            department_id:id
        };
    }
    getReport(data);

}

function getReport(data={})
{
    $.ajax({
        url: "/dashboard/reports/get",
        data: data,
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
            $.notify("Произошла ошибка при получении отчета", "error");
        }
    });
}


function getAchievementsCount(users) {
    let achievementsCount = 0;
    users.forEach(user => {
        const achievements = user.achievements;
        if (achievements) {
            achievementsCount += achievements.length;
        }
    });
    return achievementsCount;
}

function achievementsRecordsCount(users) {
    let achievementsRecordsCount = 0;
    users.forEach(user => {
        const achievements = user.achievements;
        if (achievements) {
            achievements.forEach(achievement => {
                const records = achievement.records;
                if (records) {
                    achievementsRecordsCount += records.length;
                }
            });
        }
    });
    return achievementsRecordsCount;
}

function getWorksCount(users) {
    let worksCount = 0;
    users.forEach(user => {
        const works = user.works;
        if (works) {
            worksCount += works.length;
        }
    });
    return worksCount;
}

function getRoleName(roleId) {
    switch (roleId) {
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
