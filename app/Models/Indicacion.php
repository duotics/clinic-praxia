<?php

namespace App\Models;

use App\Core\Database;

class Indicacion
{
    private $db;

    protected $mainTableName = "db_indicaciones";
    protected $mainIDname = "idInd";
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
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDname})", $this->id);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName} ORDER BY {$this->mainIDname} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllListActive()
    {
        return $this->db->detRowGSelA($this->mainTableName, $this->mainIDname, 'des', 'est', 1, TRUE, 'des', 'ASC');
    }
    public function getAllSelect()
    {
        $sql = "SELECT 
        {$this->mainIDname} AS sID, 
        tM.indicacion as sVAL 
        FROM {$this->mainTableName} tM
        WHERE status=1 
        ORDER BY tM.feature DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function insertIndicacion($iDes, $iFeat, $iEst)
    {
        $AUD = AUD('Crea Indicación');
        $sql = "INSERT INTO {$this->mainTableName} 
        (des, feat, est) 
		VALUES (?,?,?)";
        $arrayData = array($iDes, $iFeat, $iEst);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        $id = $ret['val'];
        $this->setID(md5($id));
        echo "ID RET INSERTSQLR. $id <br>";
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateIndicacion($iDes, $iFeat, $iEst)
    {
        $this->det();
        $idAud = AUD('Actualización Media', $this->det['idA']);
        $sql = "UPDATE {$this->mainTableName} SET des=?, feat=?, est=? WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($iDes, $iFeat, $iEst, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteIndicacion()
    {
        $sql = "DELETE FROM {$this->mainTableName} WHERE md5({$this->mainIDname})='{$this->id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(int $val)
    {
        $sql = "UPDATE {$this->mainTableName} SET est=? WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeFeature(int $val)
    {
        $sql = "UPDATE {$this->mainTableName} SET feat=? WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
