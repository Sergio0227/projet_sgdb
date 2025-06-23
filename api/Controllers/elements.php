<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\any_table;
use PDO;

class Elements
{
    private $db;
    private $element;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->element = new any_table($this->db, 'elements', 'id', $this->id);
        } else {
            $this->element = new any_table($this->db, 'elements');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));

            $this->element->fields['nom'] = $data->nom;
            $this->element->fields['date_mise_function'] = $data->date_mise_function;
            $this->element->fields['capacite'] = $data->capacite;
            $this->element->fields['temp_max'] = $data->temp_max;
            $this->element->fields['temp_min'] = $data->temp_min;
            $this->element->fields['emplacement_id'] = $data->emplacement_id;
            $this->element->fields['qr_code'] = $data->qr_code;
            $this->element->fields['full'] = $data->full;
            $this->element->fields['remarques'] = $data->remarques;
            $this->element->fields['usage_id'] = $data->usage_id;
            $this->element->fields['etat_id'] = $data->etat_id;
            $this->element->fields['type_id'] = $data->type_id;
        }
    }

    public function fetch()
    {
        $res = $this->element->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {

            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = ['element' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/elements?id=' . $row['id']];
            }
            echo json_encode($arr);


        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $row = $this->element->fetchOne();
        if ($row) {
            echo json_encode(value: ['element' => $row]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->element->postData();

        if ($id) {
            echo json_encode(array('message' => 'Element added', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/elements?id=' . $id)));
        } else {
            echo json_encode(array('message' => 'Element Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->element->fetchOne() && $this->element->putData()) {
            echo json_encode(array('message' => 'Element update', 'request' => array('type' => 'GET', 'url' => 'http://localhost/sgdb_api/elements?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Element Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->element->delete()) {
            echo json_encode(array('message' => 'Element deleted'));
        } else {
            echo json_encode(array('message' => 'Element Not deleted, try again!'));
        }
    }
}