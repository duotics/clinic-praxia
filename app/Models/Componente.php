<?php

namespace App\Models;

use App\Core\Database;

class Componente
{
    private $db;

    protected $mainTable = "dbComponente";
    protected $mainID = "idComp";
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
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }

    public function detComp($comp)
    {
        $dM = $this->db->detRow('db_componentes', null, 'mod_ref', $comp);
        return $dM;
    }
    public function detCompDet($val)
    {
        $sql = "SELECT mod_cod AS ID, mod_nom AS NOM, mod_des AS DES, mod_icon AS ICON, mod_stat AS STATUS
        FROM db_componentes 
        WHERE mod_ref='{$val}'";
        $dM = $this->db->selectSQL($sql);
        return $dM;
    }

    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllListActive()
    {
        return $this->db->detRowGSelA($this->mainTable, $this->mainID, 'mod_nom', 'mod_stat', 1, TRUE, 'mod_nom', 'ASC');
        //$sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        //$res = $this->db->selectAllSQL($sql);
        //return $res;
    }
    function insertComp(string $ref, string $nom, string $des, string $icon)
    {
        $sql = "INSERT INTO {$this->mainTable} (mod_ref, mod_nom, mod_des, mod_icon) 
		VALUES (?,?,?,?)";
        $arrayData = array($ref, $nom, $des, $icon);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateComp(string $id, string $ref, string $nom, string $des, string $icon, int $status)
    {
        $sql = "UPDATE {$this->mainTable} SET mod_ref=?, mod_nom=?, mod_des=?, mod_icon=?, mod_stat=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($ref, $nom, $des, $icon, $status, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteComp(string $id)
    {
        $sql = "DELETE FROM {$this->mainTable} WHERE md5({$this->mainID})='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE {$this->mainTable} SET mod_stat=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
