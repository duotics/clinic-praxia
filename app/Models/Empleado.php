<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;

class Empleado
{
    private $db;
    protected $id;
    public $det;

    function __construct()
    {
        $this->db = new Database;
    }

    function setID($id)
    {
        $this->id = $id;
    }

    public function det()
    {
        $this->det = $this->db->detRow("dbEmpleado", null, 'md5(idEmp)', $this->id);
    }

    public function detParam($fiel = 1, $val = 1)
    {
        $this->det = $this->db->detRow("dbEmpleado", null, $fiel, $val);
    }

    function getAll()
    {
        $sql = "SELECT * FROM dbEmpleado";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllDet()
    {
        $sql = "SELECT dbEmpleado.idEmp, dbEmpleado.status, dbPersona.dniPer, dbPersona.nomPer, dbTypes.nomType, dbUsuario.mailUser, dbUsuario.nameUser 
        FROM dbEmpleado 
        LEFT JOIN dbPersona ON dbEmpleado.idPer=dbPersona.idPer 
        LEFT JOIN dbTypes ON dbEmpleado.empTip=dbTypes.idType 
        LEFT JOIN dbUsuario ON dbEmpleado.idEmp=dbUsuario.idEmp
        ORDER BY idEmp DESC;";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllNotIn($id)
    {
        $paramEmp = null;
        if ($id) $paramEmp = "OR dbEmpleado.idEmp={$id}";
        $sql = "SELECT dbEmpleado.idEmp as sID, CONCAT(dbEmpleado.idEmp, ' - ', dbPersona.dniPer, ' ', dbPersona.nomPer) as sVAL 
            FROM dbEmpleado 
            LEFT JOIN dbPersona ON dbEmpleado.idPer=dbPersona.idPer
            WHERE dbEmpleado.idEmp NOT IN (SELECT idEmp FROM dbUsuario WHERE idEmp IS NOT NULL) {$paramEmp}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }


    function getAllTip($tip = null, $status = 1)
    {
        $sql = "SELECT * FROM dbEmpleado WHERE empTip={$tip} status={$status}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function insertEmpleado(string $empTip = null, string $idPer = null, int $idAud = null)
    {
        $sql = "INSERT INTO dbEmpleado (empTip,idPer,idAud) VALUES (?,?,?)";
        $arrayData = array($empTip, $idPer, $idAud);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function updateEmpleado(int $id, int $idPer = null, int $empTip, int $idAud, int $stat)
    {
        $sql = "UPDATE dbEmpleado SET idPer=?, empTip=?, idAud=?, status=? WHERE idEmp=? LIMIT 1";
        $arrayData = array($idPer, $empTip, $idAud, $stat, $id);
        dep($sql, "function updateEmpleado");
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function deleteEmpleado(string $id)
    {
        $sql = "DELETE FROM dbEmpleado WHERE md5(idEmp)='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function selectMenu(string $id)
    {
        $sql = "SELECT * FROM dbEmpleado WHERE md5(idEmp)='{$id}' LIMIT 1";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }

    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE dbEmpleado SET status=? WHERE md5(idEmp)=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
