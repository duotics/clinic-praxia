<?php

namespace App\Models;

use App\Core\Database;

class Tratamiento
{
    private $db;
    protected $mainTable = "db_tratamientos";
    protected $mainID = "tid";
    protected $secondTable = "db_tratamientos_detalle";
    protected $secondID = "id";
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
    function getID()
    {
        return $this->id;
    }
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function listadoTratamientos()
    {
        $this->db->dbh->query("SELECT * FROM {$this->mainTable} WHERE id_paciente = :id_paciente");
        $this->db->dbh->bind(':id_paciente', $this->det['id_paciente']);
        return $this->db->dbh->registros();
    }
    public function listadoTratamientosAnteriores($idp)
    {
        $sql = "SELECT * FROM {$this->mainTable} WHERE pac_cod = '{$idp}' AND md5(tid) != '{$this->id}' ORDER BY fecha DESC LIMIT 5";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    public function listTratamientosDetalle($id, $type = null)
    {
        $sqlType = "";
        if ($type && ($type == "M" || $type == "I")) {
            $sqlType = "AND tip='{$type}'";
        }
        $sql = "SELECT * FROM db_tratamientos_detalle WHERE tid='{$id}' {$sqlType} ORDER BY tip DESC , id DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
}
