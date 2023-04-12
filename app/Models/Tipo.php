<?php

namespace App\Models;

use App\Core\Database;

class Tipo
{
    protected $id;
    protected $db;
    protected $mainTableName = "dbTypes";
    protected $mainIDName = "idType";
    protected $valRefName = "refType";
    protected $valValName = "valType";
    protected $det;
    protected $valRef;
    protected $TR;

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
    public function setValRef($val)
    {
        $this->valRef = $val;
    }
    /*
    GETTERS
    */
    public function getMainTableName()
    {
        return $this->mainTableName;
    }
    public function getMainIDName()
    {
        return $this->mainIDName;
    }
    public function getValRefName()
    {
        return $this->valRefName;
    }
    public function getValValName()
    {
        return $this->valValName;
    }
    public function getDet()
    {
        return $this->det;
    }
    public function getDetID()
    {
        return $this->det[$this->mainIDName];
    }
    public function getDetNom()
    {
        return $this->det['nomType'];
    }
    public function getDetVal()
    {
        return $this->det['valType'];
    }
    public function getTR()
    {
        return $this->TR;
    }
    /*
    FUNCTIONS DATA
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDName})", $this->id);
    }
    public function getSelTipRef($val)
    {
        $sql = "SELECT 
        tM.{$this->mainIDName} AS sID,
        tM.{$this->valValName} AS sVAL
        FROM {$this->getMainTableName()} tM
        WHERE {$this->valRefName} = '{$val}'
        AND status = 1";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllRef($ref = null, $status = null)
    {
        $paramRef = null;
        $paramStatus = null;
        $paramRef = $ref ? "AND refType='{$ref}'" : null;
        $paramStatus = $status ? "AND status='{$status}'" : null;
        $sql = "SELECT * FROM {$this->mainTableName} 
        WHERE 1=1 
        {$paramRef} 
        {$paramStatus}
        ORDER BY {$this->mainIDName} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getTypeVal($param)
    { // GIT *
        $sql = "SELECT {$this->valValName} as VAL 
        FROM {$this->mainTableName} 
        WHERE {$this->mainIDName} = ?";
        $RS = $this->db->dbh->prepare($sql);
        $RS->bindValue(1, $param, \PDO::PARAM_INT);
        $RS->execute();
        $dRS = $RS->fetch();
        return $dRS['VAL'] ?? null;
    }
    /*
    CRUD
    */
    function insertTipo(string $refMod = null, string $refType, string $nomType, string $valType, string $auxType, string $iconType, $status)
    {
        $sql = "INSERT INTO {$this->mainTableName} 
        (refMod, refType, nomType, valType, auxType, iconType, status)
        VALUES (?,?,?,?,?,?,?)";
        $arrayData = array($refMod, $refType, $nomType, $valType, $auxType, $iconType, $status);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function updateTipo(string $refMod = null, string $refType, string $nomType, string $valType, string $auxType, string $iconType, $status)
    {
        $sql = "UPDATE {$this->mainTableName} 
        SET refMod=?, refType=?, nomType=?, valType=?, auxType=?, iconType=?, status=? 
        WHERE {$this->mainIDName}=? 
        LIMIT 1";
        $arrayData = array($refMod, $refType, $nomType, $valType, $auxType, $iconType, $status, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function clonTipo()
    {
    }
    function deleteTipo()
    {
        $sql = "DELETE FROM {$this->mainTableName} WHERE md5({$this->mainIDName})='{$this->id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(int $val)
    {
        $sql = "UPDATE {$this->mainTableName} SET status=? WHERE md5({$this->mainIDName})='{$this->id}' LIMIT 1";
        $arrayData = array($val);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    /*
    TOTALS
    */
    public function getTRmain()
    {
        return $this->db->totRowsTab($this->mainTableName);
    }
}
