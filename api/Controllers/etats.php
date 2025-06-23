<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\any_table;
use PDO;

class Etats
{
    private $db;
    private $etats;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->etats = new any_table($this->db, 'etats', 'id', $this->id);
        } else {
            $this->etats = new any_table($this->db, 'etats');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->etats->fields['libelle'] = $data->libelle;
        }
    }

    public function fetch()
    {
        $res = $this->etats->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {

            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = ['etat' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/etats?id=' . $row['id']];
            }
            echo json_encode($arr);
        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $row = $this->etats->fetchOne();

        if ($row) {
            echo json_encode(['etat' => $row]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->etats->postData();

        if ($id) {
            echo json_encode(array('message' => 'Etat added', 'request' => array('etat' => 'GET', 'url' => 'http://localhost/sgdb_api/etats?id=' . $id)));
        } else {
            echo json_encode(array('message' => 'Etat Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->etats->fetchOne() && $this->etats->putData()) {
            echo json_encode(array('message' => 'Etat update', 'request' => array('etat' => 'GET', 'url' => 'http://localhost/sgdb_api/etats?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Etat Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->etats->delete()) {
            echo json_encode(array('message' => 'Etat deleted'));
        } else {
            echo json_encode(array('message' => 'Etat Not deleted, try again!'));
        }
    }
}