var userId = '';

var user = '';


$(document).ready(function () {
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
        works();
    });

    $('#update_years_list').change(function () {
        const yearId = $(this).val();
        const data = {
            year_id: yearId
        };
        console.log('изменение');
        faculties(data,'update_faculties_list');
    });

    $('#update_faculties_list').change(function () {
        const facultyId = $(this).val();
        const data = {
            faculty_id: facultyId
        };
        departments(data,'update_departments_list');
    });

    $('#update_departments_list').change(function () {
        const departmentId = $(this).val();
        const data = {
            department_id: departmentId
        };
        specialties(data,'update_specialties_list');
    });

    $('#import_years_list').change(function () {
        const yearId = $(this).val();
        const data = {
            year_id: yearId
        };
        console.log('изменение');
        faculties(data,'import_faculties_list');
    });

    $('#import_faculties_list').change(function () {
        const facultyId = $(this).val();
        const data = {
            faculty_id: facultyId
        };
        departments(data,'import_departments_list');
    });

    $('#import_departments_list').change(function () {
        const departmentId = $(this).val();
        const data = {
            department_id: departmentId
        };
        specialties(data,'import_specialties_list');
    });

    $(".fancytree-title").on('click', function () {
        addBadge($(this));
    })
    $(".clicked").on('click', function () {
        deleteTreeElement($(this));
    })


    $('#upload_button').on('click', function() {
        $('#file_input').click(); // Открываем диалог выбора файла
    });

    $('#upload_certificate_button').on('click', function() {
        $('#certificate_input').click(); // Открываем диалог выбора файла
    });
    $("#addWorkForm").on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        // Создаем объект FormData и добавляем в него данные формы
        const formData = new FormData(this);
        const yearId = user.year_id;
        const facultyId = user.faculty_id;
        const student = user.name;
        const additionalData = {
            user_id:userId,
            year_id:yearId,
            faculty_id:facultyId,
            user_type:2,
            student:student
        };
        console.log(additionalData);
        for (const key in additionalData) {
            if (additionalData.hasOwnProperty(key)) {
                formData.append(key, additionalData[key]);
            }
        }
        $.ajax({
            url: '/dashboard/works/create',
            type: 'POST',
            data: formData,
            processData: false, // Не обрабатываем файлы (не превращаем в строку)
            contentType: false, // Не устанавливаем заголовок Content-Type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success)
                {
                    const work = response.data.work;
                    $("#works_table").append($("#work_tmpl").tmpl(work));
                    updateWorksCount();
                }
                else
                {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function() {
                $.notify("Ошибка при добавлении работы. Обратитесь к системному администратору", "error");

            }
        });
    });

    $("#import_work_form").on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        // Создаем объект FormData и добавляем в него данные формы
        const formData = new FormData(this);

        $.ajax({
            url: '/dashboard/works/import',
            type: 'POST',
            data: formData,
            processData: false, // Не обрабатываем файлы (не превращаем в строку)
            contentType: false, // Не устанавливаем заголовок Content-Type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success)
                {
                    $.notify(response.data.title + ":" + response.data.message, "success");
                    works();
                }
                else
                {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function() {
                $.notify("Ошибка при добавлении работы. Обратитесь к системному администратору", "error");

            }
        });
    });

    $('#file_input').on('change', function() {
        const file = this.files[0];
        if (file) {
            const workId = localStorage.getItem('work_id');
            const formData = new FormData();
            formData.append('id', workId);
            formData.append('work_file', file);
            $.ajax({
                url: '/dashboard/works/upload', // URL к вашему серверному скрипту
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false, // Обязательно установить false для передачи данных как FormData
                processData: false, // Обязательно установить false для передачи данных как FormData
                success: function (response) {
                    if (response.success) {
                        $.notify(response.data.title + ":" + response.data.message, "success");
                    } else {
                        $.notify(response.data.title + ":" + response.data.message, "error");
                    }
                },
                error: function () {
                    $.notify("Произошла ошибка при загрузке файла", "error");
                }
            });
        }
    });

    $('#certificate_input').on('change', function() {
        const file = this.files[0];
        if (file) {
            const workId = localStorage.getItem('work_id');
            const formData = new FormData();
            formData.append('id', workId);
            formData.append('certificate_file', file);
            $.ajax({
                url: '/dashboard/works/certificates/upload', // URL к вашему серверному скрипту
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false, // Обязательно установить false для передачи данных как FormData
                processData: false, // Обязательно установить false для передачи данных как FormData
                success: function (response) {
                    if (response.success) {
                        $.notify(response.data.title + ":" + response.data.message, "success");
                    } else {
                        $.notify(response.data.title + ":" + response.data.message, "error");
                    }
                },
                error: function () {
                    $.notify("Произошла ошибка при загрузке файла", "error");
                }
            });
        }
    });

    $("#upload_additional_file_form").on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы

        // Создаем объект FormData и добавляем в него данные формы
        const formData = new FormData(this);
        const workId = localStorage.getItem('work_id');
        formData.append('work_id',workId);

        $.ajax({
            url: '/dashboard/works/additional-files/create',
            type: 'POST',
            data: formData,
            processData: false, // Не обрабатываем файлы (не превращаем в строку)
            contentType: false, // Не устанавливаем заголовок Content-Type
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success)
                {
                    const additionalFile = response.data.additional_file;
                    $("#additional_files").append($("#additional_file_tmpl").tmpl(additionalFile));
                }
                else
                {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function() {
                $.notify("Ошибка при добавлении работы. Обратитесь к системному администратору", "error");
            }
        });
    });



    $(function() {
        let start = moment();
        let end =  moment().add(29, 'days');
        $('input[name="daterange"]').daterangepicker({
            startDate: start,
            endDate: end,
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"
                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1
            },
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });


    $('#checking_specialties').change(function () {
        $('#specialties_list').find("input[class='specialty_checkbox']").prop('checked', $(this).prop("checked"));
    });

    $('#checking_departments').change(function () {
        $('#departments_list').find("input[class='department_checkbox']").prop('checked', $(this).prop("checked"));
    });

    $('.js-example-basic-single').select2();


});


function works(page = 1) {
    console.log('user id 2 = ' + userId);
    const data = {
        page: page,
        user_id: userId
    };
    $.ajax({
        url: "/dashboard/works/get-user-works",
        type: 'GET',
        data: data,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                const pagination = response.data.works;
                const links = pagination.links;
                // Обрезаем из массива линков Previos и Next
                links.shift();
                links.pop();
                pagination.links = links;
                const works = pagination.data;
                console.log(works);
                const worksTable = $("#works_table");
                worksTable.html($("#work_tmpl").tmpl(works));
                const currentPage = pagination.current_page;
                const perPage = pagination.per_page;
                const totalItems = pagination.total;
                $("#works_count").text(totalItems);
                const totalPages = pagination.links.length;
                updateWorksPagination(currentPage, totalItems, totalPages, perPage);
                works.forEach(work => {
                    const workId = work.id;
                    const channel = window.Echo.channel(`works.${workId}`)
                        .listen('.WorkUpdated', (e) => {
                            console.log('Work updated:', e);
                            reloadWork(workId);
                        })
                        .error((error) => {
                            console.error('Error:', error);
                        });
                });
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}



function faculties(data,htmlId) {
    console.log('faculties');
    $.ajax({
        url: "/dashboard/organizations/faculties/get",
        dataType: "json",
        data: data,
        type: "get",
        success: function (response) {
            if (response.success) {
                const faculties = response.data.faculties;
                const facultiesList = $("#" + htmlId);
                console.log('faculties = ');
                console.log(faculties);
                facultiesList.html($("#faculty_tmpl").tmpl(faculties));
                facultiesList.prepend('<option value="" selected>Выберите.......</option>');
                console.log('')
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе года", "error");
        }
    });
}

function departments(data,htmlId) {
    $.ajax({
        url: "/dashboard/organizations/departments/get",
        dataType: "json",
        data: data,
        type: "get",
        success: function (response) {
            if (response.success) {
                const departments = response.data.departments;
                const departmentsList = $("#" + htmlId);
                departmentsList.html($("#department_tmpl").tmpl(departments));
                departmentsList.prepend('<option value="" selected>Выберите.......</option>');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе факультета", "error");
        }
    });
}


function specialties(data,htmlId) {
    $.ajax({
        url: "/dashboard/organizations/departments/program-specialties",
        dataType: "json",
        data: data,
        type: "get",
        success: function (response) {
            if (response.success) {
                const specialties = response.data.program_specialties;
                console.log('specialties');
                console.log(specialties);
                const specialtiesList = $("#" + htmlId);
                specialtiesList.html($("#specialty_tmpl").tmpl(specialties));
                specialtiesList.prepend('<option value="" selected>Выберите.......</option>');
            } else {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Произошла ошибка при выборе факультета", "error");
        }
    });
}

function updateWorkVisibility()
{
    const id = localStorage.getItem('work_id');
    const data = {
       id:id,
    };
    $.ajax({
        url: "/dashboard/works/update/visibility",
        type: 'POST',
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                $.notify(response.data.title + ":" + response.data.message, "success");

            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}




function addWork(formData)
{
    $.ajax({
        url: '/dashboard/works/create',
        type: 'POST',
        data: formData,
        processData: false, // Не обрабатываем файлы (не превращаем в строку)
        contentType: false, // Не устанавливаем заголовок Content-Type
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#works_table").append($("#work_tmpl").tmpl(work));
                updateWorksCount();
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при добавлении работы. Обратитесь к системному администратору", "error");

        }
    });
}

function getAssessmentDescription(assessment)
{
    switch (assessment) {
        case 0:
            return 'Без оценки';
        case 2:
            return 'Неудовлетворительно';
        case 3:
            return 'Удовлетворительно';
        case 4:
            return 'Хорошо';
        case 5:
            return 'Отлично';
        default:
            return 'Неизвестно';
    }
}

function getAgreementDescription(agreement)
{
    switch (agreement) {
        case 1:
            return 'Согласен на размещение работы';
        case 0:
            return 'Не согласен на размещение работы';
        default:
            return 'Неизвестно';
    }
}

function getSelfCheckDescription(selfCheck)
{
    switch (selfCheck) {
        case 0:
            return 'Не пройдена';
        case 1:
            return 'Пройдена';
        default:
            return 'Неизвестно';
    }
}



function reloadWork(workId)
{
    const data = {
        id:workId
    };
    $.ajax({
        url: "/dashboard/works/find",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#work_" + workId).replaceWith($("#work_tmpl").tmpl(work));
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function openReport(workId)
{
    const data = {
        id:workId
    };
    $.ajax({
        url: "/dashboard/works/find",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#report_container").html($("#record_tmpl").tmpl(work));
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function searchWorks() {
    let data = $("#search_form").serialize();
    data = serializeRemoveNull(data);
    const additionalData = {
        user_type:2,
        user_id:userId
    };
    data += '&' + $.param(additionalData);
    $.ajax({
        url: "/dashboard/works/search",
        type: 'GET',
        data: data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const pagination = response.data.works;
                const links = pagination.links;
                //Обрезаем из массива линков Previos и Next
                links.shift();
                links.pop();
                pagination.links = links;
                const works = pagination.data;
                console.log(works);
                const worksTable = $("#works_table");
                worksTable.html($("#work_tmpl").tmpl(works));
                const currentPage = pagination.current_page;
                const perPage = pagination.per_page;
                const totalItems = pagination.total;
                const totalPages = pagination.links.length;
                console.log('total items = ' + totalItems);
                $("#works_count").text(totalItems);
                updateWorksPagination(currentPage,totalItems,totalPages,perPage);
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function resetSearch()
{
    localStorage.setItem('selected_years', '');
    localStorage.setItem('selected_faculties', '');
    localStorage.setItem('selected_departments', '');
    $(".out-kod").empty();
    $("#default_specialty").prop('selected',true);
    $("#student_input").val('');
    $("#work_name_input").val('');
    $("#group_input").val('');
    $("#work_type_input").val('');
    works();
}

function openInfoBox(id)
{
    if(id)
    {
        const deleted = $("#work_" + id).attr('class');
        if(deleted)
        {
            console.log('true');
            $("#added_menu").html($("#deleted_menu_tmpl").tmpl());
        }
        else
        {
            console.log('false');
            $("#added_menu").html($("#undeleted_menu_tmpl").tmpl());
        }
        const data = {
            id:id
        };

        $.ajax({
            url: "/dashboard/works/find",
            type: 'GET',
            data:data,
            dataType: "json",
            success: function(response) {
                if (response.success)
                {
                    const work = response.data.work;
                    const userId = work.user_id;
                    localStorage.setItem('work_id',id);
                    localStorage.setItem('user_id',userId);
                }
                else
                {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function() {
                $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
            }
        });
    }
    $("#info_box").fadeToggle(100);

}

function checkDeleted()
{
    return  localStorage.getItem('deleted');
}

function updateWorkSpecialty()
{
    let data = $("#update_work_specialty_form").serialize();
    const workId = localStorage.getItem('work_id');
    const additionalData = {
        id: workId,
    };
    data += '&' + $.param(additionalData);
    updateWorkCore(data,workId);
}

function workInfo()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id: workId,
    };
    $.ajax({
        url: "/dashboard/works/find",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#about_work").html($("#work_info_tmpl").tmpl(work));
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function updateWork()
{
    let data = $("#update_work_form").serialize();
    const workId = localStorage.getItem('work_id');
    const additionalData = {
        id: workId,
    };
    data += '&' + $.param(additionalData);
    updateWorkCore(data,workId);
}

function downloadWork()
{
    const workId = localStorage.getItem('work_id');
    window.location.href = '/dashboard/works/download?id=' + workId;
}

function openUpdateWorkModal()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id:workId
    };
    $.ajax({
        url: "/dashboard/works/find",
        type: 'GET',
        data:data,
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#tmpl_modals").html($("#update_work_tmpl").tmpl(work));
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });

}

function downloadCertificate()
{
    const workId = localStorage.getItem('work_id');
    window.location.href = '/dashboard/works/certificates/download?id=' + workId;

}

function copyWork()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id: workId,
    };
    $.ajax({
        url: "/dashboard/works/copy",
        type: 'POST',
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                //обновялем список работ
                works();
                $.notify(response.data.title + ":" + response.data.message, "success");
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function deleteWork()
{
    if (confirm('Вы уверены,что хотите поместить работу на удаление?'))
    {
        const workId = localStorage.getItem('work_id');
        const data = {
            id: workId,
        };
        $.ajax({
            url: "/dashboard/works/delete",
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                if (response.success)
                {
                    works();
                    $.notify(response.data.title + ":" + response.data.message, "success");
                }
                else
                {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function() {
                $.notify("Ошибка при удалении работы. Обратитесь к системному администратору", "error");
            }
        });
    }
}

function destroyWork()
{
    if (confirm('Вы уверены,что хотите стереть запись и удалить прикрепленные файлы?'))
    {
        const workId = localStorage.getItem('work_id');
        const data = {
            id: workId,
        };
        $.ajax({
            url: "/dashboard/works/destroy",
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function(response) {
                if (response.success)
                {
                    works();
                    $.notify(response.data.title + ":" + response.data.message, "success");
                }
                else
                {
                    $.notify(response.data.title + ":" + response.data.message, "error");
                }
            },
            error: function() {
                $.notify("Ошибка при удалении работы. Обратитесь к системному администратору", "error");
            }
        });
    }
}

function updateSelfCheckStatus()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id:workId
    };
    $.ajax({
        url: "/dashboard/works/update/self-check",
        type: 'POST',
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                $.notify(response.data.title + ":" + response.data.message, "success");
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });

}

function restore()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        id:workId
    };
    $.ajax({
        url: "/dashboard/works/restore",
        type: 'POST',
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                works();
                $.notify(response.data.title + ":" + response.data.message, "success");
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
}

function additionalFiles()
{
    const workId = localStorage.getItem('work_id');
    const data = {
        work_id:workId
    };
    $.ajax({
        url: "/dashboard/works/additional-files/get",
        type: 'GET',
        data: data,
        dataType: "json",
        success: function (response) {
            if (response.success)
            {
                const additionalFiles = response.data.additional_files;
                $("#additional_files").html($("#additional_file_tmpl").tmpl(additionalFiles));
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Ошибка при получении дополнительных файлов. Обратитесь к системному администратору", "error");
        }
    });
}

function deleteAdditionalFile(additionalFileId)
{
    const data = {
        id:additionalFileId
    };
    $.ajax({
        url: "/dashboard/works/additional-files/delete",
        type: 'POST',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function (response) {
            if (response.success)
            {
                $("#additional_file_" + additionalFileId).remove();
                $.notify(response.data.title + ":" + response.data.message, "success");
            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function () {
            $.notify("Ошибка при получении дополнительных файлов. Обратитесь к системному администратору", "error");
        }
    });
}

function exportWorks()
{
    let data = $("#search_form").serialize();
    data = serializeRemoveNull(data);
    const selectedYears = getArrayFromLocalStorage('selected_years');
    const selectedFaculties = getArrayFromLocalStorage('selected_faculties');
    const additionalData = {
        selected_years: selectedYears,
        selected_faculties: selectedFaculties,
    };
    data += '&' + $.param(additionalData);
    window.location.href = '/dashboard/works/export?' + data;
}

function updateWorkCore(data,workId)
{
    $.ajax({
        url: "/dashboard/works/update",
        type: 'POST',
        data:data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "json",
        success: function(response) {
            if (response.success)
            {
                const work = response.data.work;
                $("#work_" + workId).replaceWith($("#work_tmpl").tmpl(work));
                $.notify(response.data.title + ":" + response.data.message, "success");

            }
            else
            {
                $.notify(response.data.title + ":" + response.data.message, "error");
            }
        },
        error: function() {
            $.notify("Ошибка при поиске работ. Обратитесь к системному администратору", "error");
        }
    });
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





