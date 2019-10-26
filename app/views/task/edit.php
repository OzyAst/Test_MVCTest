
<h1 class="text-center">Редактировать задачу</h1>

<div class="row justify-content-md-center">
    <form class="mt-5 col-md-6" id="task_form_edit">
        <input type="hidden" id="id" value="<?= $model->id ?>">
        <div class="form-row">
            <div class="col-md-6 mb-4">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" value="<?= $model->email ?>">
            </div>
            <div class="col-md-6 mb-4">
                <label for="user">Имя:</label>
                <input type="text" class="form-control" id="user" placeholder="Антон" value="<?= $model->user ?>">
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="text">Текст задачи:</label>
            <textarea class="form-control" id="text" rows="3"><?= $model->text ?></textarea>
        </div>

        <div class="form-row">
            <div class="col-md-6 mb-4">
                <label for="label">Отметка:</label>
                <input type="text" class="form-control" id="label" value="<?= $model->label ?>">
            </div>
            <div class="col-md-6 mb-4">
                <label for="status">Статус:</label>
                <select class="form-control" id="status">
                    <option value="1" <?= $model->status ? "selected":"" ?>>Выполнено</option>
                    <option value="0" <?= !$model->status ? "selected":"" ?>>Не выполнено</option>
                </select>
            </div>
        </div>

        <div class="invalid-feedback text-right mb-4"></div>

        <div class="form-group mb-4 text-right">
            <button type="submit" class="btn btn-info">Сохранить задачу</button>
        </div>
    </form>
</div>
