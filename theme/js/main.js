$(document).ready(function () {
    // Добавление новой задачи
    $("#task_form").on("submit", function(e) {
        e.preventDefault();
        var form = formRead($(this));

        post("/task/add", {form: form}, function() {
            formClear($("#task_form"));
            forSuccess();
        })
    });

    // Редактирование задачи
    $("#task_form_edit").on("submit", function(e) {
        e.preventDefault();
        var form = formRead($(this));

        post("/task/edit?id="+form.id, {form: form}, function() {
            location.href = '/';
        })
    });

    // Авторизация
    $("#login_form").on("submit", function(e) {
        e.preventDefault();
        var form = formRead($(this));

        post("/site/login", {form: form}, function() {
            formClear($("#login_form"));
            location.href = '/';
        })
    });

    // Кнопка, отметка выполнено
    $('body').on("click", "#task__completed", function() {
        var id = $(this).parents('tr').attr("data-id");

        post("/task/completed?id="+id, null, function() {
            location.href = '/';
        })
    })

    // Сортировка задач
    $('body').on("click", ".task__sorted", function() {
        var row = $(this).attr("data-row");
        var url = window.location.href;
        var desc = url.match(/(\?|&)desc=([0-1]*)(&?)/);
        if (desc) {
            desc = !parseInt(desc[2]) ? 1 : 0;
            url = url.replace(/(\?|&)sort=([^&]*)(&?)/i, "$1sort="+row+"$3");
            url = url.replace(/(\?|&)desc=([0-1]*)(&?)/i, "$1desc="+desc+"$3");
        } else {
            if (url.match(/\?/))
                url = url + "&sort="+row+"&desc=1";
            else
                url = url + "?sort="+row+"&desc=1";
        }

        location.href = url;
    })
});

// Успех после отправки формы
function forSuccess() {
    $('.valid-feedback').show();
    setTimeout(function() {
        $('.valid-feedback').hide("slow");
    }, 1500);
}

// Получить данные с формы
function formRead(form) {
    var data = {};
    $("input, textarea, select", form).each(function (indx, element) {
        var name = $(element).attr('id');
        data[name] = $(element).val();
    });
    return data;
}

// Очистить форму
function formClear(form) {
    $("input, textarea", form).val("");
    $('.invalid-feedback').hide();
}

// Пост запрос с обработкой ошибок
function post(url, data, callback) {
    $.post(url, data, function(answer) {
        try {
            answer = JSON.parse(answer);

            if (answer.success) {
                callback(answer);
            } else {
                if ($('.invalid-feedback').length)
                    $('.invalid-feedback').html(answer.message).show();
                else
                    alert(answer.message);
            }
        } catch (e) { alert(e); }
    })
}