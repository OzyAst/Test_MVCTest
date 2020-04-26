<?php

namespace Ozycast\core;

interface DB
{
    public function connect($config);

    public function sqlColumn($sql);
    public function sqlAll($sql);
    public function insert($table, $rows);
    public function update($table, $rows);

    public function findOne($table, $rows);
    public function findAll($table, $rows);
}