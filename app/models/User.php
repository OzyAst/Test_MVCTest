<?php

class User extends Model
{

    public function tableName(){}
    public function rules(){}

    /**
     * Данные пользователя
     * @return array
     */
    private function getData(){
        return ['login' => "admin", 'password' => "123"];
    }

    /**
     * Аутентификация, вызывыается из авторизации
     * @param $login
     * @param $password
     * @return int
     */
    private function authentication($login, $password)
    {
        if (!strlen($login) || !strlen($password)) {
            $this->error = "Все поля обязательные для заполнения!";
            return 0;
        }

        $user = $this->getData();
        if ($login != $user['login'] || $password != $user['password']) {
            $this->error = "Введенные данные не верны!";
            return 0;
        }

        return 1;
    }

    /**
     * Авторизация
     * @param $login
     * @param $password
     * @return int
     */
    public function authorization($login, $password)
    {
        if (!$this->authentication($login, $password))
            return 0;

        setcookie("login", $login, time()+60*60*24*30, '/');
        setcookie("authentication", 1, time()+60*60*24*30, '/');

        return 1;
    }

    /**
     * Очищаем данные пользователя
     */
    public function logout()
    {
        setcookie("login", '', 0, '/');
        setcookie("authentication", '', 0, '/');
    }

    /**
     * Вернет флаг, гость или администратор
     * @return bool|int
     */
    public static function isGuest()
    {
        return isset($_COOKIE['authentication']) ? !$_COOKIE['authentication'] : 1;
    }

}