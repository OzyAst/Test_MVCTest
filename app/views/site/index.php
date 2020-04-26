<?php
    use \Ozycast\app\models\User;
?>

<h1>Задачи</h1>

<table class="table mt-5">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Имя пользователя <button data-row="user" class="btn btn-link p-0 task__sorted">&#x2666;</button></th>
        <th scope="col">E-mail <button data-row="email" class="btn btn-link p-0 task__sorted">&#x2666;</button></th>
        <th scope="col">Текст задачи</th>
        <th scope="col">Статус <button data-row="status" class="btn btn-link p-0 task__sorted">&#x2666;</button></th>
        <?php if (!User::isGuest()): ?>
            <th>Редактирование</th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($tasks as $task): ?>
        <tr class="<?= $task['status'] ? "text-muted" : "" ?>" data-id="<?= $task['id'] ?>">
            <th scope="row"><?= $task['id'] ?></th>

            <td>
                <?= $task['user'] ?>
            </td>

            <td>
                <?= $task['email'] ?>
            </td>

            <td>
                <?= $task['text'] ?>

                <?php if (strlen($task['label'])): ?>
                    <span class="badge badge-info"><?= $task['label'] ?></span>
                <?php endif; ?>
            </td>

            <td>
                <?php if ($task['status']): ?>
                    <span class="badge badge-success">Выполнено</span>
                <?php endif; ?>
            </td>


            <?php if (!User::isGuest()): ?>
                <td>
                    <a class="btn btn-link" href="/task/edit?id=<?= $task['id'] ?>">&#9998;</a>
                    <?php if (!$task['status']): ?>
                        <button class="btn btn-link" id="task__completed">&#x2714;</button>
                    <?php endif; ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>

    <?php if(!count($tasks)): ?>
    <tr>
        <td colspan="222">
            <p class="text-muted text-center">Нет задач...</p>
        </td>
    </tr>
    <?php endif; ?>

    </tbody>
</table>

<?php include_once "_pagination.php"; ?>
