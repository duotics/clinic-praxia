<?php

namespace App\Models;

use App\Core\Database;

class Diagnostico
{
    private $db;

    protected $mainTable = "db_diagnosticos";
    protected $mainID = "id_diag";
    protected $id;
    public $det;
    function __construct()
    {
        $this->db = new Database();
    }
    function setID($id)
    {
        $this->id = $id;
    }
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllList()
    {
        $sql = "SELECT id_diag as sID, CONCAT_WS(' ',codigo,nombre) as sVAL FROM db_diagnosticos WHERE estado=1 ORDER BY id_diag ASC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getSearchDiag($q, $limit = 20)
    {
        // Perform the search query using the search term and page number
        $sql = "SELECT {$this->mainID} AS id, CONCAT_WS(' | ', codigo, nombre) AS text
        FROM db_diagnosticos 
        WHERE (nombre LIKE '%$q%' OR codigo LIKE '%$q%') AND {$this->mainID}>1 
        ORDER BY id_diag ASC LIMIT $limit";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
}
