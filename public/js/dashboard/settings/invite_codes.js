$(document).ready(function () {

    loadTeachersCodes();
    loadStudentsCodes();
});
function copyInviteCode() {
    // Найдем ближайший input элемент с классом .content, относительно кнопки, на которую нажали
    var input = event.target.closest('.input-group').querySelector('.content');

    // Выделим текст в поле ввода
    input.select();
    input.setSelectionRange(0, 99999); // Для мобильных устройств

    // Скопируем текст в буфер обмена
    document.execCommand("copy");
}

// document.getElementById("copy").onclick = function () {
//     let text = document.getElementById("content").value;
//     navigator.clipboard.writeText(text);
// }

function createTeachersCodes()
{
    const teachersCodesHtml = $("#teachers_codes_list");
    if($("#teachers_empty").length==0)
    {
        console.log('Вошёл в условие');
        teachersCodesHtml.empty();
    }
    teachersCodes();
}

function createInviteCodes()
{
    const data = $("#create_invite_codes_form").serialize();
    $.ajax({
        url: "/dashboard/invite-codes/create",
        data: data,
        type: "POST",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if(response.success){
                const inviteCodes = response.data.invite_codes;
                const formDataArray = $("#create_invite_codes_form").serializeArray();
                const type = formDataArray.find(item => item.name === 'type')?.value;
                console.log('type = ' + type);
                if(type==1)
                {
                    createStudentsCodes(inviteCodes);
                }
                else{
                    createTeachersCodes(inviteCodes);
                }

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

function createStudentsCodes()
{
    const studentsCodesHtml = $("#students_codes_list");
    if($("#teachers_empty").length==0)
    {
        console.log('Вошёл в условие');
        studentsCodesHtml.empty();
    }
    studentsCodes();
}

//функция для изначальной подгрузки кодов со всеми дополнительными операциями
function loadTeachersCodes()
{
    const data = {
        type:2,
        page:1
    };
    $.ajax({
        url: "/dashboard/invite-codes/get",
        type: "GET",
        dataType: "json",
        data:data,
        success: function (response) {
            if(response.success){
                const pagination = response.data.invite_codes;
                const links = pagination.links;
                links.shift();
                links.pop();
                pagination.links = links;
                const inviteCodes = pagination.data;
                const teachersCodesList = $("#teachers_codes_list");
                if(inviteCodes.length>0)
                {
                    teachersCodesList.html($("#invite_code_tmpl").tmpl(inviteCodes));
                    $("#teachers_pages").html($("#pagination_tmpl").tmpl(pagination));
                }
                else{
                    teachersCodesList.html($("#empty_tmpl").tmpl({id:'teachers_empty'}));
                }
                updateTeachersPagination(pagination);
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

//функция для пагинации
function teachersCodes(pageNumber= 1)
{
    const data = {
        type:2,
        page:pageNumber
    };
    $.ajax({
        url: "/dashboard/invite-codes/get",
        type: "GET",
        dataType: "json",
        data:data,
        success: function (response) {
            if(response.success){
                const pagination = response.data.invite_codes;
                const inviteCodes = pagination.data;
                const teachersCodesList = $("#teachers_codes_list");
                teachersCodesList.html($("#invite_code_tmpl").tmpl(inviteCodes));
                updateTeachersPagination(pagination);
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


function updateTeachersPagination(pagination) {
    const currentPage = pagination.current_page;
    const itemsPerPage = pagination.per_page;
    const totalItems = pagination.total;
    const totalPages = pagination.links.length;

    if (totalPages > 1) {
        $("#teachers_codes_pagination").pagination({
            items: totalItems,
            itemsOnPage: itemsPerPage,
            currentPage: currentPage, // Установка текущей страницы в начало после добавления новых элементов
            displayedPages: totalPages,
            cssStyle: '',
            prevText: '<span aria-hidden="true"><img src="/images/Chevron_Left.svg" alt=""></span>',
            nextText: '<span aria-hidden="true"><img src="/images/Chevron_Right.svg" alt=""></span>',
            onPageClick: function(pageNumber, event) {
                teachersCodes(pageNumber);
            }
        });
    } else {
        // Скрыть пагинацию, если страниц всего одна
        $("#teachers_codes_pagination").hide();
    }
}

function loadStudentsCodes()
{
    const data = {
        type:1,
        page:1
    };
    $.ajax({
        url: "/dashboard/invite-codes/get",
        type: "GET",
        dataType: "json",
        data:data,
        success: function (response) {
            if(response.success){
                const pagination = response.data.invite_codes;
                const inviteCodes = pagination.data;
                const studentsCodesList = $("#students_codes_list");
                if(inviteCodes.length>0)
                {
                    studentsCodesList.html($("#invite_code_tmpl").tmpl(inviteCodes));
                    $("#students_pages").html($("#pagination_tmpl").tmpl(pagination));
                }
                else{
                    studentsCodesList.html($("#empty_tmpl").tmpl({id:'students_empty'}));
                }
                updateStudentsCodesPagination(pagination);
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
function studentsCodes(pageNumber= 1)
{
    const data = {
        type:1,
        page:pageNumber
    };
    $.ajax({
        url: "/dashboard/invite-codes/get",
        type: "GET",
        dataType: "json",
        data:data,
        success: function (response) {
            if(response.success){
                const pagination = response.data.invite_codes;
                const inviteCodes = pagination.data;
                const studentsCodesList = $("#students_codes_list");
                studentsCodesList.html($("#invite_code_tmpl").tmpl(inviteCodes));
                updateStudentsCodesPagination(pagination);
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


function updateStudentsCodesPagination(pagination) {

    const totalPages = pagination.last_page;
    if(totalPages>1)
    {
        const currentPage = pagination.current_page;
        const itemsPerPage = pagination.per_page;
        const totalItems = pagination.total;
        $("#students_codes_pagination").pagination({
            items: totalItems,
            prevText: '<span aria-hidden="true"><img src="/images/Chevron_Left.svg" alt=""></span>',
            nextText: '<span aria-hidden="true"><img src="/images/Chevron_Right.svg" alt=""></span>',
            itemsOnPage: itemsPerPage,
            currentPage: currentPage, // Установка текущей страницы в начало после добавления новых элементов
            displayedPages: totalPages,
            onPageClick: function (pageNumber, event) {
                studentsCodes(pageNumber);
            }
        });
    }
}

function downloadStudentsCodes()
{
    window.location.href = '/dashboard/invite-codes/load?type=1';
    $("#students_codes_list").html($("#empty_tmpl").tmpl({id:'students_empty'}));
    $("#students_codes_pagination").empty();
}

function downloadTeachersCodes()
{
    window.location.href = '/dashboard/invite-codes/load?type=2';
    $("#teachers_codes_list").html($("#empty_tmpl").tmpl({id:'teachers_empty'}));
    $("#teachers_codes_pagination").empty();
}









