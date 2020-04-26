<?php
namespace Ozycast\core;

abstract class ActiveRecord
{
    protected $_error = '';

    /**
     * Имя коллекции/таблицы
     * @return mixed
     */
    abstract public static function getTableName(): string;

    public function __construct(array $data = [])
    {
        if (!empty($data))
            $this->serialize($data);
    }

    public function update(array $data = []): bool
    {
        $this->serialize($data);
        if (!$this->verify())
            return false;

        $answer = App::$db->update($this->getTableName(), $this->toArray());
        return $answer;
    }

    public function save(): bool
    {
        if (!$this->verify())
            return false;

        $answer = App::$db->insert($this->getTableName(), $this->toArray());
        return $answer;
    }

    /**
     * Проверка заполнения модели
     * @return bool
     */
    private function verify(): bool
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
                        $this->_error = "Поле \"".$key_rule."\" обязательное для заполнения!";
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public static function find(array $params): ActiveRecord
    {
        $db = App::$db->findOne(static::getTableName(), $params);
        $model = $db ? (new static)->serialize($db) : null;
        return $model;
    }

    public function findAll($params = []): ActiveRecord
    {
        $bd = App::$db->findAll($this->getTableName(), $params);
        return $this->serializeAll($bd);
    }

    public function serialize(array $data): ActiveRecord
    {
        if (empty($data))
            return $this;

        foreach (get_class_vars(get_class($this)) as $key => $param) {
            if (isset($data[$key]))
                $this->$key = $data[$key];
        }

        return $this;
    }

    public function serializeAll(array $datas): ActiveRecord
    {
        if (empty($datas))
            return [];

        $models = [];
        foreach ($datas as $data) {
            $model = (new static)->serialize($data);
            $models[] = $model;
        }

        return $models;
    }

    public function getError(): string
    {
        return $this->_error;
    }

    public function toArray(): array
    {
        $rules = $this->rules();
        $attributes = $rules[0];

        $array = [];
        foreach ($attributes as $key) {
            $array[$key] = $this->$key;
        }

        return $array;
    }
}