<?php

namespace App\Models;

use App\Core\Database;

class Componente
{
    private $db;

    protected $mainTableName = "dbComponente";
    protected $mainIDName = "idComp";
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
    public function getMainTableName()
    {
        return $this->mainTableName;
    }
    public function getMainIDName()
    {
        return $this->mainIDName;
    }
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDName})", $this->id);
    }
    public function detParam($fiel = 1, $val = 1)
    {
        $this->det = $this->db->detRow($this->mainTableName, null, $fiel, $val);
    }

    public function detComp($comp)
    {
        $dM = $this->db->detRow($this->mainTableName, null, 'mod_ref', $comp);
        return $dM;
    }
    public function detCompDet($val)
    {
        $sql = "SELECT 
        {$this->mainIDName} AS ID, 
        nomComp AS NOM, 
        desComp AS DES, 
        iconComp AS ICON, 
        status AS STATUS
        FROM {$this->mainTableName} 
        WHERE refComp='{$val}'";
        $dM = $this->db->selectSQL($sql);
        return $dM;
    }

    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName} ORDER BY {$this->mainIDName} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllListActive()
    {
        return $this->db->detRowGSelA($this->mainTableName, $this->mainIDName, 'mod_nom', 'mod_stat', 1, TRUE, 'mod_nom', 'ASC');
        //$sql = "SELECT * FROM {$this->mainTableName} ORDER BY {$this->mainIDName} DESC";
        //$res = $this->db->selectAllSQL($sql);
        //return $res;
    }
    function insertComp(string $ref, string $nom, string $des, string $icon)
    {
        $sql = "INSERT INTO {$this->mainTableName} (mod_ref, mod_nom, mod_des, mod_icon) 
		VALUES (?,?,?,?)";
        $arrayData = array($ref, $nom, $des, $icon);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateComp(string $id, string $ref, string $nom, string $des, string $icon, int $status)
    {
        $sql = "UPDATE {$this->mainTableName} SET mod_ref=?, mod_nom=?, mod_des=?, mod_icon=?, mod_stat=? WHERE md5({$this->mainIDName})=? LIMIT 1";
        $arrayData = array($ref, $nom, $des, $icon, $status, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteComp(string $id)
    {
        $sql = "DELETE FROM {$this->mainTableName} WHERE md5({$this->mainIDName})='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE {$this->mainTableName} SET mod_stat=? WHERE md5({$this->mainIDName})=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
