var newsForm = $("#news_form");

$(document).ready(function () {


    $('#save-close').on('click', function () {
        $('#redirect').prop('checked', true);

        if (newsForm[0].checkValidity()) {
            newsForm.submit();
        }
        else {
            newsForm[0].reportValidity(); // Показать сообщение об ошибке
        }
    });

    $('#save').on('click', function () {
        if (newsForm[0].checkValidity()) {
            newsForm.submit();
        }
        else {
            newsForm[0].reportValidity(); // Показать сообщение об ошибке
        }
    });

    $('#close').on('click', function () {
        // Здесь можно добавить логику для отмены, например, переход на другую страницу
        window.location.href = '/dashboard/news'; // Перенаправление на главную страницу
    });

    $('.js-example-basic-single').select2();

});
