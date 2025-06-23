<?php

namespace SGDB_API\Models;
use PDO;

class any_table
{

    protected $conn;
    public $table = '';
    public $identName = '';
    public $identValue = '';
    public $fields = [];


    public function __construct($db, $table = '', $identName = '', $identValue = '', $fields = [])
    {
        $this->conn = $db;
        $this->table = $table;
        $this->identName = $identName;
        $this->identValue = $identValue;
        $this->fields = $fields;
    }


    public function fetchAll()
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table);
        $stmt->execute();
        return $stmt;
    }

    public function fetchOne()
    {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $this->identName . ' = ?');
        $stmt->bindParam(1, $this->identValue);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : null;
    }
    
    public function postData()
    {
        $requestPart = '';
        foreach ($this->fields as $key => $value) {
            $requestPart .= ' ' . $key . ' = :' . $key . ',';
        }

        $requestPart = substr($requestPart, 0, -1);

        $stmt = $this->conn->prepare('INSERT INTO ' . $this->table . ' SET ' . $requestPart);

        foreach ($this->fields as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function putData()
    {
        $requestPart = '';
        foreach ($this->fields as $key => $value) {
            $requestPart .= ' ' . $key . ' = :' . $key . ',';
        }
        $requestPart = substr($requestPart, 0, -1);

        $stmt = $this->conn->prepare('UPDATE ' . $this->table . '  SET ' . $requestPart . ' WHERE ' . $this->identName . ' = ' . $this->identValue);
        foreach ($this->fields as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }

        if ($stmt->execute()) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete()
    {

        $stmt = $this->conn->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->identName . ' = ?');
        $stmt->bindParam(1, $this->identValue);

        if ($stmt->execute()) {
            return TRUE;
        }
        return FALSE;
    }


}


