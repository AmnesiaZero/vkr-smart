$(document).ready(function () {
    localStorage.setItem('selected_years', '');
    localStorage.setItem('selected_faculties', '');
    localStorage.setItem('selected_departments', '');
    $(".fancytree-title").on('click', function () {
        addBadge($(this));
    })
    $(".clicked").on('click', function () {
        deleteTreeElement($(this));
    });
    users();
});

function users(page=1)
{
    const data = {
        roles:['teacher'],
        page:page
    }
    $.ajax({
        url: "/dashboard/users/get-paginate",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.users;
                const links = pagination.links;
                //Обрезаем из массива линков Previos и Next
                links.shift();
                links.pop();
                pagination.links = links;
                const users = pagination.data;
                const usersList = $("#users_list");
                usersList.html($("#user_tmpl").tmpl(users));
                const currentPage = pagination.current_page;
                const perPage = pagination.per_page;
                const totalItems = pagination.total;
                $("#users_count").text(totalItems);
                const totalPages = pagination.links.length;
                updatePagination(currentPage,totalItems,totalPages,perPage);

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

function searchUsers() {
    let data = $("#search_users_form").serialize();
    data = serializeRemoveNull(data);
    const selectedYears = getArrayFromLocalStorage('selected_years');
    const selectedDepartments = getArrayFromLocalStorage('selected_departments');
    const selectedFaculties = getArrayFromLocalStorage('selected_faculties');
    const additionalData = {
        selected_years: selectedYears,
        selected_departments: selectedDepartments,
        selected_faculties:selectedFaculties,
        roles:['teacher']
    };
    console.log(additionalData);
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/users/search",
        data: data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const users = response.data.users;
                $("#users_list").html($("#user_tmpl").tmpl(users));
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

function resetSearch()
{
    $("#name_input").val('');
    $("#email_input").val('');
    users();
}


function updateWorksCount()
{
    const worksCountString = $("#works_count").text();
    let worksCount = parseInt(worksCountString, 10);
    if (!isNaN(worksCount)) {
        worksCount += 1;
        $('#works_count').text(worksCount);
    }
}



