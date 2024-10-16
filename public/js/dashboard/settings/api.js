function generateApiKey() {
    console.log('Вошёл в функцию открытия canvas');
    const data = $("#generate_key_form").serialize();
    $.ajax({
        url: "/dashboard/organizations/jwt/generate",
        data: data,
        type: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const secretKey = response.data.secret_key;
                $("#secret_key").val(secretKey);
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

$(document).ready(function () {
    $('#token').click(function () {
        const $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val($(this).text()).select();
        document.execCommand('copy');
        $temp.remove();
        alert('Токен скопирован в буфер обмена!');
    });
});
