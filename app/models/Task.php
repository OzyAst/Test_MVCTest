<?php

class Task extends Model
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
    public function tableName()
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
        $count = self::bd()->query('SELECT count(*) FROM tasks')->fetchColumn();
        // получим данные для пагинации и лимита
        $pages = Pagination::getPagination($page, $count);

        $sort_sql = "";
        if (strlen($sort)) {
            if (property_exists (self::class, $sort))
                $sort_sql = "ORDER BY ".$sort." ".($desc ? "DESC" : "ASC");
        }

        $tasks = self::bd()->query("SELECT * FROM tasks ".$sort_sql." LIMIT ".$pages['offset'].", 3", PDO::FETCH_ASSOC)->fetchAll();
        return ["tasks" => $tasks, "pages" => $pages];
    }

    /**
     * Получить одну запись из БД по ID
     * @param $id - ID записи из БД
     * @return mixed
     */
    public static function getDataOne($id)
    {
        $stmt = self::bd()->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(["id" => $id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        return $task;
    }
}