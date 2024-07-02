
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
