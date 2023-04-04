<?php

namespace App\Models;

use App\Core\Database;

class Signo
{
    private $db;

    protected $mainTable = "db_signos";
    protected $mainID = "id";
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
    public function detParam($param, $value)
    {
        $this->det = $this->db->detRow($this->mainTable, null, $param, $value);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getLastSignPac($idPac)
    {
        return $this->db->detRow($this->mainTable, null, "md5(pac_cod)", $idPac, "id", "DESC");
    }
}
