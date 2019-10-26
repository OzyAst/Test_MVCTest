<?php

class Route
{

    static function start()
    {
        $controller_name = "Site";
        $action_name = "index";

        $routers = explode("/", $_SERVER['REQUEST_URI']);

        if (!empty($routers[1]))
            $controller_name = $routers[1];
        if (!empty($routers[2]))
            $action_name = $routers[2];

        $model_path = "app/models/".$controller_name."Model.php";
        $controller_name = ucfirst($controller_name)."Controller";
        $controller_path = "app/controllers/".$controller_name.".php";
        $action_name = "action".preg_replace("/(\?.*)/", "", $action_name);

        if (file_exists($model_path))
            include_once $model_path;

        if (file_exists($controller_path)) {
            include_once $controller_path;
        } else {
            Route::ErrorPage(404, "Not Found");
        }

        $controller = new $controller_name;

        if (method_exists($controller, $action_name)) {
            $controller->$action_name();
        } else {
            Route::ErrorPage(404, "Not Found");
        }
    }

    public static function ErrorPage($code, $message)
    {
        $host = 'http://'.$_SERVER['HTTP_HOST']."/";
        header('HTTP/1.1 '.$code.' '.$message);
        header('Status: '.$code.' '.$message);
        header('Location: '.$host.'site/error?error='.$code);
        exit;
    }

}