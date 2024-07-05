
// Заполнение selectpicker с датами
$(document).ready(function() {
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



