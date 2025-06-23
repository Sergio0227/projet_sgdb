<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\any_table;
use PDO;

class Temperatures
{
    private $db;
    private $temperatures;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->temperatures = new any_table($this->db, 'temperatures', 'id', $this->id);
        } else {
            $this->temperatures = new any_table($this->db, 'temperatures');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->temperatures->fields['element_id'] = $data->element_id;
            $this->temperatures->fields['date'] = $data->date;
            $this->temperatures->fields['temp_mesure'] = $data->temp_mesure;

        }
    }

    public function fetch()
    {
        $res = $this->temperatures->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {

            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = ['temperature' => $row, 'request' => 'GET', 'url' => 'http://localhost/sgdb_api/temperatures?id=' . $row['id']];
            }
            echo json_encode($arr);
        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $row = $this->temperatures->fetchOne();

        if ($row) {
            echo json_encode(['temperature' => $row]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->temperatures->postData();

        if ($id) {
            echo json_encode(array('message' => 'Temperature added', 'request' => array('temperature' => 'GET', 'url' => 'http://localhost/sgdb_api/temperatures?id=' . $id)));
        } else {
            echo json_encode(array('message' => 'Temperature Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->temperatures->fetchOne() && $this->temperatures->putData()) {
            echo json_encode(array('message' => 'Temperature update', 'request' => array('temperature' => 'GET', 'url' => 'http://localhost/sgdb_api/temperatures?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Temperature Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->temperatures->delete()) {
            echo json_encode(array('message' => 'Temperature deleted'));
        } else {
            echo json_encode(array('message' => 'Temperature Not deleted, try again!'));
        }
    }
}