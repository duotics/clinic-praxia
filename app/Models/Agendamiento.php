<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Paciente;

class Agendamiento
{
    private $db;
    protected $mPac;
    protected $mainTable = "db_fullcalendar";
    protected $mainID = "id";
    protected $id;
    public $det;
    function __construct()
    {
        $this->db = new Database();
        $this->mPac = new Paciente();
    }
    //SETTERS
    function setID($id)
    {
        $this->id = $id;
    }
    //GETTERS
    public function getDet()
    {
        return $this->det;
    }
    //FUNCTIONS
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function detResActive()
    {
        $sql = "SELECT * FROM {$this->mainTable} 
        WHERE md5({$this->mainID})='{$this->id}' 
        AND status=1 
        ORDER BY {$this->mainID} DESC LIMIT 1";
        $res = $this->db->selectSQL($sql);
        $this->det = $res;
    }
    public function detParam($field = 1, $val = 1)
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function getLastResPac($idp)
    {
        $sql = "SELECT * FROM {$this->mainTable} 
        WHERE md5(pac_cod)='{$idp}' 
        AND status=1 
        ORDER BY {$this->mainID} DESC LIMIT 1";
        $res = $this->db->selectSQL($sql);
        $this->det = $res;
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getResBeetweenDates($dateBeg, $dateEnd)
    {
        $sql = "SELECT {$this->mainTable}.id AS ID, {$this->mainTable}.pac_cod AS IDP, 
        {$this->mainTable}.fechai AS DATEI, {$this->mainTable}.fechaf AS DATEF,
        {$this->mainTable}.horai AS TIMEI, {$this->mainTable}.horaf AS TIMEF, 
        {$this->mainTable}.obs AS OBS, 
        CONCAT_WS(' ', tPac.pac_nom, tPac.pac_ape) AS NOM,
        tType.typ_nom AS TYPE
        FROM {$this->mainTable} 
        INNER JOIN {$this->mPac->getMainTableName()} tPac ON {$this->mainTable}.pac_cod=tPac.{$this->mPac->getMainIDName()}
        LEFT JOIN db_types tType ON {$this->mainTable}.typ_cod=tType.typ_cod
        WHERE {$this->mainTable}.fechai>='{$dateBeg}' 
        AND {$this->mainTable}.fechaf<='{$dateEnd}' 
        AND {$this->mainTable}.status=1 
        ORDER BY {$this->mainTable}.horai ASC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
}
