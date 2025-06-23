<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\any_table;
use PDO;

class Usages
{
    private $db;
    private $usage;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->usage = new any_table($this->db, 'usages', 'id', $this->id);
        } else {
            $this->usage = new any_table($this->db, 'usages');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->usage->fields['libelle'] = $data->libelle;
        }
    }

    public function fetch()
    {
        $res = $this->usage->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {

            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = ['usage' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/usages?id=' . $row['id']];
            }
            echo json_encode($arr);
        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $row = $this->usage->fetchOne();

        if ($row) {
            echo json_encode(['usage' => $row]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->usage->postData();

        if ($id) {
            echo json_encode(array('message' => 'Usage added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/usages?id=' . $id)));
        } else {
            echo json_encode(array('message' => 'Usage Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->usage->fetchOne() && $this->usage->putData()) {
            echo json_encode(array('message' => 'Usage update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/usages?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Usage Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->usage->delete()) {
            echo json_encode(array('message' => 'Usage deleted'));
        } else {
            echo json_encode(array('message' => 'Usage Not deleted, try again!'));
        }
    }
}