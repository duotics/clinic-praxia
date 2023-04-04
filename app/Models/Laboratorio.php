<?php

namespace App\Models;

use App\Core\Database;

class Laboratorio
{
    private $db;
    protected $mainTable = "db_laboratorio";
    protected $mainID = "idLab";
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
    public function getAllList()
    {
        $sql = "SELECT {$this->mainID} as sID, nomLab as sVAL FROM {$this->mainTable} WHERE status=1 ORDER BY nomLab ASC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllListActive()
    {
        return $this->db->detRowGSelA($this->mainTable, $this->mainID, 'nomLab', 'STATUS', 1, TRUE, 'nomLab', 'ASC');
    }
    public function insertLaboratorio($iNom, $iDes, $iEst)
    {
        $AUD = AUD('Crea Laboratorio');
        $sql = "INSERT INTO {$this->mainTable} 
        (nomLab, desLab, idAud, status) 
		VALUES (?,?,?,?)";
        $arrayData = array($iNom, $iDes, $iEst, $AUD);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        $id = $ret['val'];
        if ($ret['est'] && $ret['val']) $this->setID(md5($id));
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateLaboratorio($iNom, $iDes, $iEst)
    {
        $this->det();
        $idAud = AUD('Actualización Laboratorio', $this->det['idAud']);
        $sql = "UPDATE {$this->mainTable} SET nomLab=?, desLab=?, status=?, idAud=? 
        WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($iNom, $iDes, $iEst, $idAud, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteLaboratorio()
    {
        $sql = "DELETE FROM {$this->mainTable} WHERE md5({$this->mainID})='{$this->id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(int $val)
    {
        $sql = "UPDATE {$this->mainTable} SET status=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
