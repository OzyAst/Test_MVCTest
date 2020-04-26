<?php

namespace Ozycast\core;

use \PDO;

Class BD
{
    const USERNAME = "root";
    const PASSWORD = "";
    const HOST = "localhost";
    const DB = "mvc_test";

    private static $instance;

    private function __construct(){}

    public static function getConnection()
    {
        if (!empty(self::$instance))
            return self::$instance;


        $username = self::USERNAME;
        $password = self::PASSWORD;
        $host = self::HOST;
        $db = self::DB;

        try {
            self::$instance = new PDO("mysql:dbname=$db;host=$host", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (\PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }

        return self::$instance;
    }
}