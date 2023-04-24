<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Laboratorio;

class Medicamento
{
    private $db;
    protected $mLab;
    protected $mainTableName = "db_medicamentos";
    protected $mainIDname = "idMed";
    protected $secTableName = "db_medicamentos_grp";
    protected $secIDname = "idMG";
    protected $id;
    protected $idSec;
    public $det;
    public $detSec;
    public function __construct()
    {
        $this->db = new Database();
        $this->mLab = new Laboratorio();
    }
    /*
    SETTERS
    */
    public function setID($id)
    {
        $this->id = $id;
    }
    /*
    GETTERS
    */
    public function getID()
    {
        return $this->id;
    }
    /*
    FUNCTIONS DATA SELECT
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDname})", $this->id);
    }
    public function detDet()
    {
        $sql = "SELECT 
        {$this->mainIDname} AS ID, 
        {$this->mainTableName}.generico AS GEN, 
        {$this->mainTableName}.comercial AS COM, 
        {$this->mainTableName}.estado AS STATUS
        FROM {$this->mainTableName}
        WHERE md5({$this->mainIDname})='{$this->id}'
        LIMIT 1";
        $res = $this->db->selectSQL($sql);
        return $res;
    }
    public function detMG($id)
    {
        return $this->db->detRow($this->secTableName, null, "md5({$this->secIDname})", $id);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTableName} ORDER BY {$this->mainIDname} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllLab()
    {
        $sql = "SELECT md5(tM.{$this->mainIDname}) AS ID, 
        db_laboratorio.nomLab AS LAB, 
        tM.generico AS GEN,  
        tM.comercial AS COM,
        tM.presentacion AS PRES, 
        tM.cantidad AS CANT, 
        tM.descripcion AS PRESCRIP, 
        tM.estado AS STATUS
        FROM {$this->mainTableName} tM 
        LEFT JOIN {$this->mLab->getMainTableName()} tL ON tL.{$this->mLab->getMainIDname()}=tM.idLab
        ORDER BY {$this->mainIDname} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllSelect()
    {
        $sql = "SELECT 
        {$this->mainIDname} AS sID, 
        CONCAT_WS(' ',generico,' ( ',comercial,' ) ',' : ',presentacion, cantidad) as sVAL 
        FROM {$this->mainTableName} 
        WHERE status=1 
        OR generico IS NULL 
        OR comercial IS NULL 
        OR presentacion IS NULL 
        OR cantidad IS NULL";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getAllMedGroupParent()
    {
        $sql = "SELECT 
        tMG.idMG AS IDG, 
        tMG.idMedP AS IDP, 
        tMG.idMed AS IDM, 
        tM.generico as GEN, 
        tM.comercial as COM, 
        tM.presentacion as PRE, 
        tM.cantidad as CAN, 
        tM.descripcion as DES
        FROM db_medicamentos_grp tMG
        INNER JOIN {$this->mainTableName} tM ON tMG.idMed=tM.idMed
        WHERE md5(idMedP)='{$this->id}'";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getSearchMed($q, $limit = 20)
    {
        // Perform the search query using the search term and page number
        $sql = "SELECT 
        md5(tM.idMed) AS id,
        CONCAT_WS(' ', tL.nomLab, tM.generico, '(', tM.comercial, ')', tM.presentacion, tM.cantidad) AS text
        FROM {$this->mainTableName} tM
        LEFT JOIN {$this->mLab->getMainTableName()} tL ON tM.idLab= tL.idLab
        WHERE tM.status=1
        AND (generico LIKE '%$q%' OR comercial LIKE '%$q%' OR presentacion LIKE '%$q%' OR descripcion LIKE '%$q%') 
        LIMIT $limit";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function getTR()
    {
        return $this->db->totRowsTab($this->mainTableName);
    }
    /*
    CRUD
    */
    public function insertMedicamento($iLab, $iGen, $iCom, $iPres, $iCan, $iDes, $iEst)
    {
        $AUD = AUD('Crea Medicamento');
        $sql = "INSERT INTO {$this->mainTableName} 
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
        $idParent = $this->det[$this->mainIDname];
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
        $sql = "UPDATE {$this->mainTableName} SET lab=?, generico=?, comercial=?, presentacion=?, cantidad=?, descripcion=?, estado=?, idA=? 
        WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($iLab, $iGen, $iCom, $iPres, $iCan, $iDes, $iEst, $idAud, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function clonMedicamento()
    {
        $sql = "INSERT INTO {$this->mainTableName} (lab, generico, comercial, presentacion, cantidad, descripcion, estado)
        SELECT lab, generico, comercial, presentacion, cantidad, descripcion, estado
        FROM {$this->mainTableName} WHERE md5({$this->mainIDname}) = ?";
        $arrayData = array($this->id);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        $id = $ret['val'];
        $this->setID(md5($id));
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMedicamento()
    {
        $sql = "DELETE FROM {$this->mainTableName} WHERE md5({$this->mainIDname})='{$this->id}' LIMIT 1";
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
        $sql = "UPDATE {$this->mainTableName} SET estado=? WHERE md5({$this->mainIDname})=? LIMIT 1";
        $arrayData = array($val, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
