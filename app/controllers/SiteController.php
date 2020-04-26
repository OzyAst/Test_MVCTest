<?php

namespace Ozycast\app\controllers;

use Ozycast\app\models\Task;
use Ozycast\app\models\User;
use Ozycast\core\Controller;

class SiteController extends Controller
{

    /**
     * Главная
     */
    function actionIndex()
    {
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $sort = isset($_GET["sort"]) ? $_GET["sort"] : "";
        $desc = isset($_GET["desc"]) ? $_GET["desc"] : 0;

        $tasks = Task::getData($page, $sort, $desc);

        $this->view->generate('site/index.php', [
            'tasks' => $tasks['tasks'],
            'pages' => $tasks['pages'],
        ]);
    }

    /**
     * Авторизация
     */
    function actionLogin()
    {
        if (!User::isGuest())
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');

        if ($_POST['form']) {
            if (!$this->user->authorization($_POST['form']['login'], $_POST['form']['password'])) {
                echo json_encode(["success" => 0, "message" => $this->user->getError()]);
                return;
            }

            echo json_encode(["success" => 1]);
            return;
        }

        $this->view->generate('site/login.php');
    }

    /**
     * Выход
     */
    function actionLogout()
    {
        $this->user->logout();
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    }

    /**
     * Страница ошибок
     */
    function actionError()
    {
        $code = (int) $_GET['error'];
        $this->view->generate('site/error.php', [
            'code' => $code,
        ]);
    }
}