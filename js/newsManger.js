
window.addEventListener('load', function (event) {
    // при загрузке страницы
    if (window.location.href.includes("News")) {
        addNewListener();
        deleteNewListener();
        editNewListener();
    }
});
// генерация html кода формы
function createForm(type) {
    let formHtml = '<div id="overlay2"></div><div id="addform"><form id = "formD" method="POST" ';
    if (type === "add") {
        //formHtml += 'action="controllers/addnew.php"';
        formHtml += 'action="news/add"';
    } else if (type === "edit") {
        formHtml += 'action="news/edit"';
    }
    formHtml += ' enctype="multipart/form-data">';
    if (type === "add") {
        formHtml += '<h2>Добавить новость</h2>';
    } else if (type === "edit") {
        formHtml += '<h2>Изменить новость</h2>';
    }
    formHtml += '<p id="mes" class="message"></p><input type="text" id="titleinp" name="header" placeholder = "Введите заголовок статьи:">';
    if (type === "add") {
        formHtml += '<p>Добавить картинку</p>';
    } else if (type === "edit") {
        formHtml += '<p>Изменить картинку</p>';
    }
    formHtml += '<input type="file" name="image"><textarea id="textarea" cols="40" rows="20" placeholder = "Введите текст статьи:" name="text"></textarea>' +
        '<button type="submit" ';
    // if (type === "add") {
    //     formHtml += 'id="add"';
    // } else if (type === "edit") {
    //     formHtml += 'id="savenew"';
    // }
    formHtml += 'id="saveBtn"';
    formHtml += ' value="Сохранить">Сохранить</button><button id="closeform">Закрыть окно</button></form></div>';
    return formHtml;
}
// вывод формы в дом
function showForm(formHtml) {
    //let form = document.createElement();
    document.body.insertAdjacentHTML("beforeend", formHtml);
    let form = document.getElementById('addform');
    form.style.left = ((window.innerWidth - form.clientWidth) / 2).toString();
    form.style.top = ((window.innerHeight - form.clientHeight) / 1.7).toString();
    return form;
}
// удаление формы из дом
function hideForm(form, overlay) {
    form.remove();
    overlay.remove();
}
// слушатель кнопки закрыть форму
function closeFormListener(formDiv) {
    let buttonClose = document.getElementById('closeform');
    let overlay = document.getElementById('overlay2');
    buttonClose.addEventListener('click', function (event) {
        // при нажатии на кнопку закрыть
        event.preventDefault();
        hideForm(formDiv, overlay);
    });
}
// заполнение формы текущей новостью
function fillFormWithNew(result) {
    let title = document.getElementById('titleinp');
    let textarea = document.getElementById('textarea');
    title.value = result["title"];
    textarea.innerHTML = result["text"];
}

function submitFormListener(form, isEditing = false, idNew = null) {
    form.addEventListener('submit', function (event) {
        // при отправке формы
        event.preventDefault();
        let actionForm = this.getAttribute('action');
        let formData = new FormData(this);
        if (isEditing) {
            // let idNew = +this.getAttribute("data-id-new");
            // console.log(this);

            formData.append("idnew", idNew);
        }
        submitForm(actionForm, formData).then(onSuccessSubmit);
    });
}
// отправка формы асинхронно
async function submitForm(actionForm, formData) {
    let response = await fetch(actionForm, {
        method: "POST",
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData,
    });
    let result;
    if (response.ok) {
        result = await response.json(); // декодировать ответ в json
    }
    else {
        result = await response.error();
    }
    return result;
}
// удаление новости асинхронно
async function deleteNew(urlController, idNew) {
    let bodyQuery = JSON.stringify({idnew: idNew});
    let response = await fetch(urlController, {
        method: 'post',
        //mode: "cors",
        //credentials: "include",
        headers: {
            //'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: bodyQuery,
    });
    let result;
    if(response.ok) {
        result = await response.json();
    }
    else {
        result = await response.error();
    }
    return result;
}
// запрос редактирумой новости
async function selectEditingNew(urlController, idNew) {
    let response = await fetch(urlController, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({idnew: idNew}),
    });
    let result;
    if (response.ok) {
        result = response.json();
    }
    else {
        result = response.error();
    }
    return result;
}

// успех ajax запроса submit

function onSuccessSubmit(result) {
    let message = document.getElementById('mes');
    message.innerHTML = result[0]; // Вывести сообщение в поле #mes
    if(!result[1]) {
        return; // Если статус запроса ошибка то прервать функцию и не прятать форму
    }
    let saveBtn = document.getElementById('saveBtn');
    saveBtn.disabled = true; // отключить кнопку для избежания спама
    let timeoutId = setTimeout(() => {
        let overlay = document.getElementById('overlay2');
        let formDiv = document.getElementById('addform');
        hideForm(formDiv, overlay);
        window.location.reload();
        window.scrollTo(0, 0);
    }, 2000);
    // через 2 секунды спрятать форму, перезагрузить страницу (костыль TO DO), прокрутить до самого верха
}
// слушатель кнопки добавить новость
function addNewListener() {
    // добавление формы на чистом js
    let addNewBtn = document.getElementById('addnew');
    addNewBtn.addEventListener('click', function (event) {
        // при нажатии на кнопку добавить
        let formDiv = showForm(createForm("add"));
        let form = formDiv.firstChild;
        closeFormListener(formDiv);
        submitFormListener(form);
    });
}
// слушатель кнопок удалить новость
function deleteNewListener() {
// удаление записи на чистом js
    let deleteButtons = document.querySelectorAll('.delnew');
    for(let button of deleteButtons) {
        button.addEventListener('click', function (event) {
            let idNew = +this.getAttribute("data-id-new");
            let urlController = 'news/delete';
            deleteNew(urlController, idNew).then(function (result) {
                    window.location.reload();
            });
        });
    }
}
// слушатель кнопок редактировать новость
function editNewListener() {
    let editButtons = document.querySelectorAll('.editnew');
    for (let btn of editButtons) {
        btn.addEventListener('click', function(event) {
            let idNew = +this.getAttribute("data-id-new");
            let formDiv = showForm(createForm("edit"));
            let form = formDiv.firstChild;
            closeFormListener(formDiv);
            selectEditingNew('news/select_edit', idNew).then(fillFormWithNew);
            submitFormListener(form, true, idNew);
        });
    }

}
