<?php
namespace SGDB_API\Controllers;

use SGDB_API\config\Db_connect;
use SGDB_API\Models\Emplacement;
use PDO;

class Emplacements
{
    private $db;
    private $emplacements;
    private $id;

    public function __construct()
    {
        $this->db = (new Db_connect())->connect();
        if (isset($_GET['id'])) {
            $this->id = $_GET['id'];
            $this->emplacements = new Emplacement($this->db, 'emplacements', 'id', $this->id);
        } else {
            $this->emplacements = new Emplacement($this->db, 'emplacements');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $this->emplacements->fields['parent_id'] = $data->parent_id;
            $this->emplacements->fields['description'] = $data->description;
        }
    }

    public function fetch()
    {
        $res = $this->emplacements->fetchAll();
        $resCount = $res->rowCount();

        if ($resCount > 0) {

            $arr = array();
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $arr[] = $row;
            }
            $arr = $this->emplacements->buildTree($arr);

            $wrappedArr = [];
            foreach ($arr as $node) {
                $wrappedArr[] = [
                    'request' => $node,
                    'method' => 'GET',
                    'URL' => 'http://localhost/sgdb_api/emplacements.php?id=' . $node['id']
                ];
            }

            echo json_encode($wrappedArr);

        } else {
            echo json_encode(array('message' => "No records found!"));
        }
    }

    public function fetchOne()
    {
        $res = $this->emplacements->fetchAll();
        $arr = [];
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $row;
        }
        $tree = $this->emplacements->buildTree($arr);

        function findNodeById($nodes, $id)
        {
            foreach ($nodes as $node) {
                if ($node['id'] == $id)
                    return $node;
                if (!empty($node['children'])) {
                    $found = findNodeById($node['children'], $id);
                    if ($found)
                        return $found;
                }
            }
            return null;
        }
        $node = findNodeById($tree, $this->id);

        if ($node) {
            echo json_encode([
                'emplacement' => $node
            ]);
        } else {
            echo json_encode(['message' => "No records found!"]);
        }
    }

    public function create()
    {
        $id = $this->emplacements->postData();

        if ($id) {
            echo json_encode(array('message' => 'Emplacement added', 'request' => array('emplacement' => 'GET', 'url' => 'http://localhost/sgdb_api/emplacements?id=' . $id)));
        } else {
            echo json_encode(array('message' => 'Emplacement Not added, try again!'));
        }
    }

    public function update()
    {
        if ($this->emplacements->fetchOne() && $this->emplacements->putData()) {
            echo json_encode(array('message' => 'Emplacement update', 'request' => array('emplacement' => 'GET', 'url' => 'http://localhost/sgdb_api/emplacements?id=' . $this->id)));
        } else {
            echo json_encode(array('message' => 'Emplacement Not updated, try again!'));
        }
    }

    public function delete()
    {
        if ($this->emplacements->delete()) {
            echo json_encode(array('message' => 'Emplacement deleted'));
        } else {
            echo json_encode(array('message' => 'Emplacement Not deleted, try again!'));
        }
    }
}