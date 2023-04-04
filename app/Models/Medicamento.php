<?php

namespace App\Models;

use \PDO;
use App\Core\Database;

class Medicamento
{
    private $db;
    protected $mainTable = "db_medicamentos";
    protected $mainID = "id_form";
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
    function detDet()
    {
        $sql = "SELECT id_form AS ID, {$this->mainTable}.generico AS GEN,  {$this->mainTable}.comercial AS COM, {$this->mainTable}.estado AS STATUS
        FROM {$this->mainTable}
        WHERE md5({$this->mainID})='{$this->id}'
        LIMIT 1";
        $res = $this->db->selectSQL($sql);
        return $res;
    }
    public function detMG($id)
    {
        return $this->db->detRow("db_medicamentos_grp", null, "md5(id)", $id);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllLab()
    {
        $sql = "SELECT md5({$this->mainTable}.id_form) AS ID, db_laboratorio.nomLab AS LAB, {$this->mainTable}.generico AS GEN,  {$this->mainTable}.comercial AS COM,
        {$this->mainTable}.presentacion AS PRES, {$this->mainTable}.cantidad AS CANT, {$this->mainTable}.descripcion AS PRESCRIP, {$this->mainTable}.estado AS STATUS
        FROM {$this->mainTable} 
        LEFT JOIN db_laboratorio ON db_laboratorio.idLab=db_medicamentos.lab
        ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllSelect()
    {
        $sql = "SELECT {$this->mainID} AS sID, CONCAT_WS(' ',generico,' ( ',comercial,' ) ',' : ',presentacion, cantidad) as sVAL 
        FROM {$this->mainTable} WHERE estado=1 OR generico IS NULL OR comercial IS NULL OR presentacion IS NULL OR cantidad IS NULL";
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
    public function insertMedicamento($iLab, $iGen, $iCom, $iPres, $iCan, $iDes, $iEst)
    {
        $AUD = AUD('Crea Medicamento');
        $sql = "INSERT INTO {$this->mainTable} 
        (lab, generico, comercial, presentacion, cantidad, descripcion, estado, idA) 
		VALUES (?,?,?,?,?,?,?,?)";
        $arrayData = array($iLab, $iGen, $iCom, $iPres, $iCan, $iDes, $iEst, $AUD);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        $id = $ret['val'];
        if ($ret['est'] && $ret['val']) $this->setID(md5($id));
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function insertMedicamentoGroup($idm)
    {
        $this->det();
        $idParent = $this->det[$this->mainID];
        $AUD = AUD('Crea Agrupación Medicamentos');
        $sql = "INSERT INTO db_medicamentos_grp (idp, idm) VALUES (?,?)";
        $arrayData = array($idParent, $idm);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateMedicamento($iLab, $iGen, $iCom, $iPres, $iCan, $iDes, $iEst)
    {
        $this->det();
        $idAud = AUD('Actualización Media', $this->det['idA']);
        $sql = "UPDATE {$this->mainTable} SET lab=?, generico=?, comercial=?, presentacion=?, cantidad=?, descripcion=?, estado=?, idA=? 
        WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($iLab, $iGen, $iCom, $iPres, $iCan, $iDes, $iEst, $idAud, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function clonMedicamento()
    {
        $sql = "INSERT INTO {$this->mainTable} (lab, generico, comercial, presentacion, cantidad, descripcion, estado)
        SELECT lab, generico, comercial, presentacion, cantidad, descripcion, estado
        FROM {$this->mainTable} WHERE md5({$this->mainID}) = ?";
        $arrayData = array($this->id);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        $id = $ret['val'];
        $this->setID(md5($id));
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMedicamento()
    {
        $sql = "DELETE FROM {$this->mainTable} WHERE md5({$this->mainID})='{$this->id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMedicamentoGroup(string $id)
    {
        $dM = $this->detMG($id);
        $idMed = md5($dM['idp']);
        $this->setID($idMed);
        $this->det();
        $sql = "DELETE FROM db_medicamentos_grp WHERE md5(id)='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatus(int $val)
    {
        $sql = "UPDATE {$this->mainTable} SET estado=? WHERE md5({$this->mainID})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function gelAllMedGroupParent($id)
    {
        $sql = "SELECT db_medicamentos_grp.id AS IDG, db_medicamentos_grp.idp AS IDP, db_medicamentos_grp.idm AS IDM, 
        {$this->mainTable}.generico as GEN, {$this->mainTable}.comercial as COM, 
        {$this->mainTable}.presentacion as PRE, 
        {$this->mainTable}.cantidad as CAN, 
        {$this->mainTable}.descripcion as DES
        FROM db_medicamentos_grp 
        INNER JOIN {$this->mainTable} ON db_medicamentos_grp.idm={$this->mainTable}.id_form
        WHERE idp={$id}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    public function getSearchMed($q, $limit = 20)
    {
        // Perform the search query using the search term and page number
        $sql = "SELECT {$this->mainID} AS id, CONCAT_WS(' | ', codigo, nombre) AS text
        FROM db_diagnosticos 
        WHERE (nombre LIKE '%$q%' OR codigo LIKE '%$q%') AND {$this->mainID}>1 
        ORDER BY id_diag ASC LIMIT $limit";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
}
