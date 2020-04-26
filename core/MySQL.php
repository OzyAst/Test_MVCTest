<?php

namespace Ozycast\core;

use \PDO;

class MySQL implements DB
{
    private $db;

    /**
     * @param $config
     * @return $this
     */
    public function connect($config)
    {
        if ($this->db)
            return $this->db;

        $username = $config["MYSQL_USER"];
        $password = $config["MYSQL_PASSWORD"];
        $host = $config["MYSQL_HOST"];
        $db = $config["MYSQL_DB"];

        try {
            $this->db = new PDO("mysql:dbname=$db;host=$host", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (\PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }

        return $this;
    }

    public function insert($table, $rows)
    {
        $sql_params = [];
        foreach ($rows as $key => $attr) {
            $sql_params[":$key"] = $attr;
        }
        $sql_rows = implode(',', array_keys($rows));
        $sql_params_name = implode(',', array_keys($sql_params));

        $query = $this->db->prepare("INSERT INTO $table ($sql_rows) VALUES ($sql_params_name)");
        return $query->execute($sql_params);
    }

    public function update($table, $rows)
    {
        $sql_params = [];
        $sql_rows = [];
        foreach ($rows as $key => $attr) {
            $sql_params[$key] = $attr;
            if ($key != 'id')
                $sql_rows[] = $key." = :".$key;
        }
        $sql_rows = implode(', ', $sql_rows);

        $query = $this->db->prepare("UPDATE $table SET $sql_rows WHERE id = :id");
        return $query->execute($sql_params);
    }

    public function findOne($table, $rows)
    {
        $where = $this->parseAttributesForSelect($rows);
        $query = $this->db->prepare("SELECT * FROM $table" . $where['where']);
        $query->execute($where['rows']);
        return $query->fetch();
    }

    public function findAll($table, $rows)
    {
        $where = $this->parseAttributesForSelect($rows);
        $query = $this->db->prepare("SELECT * FROM $table" . $where['where']);
        $query->execute($where['rows']);
        return $query->fetchAll();
    }

    public function sqlColumn($sql)
    {
        return $this->db->query($sql)->fetchColumn();
    }

    public function sqlAll($sql)
    {
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function parseAttributesForSelect(array $attributes): array
    {
        $where = '';
        $sql_params = [];
        $sql_rows = [];
        foreach ($attributes as $key => $attr) {
            $sql_rows[] = $attr;
            $sql_params[] = $key ." = ?";
        }
        $sql_params = implode(', ', $sql_params);

        if (!empty($attributes))
            $where = ' WHERE ' . $sql_params;

        return ['where' => $where, 'rows' => $sql_rows];
    }
}