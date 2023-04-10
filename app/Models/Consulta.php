<?php

namespace App\Models;

use App\Core\Database;

class Consulta
{
    private $db;

    protected $mainTable = "db_consultas";
    protected $mainID = "con_num";
    protected $id;
    protected $termBus, $cadBus;
    public $TR, $TRt, $TRp, $RSp, $pages;
    public $det, $detF, $detV;
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
    public function setTerm($param)
    {
        $this->termBus = $param;
    }
    /*
    GETTERS
    */
    public function getDet()
    {
        return $this->det;
    }
    /*
    FUNCTIONS DATA
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function getLastConsPac($idp)
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5(pac_cod)", $idp, "con_num", "DESC");
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllDiag($limit = null)
    {
        $sqlLimit = "";
        if ((int)$limit > 0) $sqlLimit = "LIMIT {$limit}";
        $sql = "SELECT db_consultas_diagostico.id AS ID, db_diagnosticos.codigo AS COD, CONCAT_WS(' ',db_diagnosticos.nombre, db_consultas_diagostico.obs) AS NOM 
        FROM db_consultas_diagostico 
        INNER JOIN `db_diagnosticos` ON db_consultas_diagostico.id_diag=db_diagnosticos.`id_diag`
        WHERE MD5(con_num)='{$this->id}' ORDER BY id DESC 
        {$sqlLimit}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getConsBeetweenDates($dateBeg, $dateEnd)
    {
        $sql = "SELECT {$this->mainTable}.con_num AS IDC, 
        {$this->mainTable}.pac_cod AS IDP, 
        {$this->mainTable}.con_fec AS FEC, 
        {$this->mainTable}.idAud AS AUD, 
        CONCAT_WS(' ', db_pacientes.pac_nom, db_pacientes.pac_ape) AS NOM
        FROM {$this->mainTable} 
        INNER JOIN db_pacientes ON {$this->mainTable}.pac_cod=db_pacientes.pac_cod
        WHERE con_fec>='{$dateBeg}' AND con_fec<='{$dateEnd}' ORDER BY con_num DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function insertConsultaDiagnostico($idd)
    {
        $this->det();
        $idc = $this->det[$this->mainID];
        $sql = "INSERT INTO db_consultas_diagostico (con_num, id_diag) VALUES(?,?)";
        $arrayData = array($idc, $idd);
        $ret = $this->db->insertSQL($sql, $arrayData);
        return $ret;
    }
    public function insertConsultaDiagnosticoOther($data)
    {
        $this->det();
        $idc = $this->det[$this->mainID];
        $sql = "INSERT INTO db_consultas_diagostico (con_num, id_diag, obs) VALUES(?,?,?)";
        $arrayData = array($idc, "1", $data);
        $ret = $this->db->insertSQL($sql, $arrayData);
        return $ret;
    }
    public function deleteConsultaDiagnostico($idcd)
    {
        $sql = "DELETE FROM db_consultas_diagostico WHERE id='{$idcd}' LIMIT 1";
        $ret = $this->db->deleteSQL($sql);
        return $ret;
    }
}
