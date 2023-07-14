<?php

class BaseModel extends Database
{
    protected $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }

    public function all($table, $select = ['*'], $orderBys = [], $limit = 10)
    {
        $colums = implode(',', $select);
        $orderByString = implode(' ', $orderBys);
        
        if ($orderByString) {
            $sql = "SELECT $colums FROM $table ORDER BY $orderByString LIMIT $limit";
        } else {
            $sql = "SELECT $colums FROM $table LIMIT $limit";
        }

        $query = $this->_query($sql);
        $data = [];

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function find($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
        $query = $this->_query($sql);

        return mysqli_fetch_assoc($query);
    }

    public function getByQuery($sql)
    {
        $query = $this->_query($sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            array_push($data, $row);
        }

        return $data;
    }

    public function create($table, $data = [])
    {
        $colums = implode(',', array_keys($data));
        
        $values = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data));

        $values = implode(',', array_values($values));

        $sql = "INSERT INTO $table ($colums) VALUES($values)";

        $query = $this->_query($sql);
    }

    public function update($table, $id, $data = [])
    {
        $dataSets = [];
        foreach ($data as $key => $value) {
            $string = $key . " ". "=". " " . "'" . $value . "'";
            array_push($dataSets, $string);
        }
        $dataSetString = implode(',', $dataSets);
        $sql = "UPDATE $table SET $dataSetString WHERE id = $id";

        $query = $this->_query($sql);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";

        $query = $this->_query($sql);
    }

    private function _query($sql)
    {
        return mysqli_query($this->connect, $sql);
    }
}
