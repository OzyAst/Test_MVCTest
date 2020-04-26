<?php

namespace Ozycast\app\models;

use Ozycast\core\App;
use Ozycast\core\ActiveRecord;
use Ozycast\core\Pagination;

class Task extends ActiveRecord
{

    public $id;
    public $user;
    public $email;
    public $text;
    public $label;
    public $status;

    /**
     * Имя таблицы
     * @return string
     */
    public static function getTableName(): string
    {
        return 'tasks';
    }

    /**
     * Правила обработки данных модели
     * @return array
     */
    public function rules()
    {
        return [
            ['id', 'user', 'email', 'text', 'label', 'status'],
            [['user', 'email', 'text'], 'require'],
            [['status'], 'integer'],
            [['user', 'email', 'text', 'label'], 'string'],
        ];
    }

    /**
     * Получить данные из БД
     * @param $page - текущая страница
     * @param string $sort - сортировка по полю
     * @param int $desc - Направление сортировки
     * @return array
     */
    public static function getData($page, $sort = "", $desc = 0)
    {
        $count = App::$db->sqlColumn('SELECT count(*) FROM tasks', []);
        // получим данные для пагинации и лимита
        $pages = Pagination::getPagination($page, $count);

        $sort_sql = "";
        if (strlen($sort)) {
            if (property_exists (self::class, $sort))
                $sort_sql = "ORDER BY ".$sort." ".($desc ? "DESC" : "ASC");
        }

        $tasks = App::$db->sqlAll("SELECT * FROM tasks ".$sort_sql." LIMIT ".$pages['offset'].", 3", []);
        return ["tasks" => $tasks, "pages" => $pages];
    }
}