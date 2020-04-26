<?php

namespace Ozycast\core;

class Route
{
    const NAMESPACE_CONTROLLERS = "Ozycast\\app\\controllers\\";

    static function start()
    {
        $controller_name = "Site";
        $action_name = "index";

        $routers = explode("/", $_SERVER['REQUEST_URI']);

        if (!empty($routers[1]))
            $controller_name = $routers[1];
        if (!empty($routers[2]))
            $action_name = $routers[2];

        $controller_name = ucfirst($controller_name)."Controller";
        $controller_path = self::NAMESPACE_CONTROLLERS.$controller_name;
        $action_name = "action".preg_replace("/(\?.*)/", "", $action_name);

        if (!class_exists($controller_path))
            Route::ErrorPage(404, "Not Found Controllers");

        $controller = new $controller_path;

        if (!method_exists($controller, $action_name))
            Route::ErrorPage(404, "Not Found");

        $controller->$action_name();
    }

    public static function ErrorPage($code, $message)
    {
        $host = 'http://'.$_SERVER['HTTP_HOST']."/";
        header('HTTP/1.1 '.$code.' '.$message);
        header('Status: '.$code.' '.$message);
        header('Location: '.$host.'site/error?error='.$code, true,  301);
        exit;
    }

}