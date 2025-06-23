<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\any_table;
use PDO;

class Alertes
{
    private $db;
    private $alerte;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->alerte = new any_table($this->db, 'alertes', 'id', $this->id);
        } else {
            $this->alerte = new any_table($this->db, 'alertes');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));

            $this->alerte->fields['temp_id'] = $data->temp_id;
            $this->alerte->fields['urgence'] = $data->urgence;
            $this->alerte->fields['solved'] = $data->solved;
        }
    }

    public function fetch()
    {
        $res = $this->alerte->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {
            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = ['alerte' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/alertes?id=' . $row['id']];
            }
            echo json_encode($arr);
        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $row = $this->alerte->fetchOne();

        if ($row) {
            echo json_encode(['alerte' => $row]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->alerte->postData();

        if ($id) {
            echo json_encode(array('message' => 'Alerte added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/alertes?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Alerte Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->alerte->fetchOne() && $this->alerte->putData()) {
            echo json_encode(array('message' => 'Alerte update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/alertes?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Alerte Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->alerte->delete()) {
            echo json_encode(array('message' => 'Alerte deleted'));
        } else {
            echo json_encode(array('message' => 'Alerte Not deleted, try again!'));
        }
    }
}