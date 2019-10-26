<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Приложение - задачник</title>

    <!-- CSS -->
    <link href="/theme/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Задачник</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/">Главная</a>
        <a class="p-2 text-dark" href="/task/add">Добавить</a>
        <?php if (User::isGuest()): ?>
            <a class="p-2 text-dark" href="/site/login">Вход</a>
        <?php else: ?>
            <a class="p-2 text-dark" href="/site/logout">Выход</a>
        <?php endif; ?>
    </nav>
</div>

<div class="container">
    <?php include 'app/views/'.$content ?>

    <footer class="pt-4 my-5 pt-5 border-top">
        <div class="row">
            <div class="col-12 col-md text-center">
                <small class="d-block mb-3 text-muted">&copy; 2019</small>
            </div>
        </div>
    </footer>
</div>

<script type="application/javascript" src="/theme/js/jquery-3.4.1.min.js"></script>
<script type="application/javascript" src="/theme/js/bootstrap.min.js"></script>
<script type="application/javascript" src="/theme/js/main.js"></script>
</body>
</html>
