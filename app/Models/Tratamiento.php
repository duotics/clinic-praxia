<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Medicamento;
use App\Models\Indicacion;

class Tratamiento
{
    private $db;
    protected $mMed;
    protected $mInd;
    protected $mainTableName = "db_tratamientos";
    protected $mainIDname = "idTrat";
    protected $secTableName = "db_tratamientos_detalle";
    protected $secIDname = "idTDet";
    protected $id;
    protected $idSec;
    protected $idp;
    public $det;
    public $detSec;
    function __construct()
    {
        $this->db = new Database();
        $this->mMed = new Medicamento();
        $this->mInd = new Indicacion();
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
    public function getID()
    {
        return $this->id;
    }
    public function getMainTableName()
    {
        return $this->mainTableName;
    }
    public function getMainIDName()
    {
        return $this->mainIDname;
    }
    /*
    FUNCTIONS DATA
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDname})", $this->id);
    }
    public function detSec()
    {
        $this->det = $this->db->detRow($this->secTableName, null, "md5({$this->secIDname})", $this->idSec);
    }
    public function listadoTratamientos()
    {
        $this->db->dbh->query("SELECT * FROM {$this->mainTableName} WHERE id_paciente = :id_paciente");
        $this->db->dbh->bind(':id_paciente', $this->det['id_paciente']);
        return $this->db->dbh->registros();
    }
    public function listadoTratamientosAnteriores()
    {
        $sql = "SELECT * 
        FROM {$this->mainTableName} 
        WHERE md5(pac_cod) = '{$this->idp}' 
        AND md5({$this->mainIDname}) != '{$this->id}' 
        ORDER BY date DESC LIMIT 20";
        //dep($sql);
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    public function listTratamientosDetalle($id, $type = null)
    {
        $sqlType = "";
        if ($type && ($type == "M" || $type == "I")) {
            $sqlType = "AND tip='{$type}'";
        }
        $sql = "SELECT * FROM db_tratamientos_detalle 
        WHERE tid='{$id}' {$sqlType} ORDER BY tid DESC , id DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    public function listTratamientosDetalleAll()
    {
        $sql = "
        SELECT 
        td.{$this->secIDname} AS id,
        IF(td.idMed IS NOT NULL, CONCAT_WS(' - ', td.generico, td.comercial, td.presentacion), td.indicacion) AS nombre, 
        IF(td.idMed IS NOT NULL, td.cantidad, NULL) AS can, 
        IF(td.idMed IS NOT NULL, 'M', IF(td.idInd IS NOT NULL, 'I', NULL)) AS tipo
        FROM 
        {$this->secTableName} AS td 
        WHERE 
        md5(td.idTrat) = '{$this->id}' AND 
        (td.idMed IS NOT NULL OR td.idInd IS NOT NULL)
        ORDER BY tipo DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }
    public function listTratamientosDetalleForm()
    {
        $sql = "
        SELECT 
        md5(td.{$this->secIDname}) AS ID,
        IF(td.idMed IS NOT NULL, td.generico, NULL) AS GEN, 
        IF(td.idMed IS NOT NULL, td.comercial, NULL) AS COM, 
        IF(td.idMed IS NOT NULL, td.presentacion, NULL) AS PRE, 
        IF(td.idMed IS NOT NULL, td.cantidad, NULL) AS CAN, 
        IF(td.idMed IS NOT NULL, td.numero, NULL) AS NUM, 
        IF(td.idMed IS NOT NULL, td.descripcion, NULL) AS DES, 
        IF(td.idInd IS NOT NULL, td.indicacion, NULL) AS IND, 
        IF(td.idMed IS NOT NULL, 'M', IF(td.idInd IS NOT NULL, 'I', NULL)) AS TIPO
        FROM 
        {$this->secTableName} AS td 
        WHERE 
        md5(td.idTrat) = '{$this->id}' AND 
        (td.idMed IS NOT NULL OR td.idInd IS NOT NULL)
        ORDER BY tipo DESC";
        $ret = $this->db->selectAllSQL($sql);
        return $ret;
    }

    /*
    CRUD
    */
    public function insertTratamiento(
        $idc,
        $idp,
        $iDateP = null,
        $iDiag = null,
        $iObs = null
    ) {
        $sql = "INSERT INTO {$this->mainTableName} 
        (con_num, pac_cod, fechap, diagnostico, obs) VALUES(?,?,?,?,?)";
        $arrayData = array($idc, $idp, $iDateP, $iDiag, $iObs);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function insertTratamientoDetalleVerifyGroup(
        $idMed = null,
        $idInd = null
    ) {
        $idTrat = $this->det[$this->mainIDname];
        if ($idMed) {
            //Verifico si esque el ID MEDICAMENTO SE REFIERE A UN GRUPO
            $this->mMed->setID($idMed);
            $this->mMed->det();
            $dMed = $this->mMed->det;
            $lMG = $this->mMed->getAllMedGroupParent(); //List of Medicamentos group related
            if ($lMG) { //IF GROUP ITEMS ENCOUNTERED
                foreach ($lMG as $dMG) {
                    $ret = $this->insertTratamientoDetalle($idTrat, $dMG['IDM'], null, $dMG['GEN'], $dMG['COM'], $dMG['PRE'], $dMG['CAN'], $dMG['NUM'], $dMG['DES']);
                }
            } else { //ONLY SINGLE PRODUCT
                $ret = $this->insertTratamientoDetalle($idTrat, $dMed['idMed'], null, $dMed['generico'], $dMed['comercial'], $dMed['presentacion'], $dMed['cantidad'], null, $dMed['descripcion']);
            }
        } else if ($idInd) {
            $this->mInd->setID($idInd);
            $this->mInd->det();
            $dInd = $this->mInd->det;
            $ret = $this->insertTratamientoDetalle($idTrat, null, $dInd['idInd'], null, null, null, null, null, null, $dInd['indicacion']);
        }
        return $ret;
    }
    public function insertTratamientoDetalle(
        $idTrat,
        $idMed = null,
        $idInd = null,
        $iGen = null,
        $iCom = null,
        $iPres = null,
        $iCan = null,
        $iNum = null,
        $ides = null,
        $iInd = null
    ) {
        $sql = "INSERT INTO {$this->secTableName} 
        (idTrat, idMed, idInd, generico, comercial, presentacion, cantidad, numero, descripcion, indicacion) 
        VALUES(?,?,?,?,?,?,?,?,?,?)";
        $arrayData = array($idTrat, $idMed, $idInd, $iGen, $iCom, $iPres, $iCan, $iNum, $ides, $iInd);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function updateTratamiento(
        $iDateP = null,
        $iDiag = null,
        $iObs = null
    ) {
        $sql = "UPDATE {$this->mainTableName} 
        fechap = ?, diagnostico = ?, obs = ? 
        WHERE md5({$this->mainIDname})=? 
        LIMIT 1";
        $arrayData = array($iDateP, $iDiag, $iObs, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function updateTratamientoDetalle(
        $iGen = null,
        $iCom = null,
        $iPre = null,
        $iCan = null,
        $iNum = null,
        $iDes = null,
        $iInd = null
    ) {
        $sql = "UPDATE {$this->secTableName} 
        generico=?, comercial=?, presentacion=?, cantidad=?, numero=?, descripcion=?, indicacion=? 
        WHERE md5({$this->secIDname})=? 
        LIMIT 1";
        $arrayData = array($iGen, $iCom, $iPre, $iCan, $iNum, $iDes, $iInd, $this->idSec);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function eliminarTratamiento()
    {
        $sql = "DELETE FROM {$this->mainTableName} 
        WHERE md5({$this->mainIDname})='{$this->id}' 
        LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    public function eliminarTratamientoDetalle()
    {
        $sql = "DELETE 
        FROM {$this->secTableName}
        WHERE md5({$this->secIDname})='{$this->idSec}' 
        LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
