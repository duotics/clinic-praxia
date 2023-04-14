<?php

namespace App\Models;

use App\Core\Database;

class Tratamiento
{
    private $db;
    protected $mainTable = "db_tratamientos";
    protected $mainID = "idTrat";
    protected $secondTable = "db_tratamientos_detalle";
    protected $secondID = "idTDet";
    protected $id;
    protected $idp;
    public $det;
    function __construct()
    {
        $this->db = new Database();
    }
    /* 
    SETTERS 
    */
    function setID($id)
    {
        $this->id = $id;
    }
    function setIDp($id)
    {
        $this->idp = $id;
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
    public function listadoTratamientosAnteriores()
    {
        $sql = "SELECT * FROM {$this->mainTable} 
        WHERE md5(pac_cod) = '{$this->idp}' 
        AND md5({$this->mainID}) != '{$this->id}' 
        ORDER BY fecha DESC LIMIT 20";
        //dep($sql);
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    public function listTratamientosDetalle($id, $type = null)
    {
        $sqlType = "";
        if ($type && ($type == "M" || $type == "I")) {
            $sqlType = "AND tip='{$type}'";
        }
        $sql = "SELECT * FROM db_tratamientos_detalle 
        WHERE tid='{$id}' {$sqlType} ORDER BY tid DESC , id DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    public function listTratamientosDetalleAll()
    {
        $sql = "
        SELECT 
        td.{$this->secondID} AS id,
        IF(td.idMed IS NOT NULL, CONCAT_WS(' - ', td.generico, td.comercial, td.presentacion), td.indicacion) AS nombre, 
        IF(td.idMed IS NOT NULL, td.cantidad, NULL) AS can, 
        IF(td.idMed IS NOT NULL, 'M', IF(td.idInd IS NOT NULL, 'I', NULL)) AS tipo
        FROM 
        {$this->secondTable} AS td 
        WHERE 
        md5(td.idTrat) = '{$this->id}' AND 
        (td.idMed IS NOT NULL OR td.idInd IS NOT NULL)
        ORDER BY tipo DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
}
