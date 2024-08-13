const path = window.location.pathname;
const string  = path.split("/").pop();

var usersRole;

if(string=='teachers')
{
    usersRole = 'teacher';
}
else
{
    usersRole = 'user';
}

var user;

var role;

var departmentsIds = [];

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
    function getUser() {
        var deferred = $.Deferred();

        $.ajax({
            url: "/dashboard/users/you",
            dataType: "json",
            type: "get",
            success: function(response) {
                if (response.success) {
                    user = response.data.you;
                    console.log(user);
                    userId = response.data.you.id;
                    role = user.roles[0].slug;
                    console.log('role = ' + role);
                    const departments = user.departments;
                    departmentsIds.push(...departments.map(department => department.id));
                    deferred.resolve(); // Сообщаем, что функция завершена
                } else {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                    deferred.reject(); // Сообщаем об ошибке
                }
            },
            error: function() {
                $.notify("Произошла ошибка при выборе года", "error");
                deferred.reject(); // Сообщаем об ошибке
            }
        });

        return deferred.promise();
    }


    $.when(getUser()).done(function() {
        users();
    });
});

function users(page=1)
{
    let data = {
        roles:[usersRole],
        page:page
    };
    if(role==='teacher' || role==='employee')
    {
        const additionalData = {
            selected_departments:departmentsIds
        };
        data = $.extend(data,additionalData);
    }
    $.ajax({
        url: "/dashboard/users/get-paginate",
        data:data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                const pagination = response.data.users;
                const users = pagination.data;
                console.log(users);
                const usersList = $("#users_list");
                usersList.html($("#user_tmpl").tmpl(users));
                updateUserPagination(pagination);

            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function openWorks(id) {
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
                const userWorksModal = new bootstrap.Modal(document.getElementById('user_works_modal'));
                userWorksModal.show();
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при редактировании пользователя", "error");
        }
    });
}

function searchUsers(page=1) {
    let data = $("#search_users_form").serialize();
    data = serializeRemoveNull(data);
    let additionalData = '';
    if(role==='admin')
    {
        const selectedYears = getArrayFromLocalStorage('selected_years');
        const selectedDepartments = getArrayFromLocalStorage('selected_departments');
        const selectedFaculties = getArrayFromLocalStorage('selected_faculties');
        additionalData = {
            selected_years: selectedYears,
            selected_departments: selectedDepartments,
            selected_faculties:selectedFaculties
        };
    }
    else
    {
        additionalData = {
            selected_departments:departmentsIds
        };
    }
    additionalData['role'] = usersRole;
    additionalData['page'] = page;
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
    $("#group_input").val('');
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

function updateUserPagination(pagination) {
    const totalItems = pagination.total;
    const displayedPages = pagination.links.length - 2; //Без Previous и Next
    $("#users_count").text(totalItems);
    $("#users_pagination").pagination({
        items:  totalItems,
        itemsOnPage: pagination.per_page,
        currentPage: pagination.current_page, // Установка текущей страницы в начало после добавления новых элементов
        displayedPages: displayedPages,
        cssStyle: '',
        prevText: '<span aria-hidden="true"><img src="/images/Chevron_Left.svg" alt=""></span>',
        nextText: '<span aria-hidden="true"><img src="/images/Chevron_Right.svg" alt=""></span>',
        onPageClick: function(pageNumber) {
            searchUsers(pageNumber);
        }
    });
}



