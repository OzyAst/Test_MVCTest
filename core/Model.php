<?php

abstract class Model
{
    abstract public function rules();
    abstract public function tableName();

    protected $error;

    /**
     * Model constructor. Заполним модель данными
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $attr) {
            if (property_exists ($this, $key))
                $this->$key = $attr;
        }
    }

    /**
     * Подключение к БД
     * @return PDO
     */
    public function bd()
    {
        return BD::getConnection();
    }

    /**
     * Сохранить модель или обновить
     * @return bool
     */
    public function save()
    {
        if (!$this->verify())
            return false;

        if ($this->id)
            return $this->update();

        $rules = $this->rules();
        $attributes = $rules[0];

        $sql_params = [];
        foreach ($attributes as &$attr) {
            $key = ":".$attr;
            $sql_params[$key] = $this->$attr;
        }
        $sql_rows = implode(',', $attributes);
        $sql_params_name = implode(',', array_keys($sql_params));

        $query = $this->bd()->prepare("INSERT INTO ".$this->tableName()."($sql_rows) VALUES ($sql_params_name)");
        return $query->execute($sql_params);
    }

    /**
     * Обновить модель
     * @return bool
     */
    private function update()
    {
        $rules = $this->rules();
        $attributes = $rules[0];

        $sql_params = [];
        $sql_rows = [];
        foreach ($attributes as &$attr) {
            $sql_params[$attr] = $this->$attr;
            if ($attr != 'id')
                $sql_rows[] = $attr."=:".$attr;
        }
        $sql_rows = implode(',', $sql_rows);

        $query = $this->bd()->prepare("UPDATE ".$this->tableName()." SET $sql_rows WHERE id = :id");
        return $query->execute($sql_params);
    }

    /**
     * Проверка заполнения модели
     * @return bool
     */
    private function verify()
    {
        foreach ($this->rules() as $rule) {
            if ($rule[1] == "string") {
                foreach ($rule[0] as $key_rule) {
                    $this->$key_rule = htmlspecialchars($this->$key_rule);
                }
            }

            if ($rule[1] == "integer") {
                foreach ($rule[0] as $key_rule) {
                    $this->$key_rule = $this->$key_rule * 1;
                }
            }

            if ($rule[1] == "require") {
                foreach ($rule[0] as $key_rule) {
                    if (!strlen($this->$key_rule)) {
                        $this->error = "Поле \"".$key_rule."\" обязательное для заполнения!";
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Вернем ошибку
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }
}