<?php

namespace App\Models;

use App\Core\Database;

class PacienteGIN
{
    private $db;
    protected $mPac;
    protected $mainTableName = "db_pacientes_gin";
    protected $mainIDName = "pac_cod";
    protected $id;
    public $det;
    public $detAll;

    public function __construct()
    {
        $this->db = new Database();
        $this->mPac = new Paciente();
    }
    function setID($id)
    {
        $this->id = $id;
    }
    public function getMainTableName()
    {
        return $this->mainTableName;
    }
    public function getMainIDName()
    {
        return $this->mainIDName;
    }
    public function getDetAll()
    {
        return $this->detAll;
    }

    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDName})", $this->id);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName} ORDER BY {$this->mainIDName} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
}
