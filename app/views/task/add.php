<h1 class="text-center">Добавить задачу</h1>

<div class="row justify-content-md-center">
    <form class="mt-5 col-md-6" id="task_form">
        <div class="form-row">
            <div class="col-md-6 mb-4">
                <label for="email">Ваш Email:</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com">
            </div>
            <div class="col-md-6 mb-4">
                <label for="user">Ваше Имя:</label>
                <input type="text" class="form-control" id="user" placeholder="Антон">
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="text">Текст задачи:</label>
            <textarea class="form-control" id="text" rows="3"></textarea>
        </div>

        <div class="invalid-feedback text-right mb-4"></div>
        <div class="valid-feedback text-right mb-4">Задача успешно добавлена</div>

        <div class="form-group mb-4 text-right">
            <button type="submit" class="btn btn-info">Добавить задачу</button>
        </div>
    </form>
</div>
