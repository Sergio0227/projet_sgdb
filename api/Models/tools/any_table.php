<?php

class AnyTable
{

    protected $conn;
    public $table = '';
    public $identName = '';
    public $identValue = '';
    public $fields = [];

    /* 	
          Constructeur
        ------------
        $db : bases de données -> string
        $table : table -> string
        $identName : nom de la clé primaire (optionnel : uniquement utilisable pour fetchOne et delete)
        $identValue : valeur de la clé primaire (optionnel : uniquement utilisable avec fectOne et delete)
        $fields : noms des champs de la table -> array associatif (optionnel uniquement utilisable avec postData et putData)
    
    */

    public function __construct($db, $table = '', $identName = '', $identValue = '', $fields = [])
    {
        $this->conn = $db;
        $this->table = $table;
        $this->identName = $identName;
        $this->identValue = $identValue;
        $this->fields = $fields;
    }


    //Récupérer tout les enregistrement d'une table
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


