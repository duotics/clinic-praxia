<?php

namespace App\Models;

use App\Core\Database;

class Pais
{
    protected $id;
    protected $db;
    protected $mainTableName = "dbPais";
    protected $mainIDName = "idPais";
    protected $mainValName = "nomPais";
    protected $det;
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
    public function getMainValName()
    {
        return $this->mainValName;
    }
    public function getDet()
    {
        return $this->det;
    }
    public function getDetID()
    {
        return $this->det[$this->mainIDName];
    }
    public function getDetVal()
    {
        return $this->det[$this->mainValName];
    }
    /*
    FUNCTIONS DATA
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDName})", $this->id);
    }
    public function getAllSelect()
    {
        $sql = "SELECT 
        tM.{$this->mainIDName} AS sID,
        tM.{$this->mainValName} AS sVAL
        FROM {$this->getMainTableName()} tM";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    /*
    CRUD
    */
    //EMPTY
    /*
    TOTALS
    */
    public function getTRmain()
    {
        return $this->db->totRowsTab($this->mainTableName);
    }
}
