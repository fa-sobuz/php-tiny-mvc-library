<?php

namespace App\Models;

use App\Database\Connection;
use App\Models\Traits\Where;
use Exception;


class Model
{
    use Where;


    public function get()
    {
        $this->isTableCalled();

        $this->sql = "SELECT * FROM " . $this->from . " ";

        if ($this->hasOrders()) {
            $this->sql .= "ORDER BY ";
            foreach ($this->orders as $key => $value) {
                $value = strtoupper($value);
                $this->sql .= "{$key} {$value}, ";
            }
        }

        if (!empty($this->orderByDesc)) {
            $this->sql .= "ORDER BY {$this->orderByDesc} DESC ";
        }

        $this->offsetLimit();

        $this->sql = rtrim($this->sql, ', ');

        $stmt = Connection::pdo()->prepare($this->sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        }
        return null;
    }

    public function destroy(string $field, $value, string $operator = '=')
    {
        $this->isTableCalled();

        $isExist = $this->find($field, $value, $operator);
        if ($isExist) {
            $sql = "DELETE FROM {$this->from} WHERE {$field} $operator {$value}";
            try {
                $stmt = Connection::pdo()->prepare($sql);
                $stmt->execute();

            } catch (Exception $exception) {
                throw new Exception("Something went wrong in = " . $exception->getMessage());
            }
        } else {
            return "Sorry Data isn't exist";
        }

    }

    public function create(array $data)
    {
        $this->isTableCalled();

        $this->sql = "INSERT INTO ";

        $keys = array_keys($data);
        $values = array_values($data);

        if (count($keys) > 0) {
            $this->sql .= "$this->from (" . implode(', ', $keys) . ") "
                . "VALUES ('" . implode("', '", $values) . "')";
        }


        try {

            $sql = trim(str_replace('  ', ' ', $this->sql));

            $stmt = Connection::pdo()->prepare($sql);
            return $stmt->execute();
        } catch (Exception $exception) {
            throw new Exception("Something went wrong in = " . $exception->getMessage());
        }

    }

    public function update(array $data)
    {
        $this->isTableCalled();


        $this->sql = "UPDATE {$this->from} SET ";
        foreach ($data as $key => $value) {
            $this->sql .= "{$key} = '{$value}', ";
        }
        $this->sql = rtrim($this->sql, ', ');
        if ($this->hasWhere()) {
            $this->sql .= ' WHERE ' . implode(' ', $this->where);
        }

        try {

            $sql = trim(str_replace('  ', ' ', $this->sql));

            $stmt = Connection::pdo()->prepare($sql);
            return $stmt->execute();
        } catch (Exception $exception) {
            throw new Exception("Something went wrong in = " . $exception->getMessage());
        }

    }

    public function all()
    {
        $this->isTableCalled();

        $this->sql = "SELECT * FROM {$this->from}";

        $stmt = Connection::pdo()->prepare($this->sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        }
        return null;
    }

    public function select()
    {
        $this->isTableCalled();
        $this->isColumnsCalled();

        $this->sql = "SELECT ";

        $this->sql .= implode(', ', $this->columns) . ' ';

        $this->sql .= 'FROM ' . $this->from . ' ';

        if ($this->hasWhere()) {
            $this->sql .= 'WHERE ' . implode(' ', $this->where) . ' ';
        }

        if ($this->hasOrders()) {
            $this->sql .= "ORDER BY ";
            foreach ($this->orders as $key => $value) {
                $value = strtoupper($value);
                $this->sql .= "{$key} {$value}, ";
            }
            $this->sql = rtrim($this->sql, ', ');
        }

        $this->offsetLimit();

        $sql = trim(str_replace('  ', ' ', $this->sql));

        $stmt = Connection::pdo()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        }
        return null;
    }

    public function find(string $field, $value, string $operator = '=')
    {
        $this->isTableCalled();

        $this->sql = "SELECT * FROM {$this->from} WHERE {$field} {$operator} {$value}";
        $stmt = Connection::pdo()->prepare($this->sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        }
        return null;
    }



    private function isTableCalled()
    {
        if (!($this->hasFrom())) {
            throw new Exception("Please provide table name !");
        }
    }

    private function isColumnsCalled()
    {
        if (!($this->hasColumns())) {
            throw new Exception("Please provide columns !");
        }
    }

    private function offsetLimit()
    {
        if ($this->limit > 0) {
            $this->sql .= 'LIMIT ' . $this->limit . ' ';
        }
        if ($this->offset > 0) {
            $this->sql .= 'OFFSET ' . $this->offset . ' ';
        }

    }
}
