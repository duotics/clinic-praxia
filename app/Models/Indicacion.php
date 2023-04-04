<?php

namespace App\Models;

use App\Core\Database;

class Indicacion
{
    private $db;

    protected $mainTable = "db_indicaciones";
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
    function getID()
    {
        return $this->id;
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
    function getAllListActive()
    {
        return $this->db->detRowGSelA($this->mainTable, $this->mainID, 'des', 'est', 1, TRUE, 'des', 'ASC');
    }
    public function insertIndicacion($iDes, $iFeat, $iEst)
    {
        $AUD = AUD('Crea Indicación');
        $sql = "INSERT INTO {$this->mainTable} 
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
        $sql = "UPDATE {$this->mainTable} SET des=?, feat=?, est=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($iDes, $iFeat, $iEst, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteIndicacion()
    {
        $sql = "DELETE FROM {$this->mainTable} WHERE md5({$this->mainID})='{$this->id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(int $val)
    {
        $sql = "UPDATE {$this->mainTable} SET est=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeFeature(int $val)
    {
        $sql = "UPDATE {$this->mainTable} SET feat=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
