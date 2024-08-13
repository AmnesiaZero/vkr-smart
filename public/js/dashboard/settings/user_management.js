$(document).ready(function () {
    localStorage.setItem('selected_years', '');
    localStorage.setItem('selected_departments', '');
    users();
    $(".fancytree-title").on('click', function () {
        addBadge($(this));
    })
    $(".clicked").on('click', function () {
        deleteTreeElement($(this));
    })
})


function users() {
    const roles = ['user']; //по дефолту выбрана роль студента
    const data = {
        roles: roles,
        page:1
    };
    $.ajax({
        url: "/dashboard/users/get-paginate",
        dataType: "json",
        type: "GET",
        data: data,
        success: function (response) {
            const pagination = response.data.users;
            const users = pagination.data;
            const usersList = $("#users_list");
            usersList.html($("#user_tmpl").tmpl(users));
            updateUserPagination(pagination);
        },
        error: function (response) {
            $.notify(response.data.title + ":" + response.data.message, "error");
        }
    });
}


function searchUsers(page= 1) {
    let data = $("#search_users").serialize();
    data = serializeRemoveNull(data);
    const selectedYears = getArrayFromLocalStorage('selected_years');
    const selectedDepartments = getArrayFromLocalStorage('selected_departments');

    const additionalData = {
        selected_years: selectedYears,
        selected_departments: selectedDepartments,
        page:page
    };

    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/users/search",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.users;
                const users = pagination.data;
                updateUserPagination(pagination);
                $("#users_list").html($("#user_tmpl").tmpl(users));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}


function openWorks(id)
{
    const data = {
        id: id
    };
    $.ajax({
        url: "/dashboard/users/find",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const works = response.data.user.works;
                $("#works_list").html($("#work_tmpl").tmpl(works));
                openModal('user_works_modal');

            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function openUpdateUserCanvas(id) {
    const data = {
        id: id
    };
    $.ajax({
        url: "/dashboard/users/find",
        data: data,
        type: "GET",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const user = response.data.user;
                $("#canvas_body").html($("#off_canvas_user").tmpl(user));
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}











