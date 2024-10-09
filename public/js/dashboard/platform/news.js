$(document).ready(function () {

    $('#save-close').on('click', function() {
        // Здесь можно добавить логику для закрытия формы или перехода на другую страницу
        $('#redirect').prop('checked', true);

        $('#news_form').submit(); // Сабмит формы
    });

    $('#save').on('click', function() {
        // Здесь можно добавить логику для сохранения данных без закрытия
        $('#news_form').submit(); // Сабмит формы
    });

    $('#close').on('click', function() {
        // Здесь можно добавить логику для отмены, например, переход на другую страницу
        window.location.href = '/dashboard/news'; // Перенаправление на главную страницу
    });

    $('.js-example-basic-single').select2();

});
