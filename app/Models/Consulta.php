<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Paciente;

class Consulta
{
    private $db;
    protected $mPac;
    public $btnHis;
    protected $mainTable = "db_consultas";
    protected $mainID = "con_num";
    protected $id;
    protected $idp;
    protected $termBus, $cadBus;
    public $TR, $TRt, $TRp, $RSp, $pages;
    public $det, $detF, $detV;
    function __construct()
    {
        $this->db = new Database();
        $this->mPac = new Paciente();
    }
    /*
    SETTERS
    */
    function setID($id)
    {
        $this->id = $id;
    }
    function setIDp($id)
    {
        $this->idp = $id;
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
    public function getLastConsPac()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5(pac_cod)", $this->idp, "con_num", "DESC");
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllConsultasPaciente()
    {
        $sql = "SELECT * FROM {$this->mainTable}
        WHERE md5(pac_cod)='{$this->idp}'
        ORDER BY con_num DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
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
    public function btnHisCon()
    {
        $this->btnHis['TR'] = (!empty($this->numCons_Pac_TR())) ? ($this->numCons_Pac_TR()) : null;
        $this->btnHis['TRs'] = (!empty($this->numCon_Pac_Act())) ? ($this->numCon_Pac_Act()) : null;
        $this->btnHis['idS'] = (!empty($this->numCon_Pac_start())) ? md5($this->numCon_Pac_start()) : null;
        $this->btnHis['idE'] = (!empty($this->numCon_Pac_end())) ? md5($this->numCon_Pac_end()) : null;
        $this->btnHis['idP'] = (!empty($this->numCon_Pac_prev())) ? md5($this->numCon_Pac_prev()) : null;
        $this->btnHis['idN'] = (!empty($this->numCon_Pac_next())) ? md5($this->numCon_Pac_next()) : null;
    }

    public function numCons_Pac_TR()
    {
        $val = $this->db->totRowsTab("db_consultas", "md5(pac_cod)", $this->idp);
        return $val;
    }
    public function numCon_Pac_Act()
    {
        $params[] = array(
            array("cond" => "AND", "field" => "md5(pac_cod)", "comp" => "=", "val" => $this->idp),
            array("cond" => "AND", "field" => "md5(con_num)", "comp" => '<=', "val" => $this->id)
        );
        $val = $this->db->totRowsTabNP("db_consultas", $params);
        return $val;
    }
    public function numCon_Pac_start()
    {
        //$val = $this->db->detRow("db_consultas", null, "md5(pac_cod)", $this->idp, "con_num", "ASC")['con_num'] ?? null;
        $val = $this->db->detRow("db_consultas", "con_num", "md5(pac_cod)", $this->idp, "con_num", "ASC");
        dep($val,"numCon_Pac_start");
        $val=$val['con_num'];
        return $val;
    }
    public function numCon_Pac_end()
    {
        $val = $this->db->detRow("db_consultas", "con_num", "md5(pac_cod)", $this->idp, "con_num", "DESC")['con_num'] ?? null;
        return $val;
    }
    public function numCon_Pac_prev()
    {
        $params[] = array(
            array("cond" => "AND", "field" => "md5(pac_cod)", "comp" => "=", "val" => $this->idp),
            array("cond" => "AND", "field" => "md5(con_num)", "comp" => '<', "val" => $this->id)
        );
        $val = $this->db->detRowNP("db_consultas","con_num", $params, 1, "con_num", "DESC")['con_num'];
        return $val;
    }
    public function numCon_Pac_next()
    {
        $paramsN[] = array(
            array("cond" => "AND", "field" => "md5(pac_cod)", "comp" => "=", "val" => $this->idp),
            array("cond" => "AND", "field" => "md5(con_num)", "comp" => '>', "val" => $this->id)
        );
        $val = $this->db->detRowNP("db_consultas","con_num", $paramsN, 1, "con_num", "ASC")['con_num'] ?? null;
        return $val;
    }
    /*
    CRUD
    */
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
