<?php

namespace root\ORM;

class orm
{
    private $sql;
    private $where = [];
    private $order = [];
    private $offset;

    public static function query()
    {
        return new static();
    }

    public function getAll()
    {
        $condition = null;
        $condition = $this->addConditions($condition);

        $this->sql = "SELECT * FROM " . $this->getTable() . $condition;

        return $this->execute();
    }

    public function get($what)
    {
        $condition = null;
        $condition = $this->addConditions($condition);

        $this->sql = "SELECT $what FROM " . $this->getTable() . $condition;

        return $this->execute();
    }

    public function create($request)
    {
        $values = '';
        $columns = '';

        foreach ($request as $key => $value) {
            $values .= "'$value'" . ', ';
            $columns .= $key . ', ';
        }

        $this->sql = "INSERT INTO " . $this->getTable() . " (" . substr($columns, 0, -2) . ")" . " VALUES " . "(" . substr($values, 0, -2) .")";

        return $this->execute();
    }

    public function update($data)
    {
        $sets = '';
        foreach ($data as $column => $value) {
            if (!is_int($value)) {
                $value = "'$value'";
            }

            $sets .= "$column = $value";
        }

        $this->sql = "UPDATE " . $this->getTable() . " SET " . $sets . implode(', ', $this->where);

        return $this->execute();
    }

    public function delete()
    {
        $this->sql = "DELETE FROM " . $this->getTable() . $this->where[0];

        return $this->execute();
    }

    public function where($left, $operator, $right)
    {
        if (is_string($right)) {
            $right = "'$right'";
        }
        $this->where[] = " WHERE $left $operator $right";
        return $this;
    }

    public function order($condition)
    {
        $this->order[] = " ORDER BY $condition";
        return $this;
    }

    public function offset($condition)
    {
        $this->offset = " OFFSET $condition";
        return $this;
    }

    public function getTable()
    {
        $table = explode('\\', get_called_class());
         return $table[count($table) - 1];

    }

    public function addConditions($condition)
    {
        !empty($this->where) ? $condition .= $this->where[0] : $condition .= '';
        !empty($this->order) ? $condition .= $this->order : $condition .= '';
        !empty($this->offset) ? $condition .= $this->offset : $condition .= '';

        return $condition;
    }

    public function execute()
    {
        return get_connection()->execute($this->sql);
    }
}