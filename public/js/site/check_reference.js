function openReport() {
    const data = $("#check_form").serialize();
    $.ajax({
        url: "/dashboard/works/check-code",
        type: 'GET',
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const work = response.data.work;

                $("#report_container").html($("#report_tmpl").tmpl(work));

                const modalElement = new bootstrap.Modal(document.getElementById('report_modal'));
                modalElement.show();
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

