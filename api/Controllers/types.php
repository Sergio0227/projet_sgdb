<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\any_table;
use PDO;

class Types
{
    private $db;
    private $types;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->types = new any_table($this->db, 'types', 'id', $this->id);
        } else {
            $this->types = new any_table($this->db, 'types');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->types->fields['libelle'] = $data->libelle;
        }
    }

    public function fetch()
    {
        $res = $this->types->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {

            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = ['type' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/types?id=' . $row['id']];
            }
            echo json_encode($arr);
        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $row = $this->types->fetchOne();

        if ($row) {
            echo json_encode(['type' => $row]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->types->postData();

        if ($id) {
            echo json_encode(array('message' => 'Type added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/types?id=' . $id)));
        } else {
            echo json_encode(array('message' => 'Type Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->types->fetchOne() && $this->types->putData()) {
            echo json_encode(array('message' => 'Type update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/types?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Type Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->types->delete()) {
            echo json_encode(array('message' => 'Type deleted'));
        } else {
            echo json_encode(array('message' => 'Type Not deleted, try again!'));
        }
    }
}