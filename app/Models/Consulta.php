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
    protected $secTableName = "db_consultas_info";
    protected $secIDName = "con_num";
    protected $id;
    protected $idSec;
    protected $idp;
    public $det;
    public $detSec;

    function __construct()
    {
        $this->db = new Database();
        $this->mPac = new Paciente();
    }
    /*
    SETTERS
    */
    public function setID($id)
    {
        $this->id = $id;
    }
    public function setIDsec($id)
    {
        $this->idSec = $id;
    }
    public function setIDp($id)
    {
        $this->idp = $id;
    }
    /*
    GETTERS
    */
    public function getDet()
    {
        return $this->det;
    }
    public function getDetID()
    {
        return $this->det[$this->mainID];
    }
    /*
    FUNCTIONS DATA
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function detSec()
    {
        $this->detSec = $this->db->detRow($this->secTableName, null, "md5({$this->secIDName})", $this->id);
    }
    public function getLastConsPac()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5(pac_cod)", $this->idp, "con_num", "DESC");
    }
    public function getAll()
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
    public function getAllDiag($limit = null)
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
    public function getAllConsultasPacienteDiagnosticos()
    {
        $idc = $this->getDetID();
        if ($idc) $sqlCon = "AND tCon.con_num <> {$idc}";
        else $sqlCon = null;
        $sql = "SELECT 
        t.id,
        t.date AS date,
        CONCAT_WS(' ', COALESCE(t.cod, t.obs), COALESCE(t.nom, NULL)) AS diag 
      FROM (
        SELECT 
          tCon.con_num AS id,
          DATE_FORMAT(tCon.date, '%d %M %Y') AS date,
          tConD.id_diag AS idd,
          tDiag.codigo AS cod,
          tDiag.nombre AS nom,
          tConD.obs AS obs,
          ROW_NUMBER() OVER (PARTITION BY tCon.con_num ORDER BY tConD.id_diag) AS rn
        FROM {$this->mainTable} tCon
        LEFT JOIN db_consultas_diagostico tConD ON tCon.con_num = tConD.con_num
        LEFT JOIN db_diagnosticos tDiag ON tConD.id_diag = tDiag.id_diag
        WHERE MD5(tCon.pac_cod)='{$this->idp}'
        AND tConD.id_diag>0 
        $sqlCon 
      ) t
      WHERE t.rn <= 2
      ORDER BY t.id DESC;";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
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
        $idc = $this->getDetID();
        $this->btnHis['TR'] = (!empty($TR = $this->numCons_Pac_TR())) ? $TR : null;
        $this->btnHis['TRs'] = (!empty($TRs = $this->numCon_Pac_Act($idc))) ? $TRs : null;
        $this->btnHis['idP'] = (!empty($idP = $this->numCon_Pac_prev($idc))) ? md5($idP) : null;
        $this->btnHis['idN'] = (!empty($idN = $this->numCon_Pac_next($idc))) ? md5($idN) : null;
        $this->btnHis['idS'] = (!empty($idS = $this->numCon_Pac_start())) ? md5($idS) : null;
        $this->btnHis['idE'] = (!empty($idE = $this->numCon_Pac_end())) ? md5($idE) : null;
    }

    public function numCons_Pac_TR()
    {
        $val = $this->db->totRowsTab("db_consultas", "md5(pac_cod)", $this->idp);
        return $val;
    }
    public function numCon_Pac_Act($idc)
    {
        $params[] = array(
            array("cond" => "AND", "field" => "md5(pac_cod)", "comp" => "=", "val" => $this->idp),
            array("cond" => "AND", "field" => "con_num", "comp" => '<=', "val" => $idc)
        );
        $val = $this->db->totRowsTabNP("db_consultas", $params);
        return $val;
    }
    public function numCon_Pac_start()
    {
        $val = $this->db->detRow("db_consultas", "con_num", "md5(pac_cod)", $this->idp, "con_num", "ASC")['con_num'] ?? null;
        return $val;
    }
    public function numCon_Pac_end()
    {
        $val = $this->db->detRow("db_consultas", "con_num", "md5(pac_cod)", $this->idp, "con_num", "DESC")['con_num'] ?? null;
        return $val;
    }
    public function numCon_Pac_prev($idc)
    {
        $params[] = array(
            array("cond" => "AND", "field" => "md5(pac_cod)", "comp" => "=", "val" => $this->idp),
            array("cond" => "AND", "field" => "con_num", "comp" => '<', "val" => $idc)
        );
        $val = $this->db->detRowNP("db_consultas", "con_num", $params, 1, "con_num", "DESC")['con_num'] ?? null;
        return $val;
    }
    public function numCon_Pac_next($idc)
    {
        $paramsN[] = array(
            array("cond" => "AND", "field" => "md5(pac_cod)", "comp" => "=", "val" => $this->idp),
            array("cond" => "AND", "field" => "con_num", "comp" => '>', "val" => $idc)
        );
        $val = $this->db->detRowNP("db_consultas", "con_num", $paramsN, 1, "con_num", "ASC")['con_num'] ?? null;
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
    public function updateProximaConsulta($iConDiaPC, $iConTipPC)
    {
        $sql = "UPDATE {$this->mainTable} 
        SET con_diapc=?, con_typvisP=? 
        WHERE md5(con_num)=?";
        $arrayData = array($iConDiaPC, $iConTipPC, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        return $ret;
    }
}
