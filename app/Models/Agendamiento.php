<?php

namespace App\Models;

use App\Core\Database;

class Agendamiento
{
    private $db;

    protected $mainTable = "db_fullcalendar";
    protected $mainID = "id";
    protected $id;
    protected $termBus, $cadBus;
    public $TR, $TRt, $TRp, $RSp, $pages;
    public $det, $detF, $detV;
    function __construct()
    {
        $this->db = new Database();
    }
    //SETTERS
    function setID($id)
    {
        $this->id = $id;
    }
    public function setTerm($param)
    {
        $this->termBus = $param;
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
        {$this->mainTable}.typ_cod AS TYPE, {$this->mainTable}.obs AS OBS, 
        CONCAT_WS(' ', db_pacientes.pac_nom, db_pacientes.pac_ape) AS NOM
        FROM {$this->mainTable} 
        INNER JOIN db_pacientes ON {$this->mainTable}.pac_cod=db_pacientes.pac_cod
        WHERE {$this->mainTable}.fechai>='{$dateBeg}' AND {$this->mainTable}.fechaf<='{$dateEnd}' AND {$this->mainTable}.est=1 ORDER BY {$this->mainTable}.horai ASC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
}
