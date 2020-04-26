<?php

namespace Ozycast\core;

use Ozycast\core\Route;

Class App
{
    static public $db = null;

    public function __construct($config)
    {
        self::getDb($config);
    }

    public function run()
    {
        Route::start();
    }

    public function getDb($config)
    {
        self::$db = (new MySQL())->connect($config);
        return self::$db;
    }
}
