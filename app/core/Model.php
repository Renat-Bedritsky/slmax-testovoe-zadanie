<?php

class Model
{
    public $tablename;

    function __construct()
    {
        
    }
    
    // Функция для подключения к базе данных
    function connection($sql)
    {
        $conn = new mysqli('localhost', 'root', '', 'people');
        $string = $conn->query($sql);
        return $string;
    }

    // Функция для получения данных (Всей таблицы или конкретных данных)
    function getList($select = [], $filter = [])
    {
        $sql = 'SELECT ';
        if (!empty($select)) {
            $string = implode(', ', $select);
            $sql .= $string;
        }
        else $sql .= '*';
        $sql .= ' FROM '.$this->tablename;

        if (!empty($filter)) {
            $sql .= ' WHERE ';
            $and = 0;
            foreach ($filter as $key => $value) {
                if ($and == 0) {
                    $sql .= "$key = '$value'";
                    $and = 1;
                }
                else $sql .= " AND $key = '$value'";
            }
        }
        $obj = $this->connection($sql);
        $result = [];

        while ($elem = $obj->fetch_assoc()) {
            array_push($result, $elem);
        }
        return $result;
    }

    // Функция для удаления данных
    function deleteList($filter = [])
    {
        $sql = 'DELETE ';
        $sql .= 'FROM '.$this->tablename;

        if (!empty($filter)) {
            $sql .= ' WHERE ';
            $and = 0;
            foreach ($filter as $key => $value) {
                if ($and == 0) {
                    $sql .= "$key = '$value'";
                    $and = 1;
                }
                else $sql .= " AND $key = '$value'";
            }
        }
        $this->connection($sql);
    }

    // Функция для обновления данных
    function updateList($set = [], $filter = [])
    {
        $sql = 'UPDATE '.$this->tablename.' SET ';

        foreach ($set as $key => $value) {
            $sql .= "$key = '$value'";
        }

        if (!empty($filter)) {
            $sql .= ' WHERE ';
            $and = 0;
            foreach ($filter as $key => $value)
            {
                if ($and == 0) {
                    $sql .= "$key = '$value'";
                    $and = 1;
                }
                else $sql .= " AND $key = '$value'";
            }
        }
        $this->connection($sql);
    }

    // Функция для добавления данных
    function insertList($data = [])
    {
        $sql = 'INSERT INTO '.$this->tablename.' VALUES ';

        $string = implode("', '", $data);
        $sql .= "('$string')";
        $this->connection($sql);
    }

    // Функция для получения последнего id
    function getLine()
    {
        $sql = "SELECT id FROM `$this->tablename` WHERE id = (SELECT max(id) FROM `$this->tablename`)";
        $string = $this->connection($sql);

        $row = $string->fetch_assoc();
        if (empty($row['id'])) $row['id'] = 0;
        return $row['id'];
    }
}
