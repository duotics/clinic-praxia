<?php

namespace App\Models;

use App\Core\Database;

class Media
{
    private $db;

    protected $mainTable = "db_media";
    protected $mainID = "id_med";
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
    function insertMedia(string $file, $des)
    {
        $sql = "INSERT INTO {$this->mainTable} (file, des) VALUES (?,?)";
        $arrayData = array($file, $des);
        $ret = $this->db->insertSQL($sql, $arrayData);
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
