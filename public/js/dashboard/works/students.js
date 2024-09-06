


function workInfoStudent(activeTabpanel)
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id: workId,
    };
    $.ajax({
        url: "/dashboard/works/find",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#about_work").html($("#work_info_student_tmpl").tmpl(work)).appendTo('');
                comments();
                const modalElement = new bootstrap.Modal(document.getElementById('work_info_student'));
                modalElement.show();
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

function addComment()
{
    const workId = localStorage.getItem('work_id');
    const receiverId = localStorage.getItem('user_id');
    let data = $("#add_comment_form").serialize();
    const additionalData = {
        work_id: workId,
        receiver_id:receiverId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/works/comments/create",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const comment = response.data.comment;
                $("#comments_list").append($("#comment_tmpl").tmpl(comment));
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

function comments()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        work_id: workId,
    };
    $.ajax({
        url: "/dashboard/works/comments/get",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const comments = response.data.comments;
                $("#comments_list").html($("#comment_tmpl").tmpl(comments));
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

function deleteComment(id)
{
    const data = {
        id:id
    };
    $.ajax({
        url: "/dashboard/works/comments/delete",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                $("#comment_" + id).remove();
                $.notify(response.data.title + ":" + response.data.message, "success");
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

function declineWork()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id:workId,
        work_status:2
    };
    updateWorkCore(data,workId);
}

function putWorkOnWait()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id:workId,
        work_status:0
    };
    updateWorkCore(data,workId);
}

$(function () {
    $('input[name="daterange"]').daterangepicker({
        autoUpdateInput: false,  // Отключаем автоматическое обновление поля
        "locale": {
            "format": "DD.MM.YYYY",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            "firstDay": 1
        },
        opens: 'left'
    }, function (start, end, label) {
        // Обновляем значение поля при выборе диапазона
        $('input[name="daterange"]').val(start.format('DD.MM.YYYY') + ' - ' + end.format('DD.MM.YYYY'));
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
});
