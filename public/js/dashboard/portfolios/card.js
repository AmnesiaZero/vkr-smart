var userId;

var achievementId;
$(document).ready(function () {
    console.log(123);
    let select = $('select[name="date_start"], select[name="date_end"], select[name="date_issue"]');
    let currentYear = new Date().getFullYear();

    for (var year = currentYear; year >= 1944; year--) {
        select.append($('<option>', {
            value: year,
            text: year
        }));
    }
    // Инициализация bootstrap-select
    select.selectpicker();


    const path = window.location.pathname;
    userId = path.split("/").pop(); // Получаем последний сегмент URL

    educations();
    careers();
});

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

function educations() {
    const data = {
        user_id: userId
    };
    $.ajax({
        url: "/dashboard/portfolios/educations/get",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const educations = response.data.educations;
                $("#educations_list").html($("#education_tmpl").tmpl(educations));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function addEducation() {
    let data = $("#add_education_form").serialize();
    const additionalData = {
        user_id: userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/educations/create",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const education = response.data.education;
                $("#educations_list").append($("#education_tmpl").tmpl(education));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function deleteEducation(educationId) {
    const data = {
        id: educationId
    };
    $.ajax({
        url: "/dashboard/portfolios/educations/delete",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#education_" + educationId).remove();
                $.notify(response.data.title + ":" + response.data.message, "success");
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function getEducationForm(educationFormId) {
    switch (educationFormId) {
        case 0:
        case '0':
            return 'Очная';
        case 1:
        case '1':
            return 'Заочная'
        case 2:
        case '2':
            return 'Дистанционная';
    }
}

function careers() {
    const data = {
        user_id: userId
    };
    $.ajax({
        url: "/dashboard/portfolios/careers/get",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const careers = response.data.careers;
                $("#careers_list").html($("#career_tmpl").tmpl(careers));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении карьер", "error");
        }
    });
}

function addCareer() {
    let data = $("#add_career_form").serialize();
    const additionalData = {
        user_id: userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/portfolios/careers/create",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const career = response.data.career;
                $("#careers_list").append($("#career_tmpl").tmpl(career));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}

function deleteCareer(careerId) {
    const data = {
        id: careerId
    };
    $.ajax({
        url: "/dashboard/portfolios/careers/delete",
        data: data,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#career_" + careerId).remove();
                $.notify(response.data.title + ":" + response.data.message, "success");
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при получении образований", "error");
        }
    });
}



