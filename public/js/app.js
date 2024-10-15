/* Кнопка открытия модального окна для update_year */
$(document).ready(function () {
    $('#update_year').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Кнопка, которая вызвала модалку
        let id = button.data('id');
        let year = button.data('year');
        let students_count = button.data('students_count');
        let comment = button.data('comment');

        var modal = $(this);
        modal.find('.modal-title h4').text('Редактирование года выпуска');
        modal.find('input[name="year"]').val(year);
        modal.find('input[name="students_count"]').val(students_count);
        modal.find('input[name="comment"]').val(comment);

        modal.find('form').attr('onsubmit', 'updateYear(' + id + ');return false;');
        modal.find('form').attr('id', 'year_update_' + id);
    });


});

$(document).ready(function () {
    $('.delete-link').on('click', function (e) {
        e.preventDefault(); // Отключаем стандартное действие ссылки

        let url = $(this).attr('href'); // Получаем URL из ссылки
        if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
            $.ajax({
                url: url, // URL для DELETE запроса
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        location.reload(); // Обновляем страницу (опционально)
                        $.notify(response.data.title + ":" + response.data.message, "success");
                    } else {
                        $.notify(response.data.title + ":" + response.data.message, "error");
                    }
                },
                error: function (xhr) {
                    // Ошибка при удалении
                    $.notify("Ошибка при удалении элемента", "error");
                    console.log(xhr.responseText);
                }
            });
        }
    });

    $('.restore-link').on('click', function (e) {
        e.preventDefault(); // Отключаем стандартное действие ссылки

        let url = $(this).attr('href'); // Получаем URL из ссылки
        if (confirm('Вы уверены, что хотите восстановить этот элемент?')) {
            $.ajax({
                url: url, // URL для DELETE запроса
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Успешное удаление, можно обновить страницу или удалить элемент из DOM
                    location.reload(); // Обновляем страницу (опционально)
                    $.notify(response.data.title + ":" + response.data.message, "success");
                },
                error: function (xhr) {
                    // Ошибка при удалении
                    $.notify(response.data.title + ":" + response.data.message, "error");
                    console.log(xhr.responseText);
                }
            });
        }
    });
});

/* Кнопка открытия модального окна для update_faculty */
$(document).ready(function () {
    $('#update_faculty').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Кнопка, которая вызвала модалку
        let id = button.data('id');
        let name = button.data('name');

        var modal = $(this);
        modal.find('.modal-title h4').text('Редактирование подразделения ' + id);
        modal.find('input[name="name"]').val(name);

        modal.find('form').attr('onsubmit', 'updateFaculty(' + id + ');return false;');
        modal.find('form').attr('id', 'faculty_update_' + id);
    });
});

/* Кнопка открытия модального окна для update_department */
$(document).ready(function () {
    $('#update_department').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget); // Кнопка, которая вызвала модалку
        let id = button.data('id');
        let name = button.data('name');

        var modal = $(this);
        modal.find('.modal-title h4').text('Редактирование кафедры ' + id);
        modal.find('input[name="name"]').val(name);

        modal.find('form').attr('onsubmit', 'updateDepartment(' + id + ');return false;');
        modal.find('form').attr('id', 'department_update_' + id);
    });
});

// Функция открытия модального окна
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "block";
}

// Функция закрытия модального окна
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "none";
}


function inc(element) {
    let el = document.querySelector(`[name="${element}"]`);
    el.value = parseInt(el.value) + 1;
}

function dec(element) {
    let el = document.querySelector(`[name="${element}"]`);
    if (parseInt(el.value) > 0) {
        el.value = parseInt(el.value) - 1;
    }
}

function show_hide_password(target) {
    let input = document.getElementById('password-input');
    if (input.getAttribute('type') == 'password') {
        target.classList.add('view');
        input.setAttribute('type', 'text');
    } else {
        target.classList.remove('view');
        input.setAttribute('type', 'password');
    }
    return false;
}

function serializeRemoveNull(serStr) {
    return serStr.split("&").filter(str => !str.endsWith("=")).join("&");
}

function getArrayFromLocalStorage(fieldName) {
    const items = localStorage.getItem(fieldName);
    let itemsArray = [];
    if (items) {
        itemsArray = items.split(',');
    }
    return itemsArray;
}

function deleteElement(elementId) {
    $("#" + elementId).remove();
}

function openTmplModal(modalId, object) {
    $("#tmpl_modals").html($("#" + modalId).tmpl(object));
}

function closeTmplModal(modalId) {
    $("#" + modalId).remove();
}

const addBadge = function (clickedElement) {
    console.log('Прикол');
    console.log(clickedElement);
    const id = clickedElement.attr('id');
    console.log('id = ' + id);
    const text = clickedElement.text();
    if (id.includes('year_')) {
        let selectedYears = localStorage.getItem('selected_years');
        const match = id.match(/\d+/); // Находим все последовательности цифр в строке
        const number = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        selectedYears = selectedYears ? selectedYears.split(",") : [];
        console.log(selectedYears)
        if (!selectedYears.includes(number)) {
            selectedYears.push(number);
            console.log('вошёл');
            document.querySelector('.out-kod').style.display = "block";
            const elemOutKod = document.querySelector('.out-kod');
            elemOutKod.innerHTML += `<span class="badge text-black bg-green-light br-100 fs-12 me-3 mb-2 clicked text-grey" id="clicked_${id}">
                ${text}
                <i class="fa fa-times ms-2 cursor-p text-black fs-12" onclick="deleteTreeElement('${id}')"></i>
            </span>`;
        }
        localStorage.setItem('selected_years', selectedYears.join(','));
    } else if (id.includes('faculty_')) {
        let selectedFaculties = localStorage.getItem('selected_faculties');
        const match = id.match(/\d+/); // Находим все последовательности цифр в строке
        const number = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        selectedFaculties = selectedFaculties ? selectedFaculties.split(",") : [];
        if (!selectedFaculties.includes(number)) {
            selectedFaculties.push(number);
            document.querySelector('.out-kod').style.display = "block";
            const elemOutKod = document.querySelector('.out-kod');
            elemOutKod.innerHTML += `<span class="badge text-black bg-green-light br-100 fs-12 me-3 mb-2 clicked text-grey" id="clicked_${id}">
                ${text}
                <i class="fa fa-times ms-2 cursor-p text-black fs-12" onclick="deleteTreeElement('${id}')"></i>
            </span>`;
        }
        localStorage.setItem('selected_faculties', selectedFaculties.join(','));
    } else if (id.includes('department_')) {
        let selectedDepartments = localStorage.getItem('selected_departments');
        const match = id.match(/\d+/); // Находим все последовательности цифр в строке
        const number = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        selectedDepartments = selectedDepartments ? selectedDepartments.split(",") : [];
        if (!selectedDepartments.includes(number)) {
            selectedDepartments.push(number);
            document.querySelector('.out-kod').style.display = "block";
            const elemOutKod = document.querySelector('.out-kod');
            elemOutKod.innerHTML += `<span class="badge text-black bg-green-light br-100 fs-12 me-3 mb-2 clicked text-grey text-center" id="clicked_${id}">
                ${text}
                <i class="fa fa-times ms-2 cursor-p text-black fs-12" onclick="deleteTreeElement('${id}')"></i>
            </span>`;
        }
        localStorage.setItem('selected_departments', selectedDepartments.join(','));
    }
}


function deleteTreeElement(id) {
    console.log('id = ' + id);
    const match = id.match(/\d+/);
    const number = match ? match[0] : '';
    $("#clicked_" + id).remove();
    if (id.includes('year_')) {
        let selectedYears = localStorage.getItem('selected_years');
        const match = id.match(/\d+/); // Находим все последовательности цифр в строке
        const number = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        if (selectedYears.includes(number)) {
            let yearsArray = selectedYears.split(',');
            yearsArray = yearsArray.filter(function (item) {
                return item !== number;
            });
            selectedYears = yearsArray.join(',');
            localStorage.setItem('selected_years', selectedYears);
        }

    } else if (id.includes('faculty_')) {
        let selectedFaculties = localStorage.getItem('selected_faculties');
        const match = id.match(/\d+/); // Находим все последовательности цифр в строке
        const number = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        if (selectedFaculties.includes(number)) {
            let facultiesArray = selectedFaculties.split(',');
            facultiesArray = facultiesArray.filter(function (item) {
                return item !== number;
            });
            selectedFaculties = facultiesArray.join(',');
            localStorage.setItem('selected_faculties', selectedFaculties);
        }
    } else if (id.includes('department_')) {
        let selectedDepartments = localStorage.getItem('selected_departments');
        const match = id.match(/\d+/); // Находим все последовательности цифр в строке
        const number = match ? match[0] : ''; // Если найдены цифры, сохраняем их
        if (selectedDepartments.includes(number)) {
            let departmentsArray = selectedDepartments.split(',');
            departmentsArray = departmentsArray.filter(function (item) {
                return item !== number;
            });
            selectedDepartments = departmentsArray.join(',');
            localStorage.setItem('selected_departments', selectedDepartments);
        }
    }

}


function updateWorksPagination(pagination) {
    console.log('pagination');
    console.log(pagination);

    const displayedPages = pagination.links.length - 2; //Без Previous и Next
    const totalItems = pagination.total;
    if (totalItems>1)
    {
        $("#works_count").text(totalItems);

        $("#works_pagination").pagination({
            items: totalItems,
            itemsOnPage: pagination.per_page,
            currentPage: pagination.current_page, // Установка текущей страницы в начало после добавления новых элементов
            displayedPages: displayedPages,
            cssStyle: '',
            prevText: '<span aria-hidden="true"><img src="/images/Chevron_Left.svg" alt=""></span>',
            nextText: '<span aria-hidden="true"><img src="/images/Chevron_Right.svg" alt=""></span>',
            onPageClick: function (pageNumber) {
                searchWorks(pageNumber);
            }
        });
    }

}


function toggleFile(htmlId) {
    $('#' + htmlId).click(); // Открываем диалог выбора файла
}

function selectFileWithCKFinder(elementId) {
    CKFinder.modal({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                var output = document.getElementById(elementId);
                output.value = file.getUrl();
            });

            finder.on('file:choose:resizedImage', function (evt) {
                var output = document.getElementById(elementId);
                output.value = evt.data.resizedUrl;
            });
        }
    });
};

function updateUserPagination(pagination) {
    const totalItems = pagination.total;
    const displayedPages = pagination.links.length - 2; //Без Previous и Next
    $("#users_count").text(totalItems);
    $("#users_pagination").pagination({
        items: totalItems,
        itemsOnPage: pagination.per_page,
        currentPage: pagination.current_page, // Установка текущей страницы в начало после добавления новых элементов
        displayedPages: displayedPages,
        cssStyle: '',
        prevText: '<span aria-hidden="true"><img src="/images/Chevron_Left.svg" alt=""></span>',
        nextText: '<span aria-hidden="true"><img src="/images/Chevron_Right.svg" alt=""></span>',
        onPageClick: function (pageNumber) {
            searchUsers(pageNumber);
        }
    });
}

