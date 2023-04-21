<?php

namespace App\Models;

use App\Core\Database;

class Laboratorio
{
    private $db;
    protected $mainTableName = "db_laboratorio";
    protected $mainIDname = "idLab";
    protected $id;
    public $det;
    /*
    CONSTRUCT
    */
    public function __construct()
    {
        $this->db = new Database();
    }
    /*
    SETTERS
    */
    public function setID($id)
    {
        $this->id = $id;
    }
    /*
    GETTERS
    */
    public function getID()
    {
        return $this->id;
    }
    public function getMainTableName()
    {
        return $this->mainTableName;
    }
    public function getMainIDname()
    {
        return $this->mainIDname;
    }
    /*
    FUNCTION DATA
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDname})", $this->id);
    }
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName} ORDER BY {$this->mainIDname} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllList()
    {
        $sql = "SELECT {$this->mainIDname} as sID, nomLab as sVAL FROM {$this->mainTableName} WHERE status=1 ORDER BY nomLab ASC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllListActive()
    {
        return $this->db->detRowGSelA($this->mainTableName, $this->mainIDname, 'nomLab', 'STATUS', 1, TRUE, 'nomLab', 'ASC');
    }
    public function getTR()
    {
        return $this->db->totRowsTab($this->mainTableName);
    }
    /*
    CRUD
    */
    public function insertLaboratorio($iNom, $iDes, $iEst)
    {
        $AUD = AUD('Crea Laboratorio');
        $sql = "INSERT INTO {$this->mainTableName} 
        (nomLab, desLab, idAud, status) 
		VALUES (?,?,?,?)";
        $arrayData = array($iNom, $iDes, $iEst, $AUD);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        $id = $ret['val'];
        if ($ret['est'] && $ret['val']) $this->setID(md5($id));
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function updateLaboratorio($iNom, $iDes, $iEst)
    {
        $this->det();
        $idAud = AUD('Actualización Laboratorio', $this->det['idAud']);
        $sql = "UPDATE {$this->mainTableName} SET nomLab=?, desLab=?, status=?, idAud=? 
        WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($iNom, $iDes, $iEst, $idAud, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function deleteLaboratorio()
    {
        $sql = "DELETE FROM {$this->mainTableName} WHERE md5({$this->mainIDname})='{$this->id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function changeStatus(int $val)
    {
        $sql = "UPDATE {$this->mainTableName} SET status=? WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
