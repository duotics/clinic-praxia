<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Componente;

class Menu
{
    private $db;
    protected $mCom;
    protected $mainTableName = "dbMenu";
    protected $mainIDName = "idMenu";
    protected $mainRefName = "refMenu";
    protected $secTableName = "dbMenuItem";
    protected $secIDName = "idMItem";
    protected $secRefName = "refMItem";
    protected $thirdTableName = "dbMenuItemUser";
    protected $thirdIDName = "idMIUser";
    protected $id;
    protected $idi;
    protected $refMenu;
    protected $refMenuItem;
    protected $det;
    protected $detI;

    function __construct()
    {
        $this->db = new Database();
        $this->mCom = new Componente();
    }
    //SETTERS
    function setID($id)
    {
        $this->id = $id;
    }
    function setIDi($id)
    {
        $this->idi = $id;
    }
    public function setRefMenuItem($val)
    {
        $this->refMenuItem = $val;
    }
    //GETTERS
    public function getMainTableName()
    {
        return $this->mainTableName;
    }
    public function getMainIDName()
    {
        return $this->mainIDName;
    }
    public function getSecTableName()
    {
        return $this->secTableName;
    }
    public function getSecIDName()
    {
        return $this->secIDName;
    }
    function getmainRefName()
    {
        return $this->mainRefName;
    }
    function getsecRefName()
    {
        return $this->secRefName;
    }
    function getDet()
    {
        return $this->det;
    }
    function getDetI()
    {
        return $this->detI;
    }
    /*
    FUNCTIONS DATA SELECTS
    */
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTableName, null, "md5({$this->mainIDName})", $this->id);
    }
    public function detI()
    {
        $this->detI = $this->db->detRow($this->secTableName, null, "md5({$this->secIDName})", $this->idi);
    }
    public function detParam($fiel = 1, $val = 1)
    {
        $this->det = $this->db->detRow($this->mainTableName, null, $fiel, $val);
    }
    public function detIParam($fiel = 1, $val = 1)
    {
        $this->detI = $this->db->detRow($this->secTableName, null, $fiel, $val);
    }
    public function detMenuItemLogin()
    {
        $sql = "SELECT {$this->secTableName}.{$this->secIDName}
        FROM {$this->secTableName}
		INNER JOIN {$this->thirdTableName} ON {$this->secTableName}.idMItem={$this->thirdTableName}.idMItem
		WHERE {$this->thirdTableName}.idUser={$_SESSION['dU']['ID']} AND {$this->secTableName}.refMItem='{$this->refMenuItem}'";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }
    public function detMenuCompData()
    {
        $sql = "SELECT 
        {$this->secTableName}.refMItem AS ref,
        {$this->secTableName}.nomMItem AS nomM,
        {$this->secTableName}.titMItem AS titM,
        {$this->secTableName}.iconMItem AS iconM,
        {$this->mCom->getMainTableName()}.nomComp AS nom,
        {$this->mCom->getMainTableName()}.desComp AS des,
        {$this->mCom->getMainTableName()}.iconComp AS icon

        
        FROM {$this->secTableName}

		LEFT JOIN {$this->mCom->getMainTableName()} ON {$this->secTableName}.idComp={$this->mCom->getMainTableName()}.{$this->mCom->getMainIDName()}
		WHERE {$this->secTableName}.refMItem='{$this->refMenuItem}'";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }

    function getAllMenu($status = null)
    {
        $sqlStatus = null;
        // Si el parámetro $status tiene un valor, lo incluimos en la consulta
        if (isset($status)) {
            $sqlStatus = " WHERE status = {$status}";
        }
        $sql = "SELECT * FROM {$this->mainTableName} {$sqlStatus}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllMenuSelect() //Pending
    {
        $sql = "SELECT * FROM {$this->mainTableName}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getMenuItemsAll()
    {
        $sql = "SELECT * FROM {$this->secTableName}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getMenuItemsByMenuContainer($id)
    {
        if (isset($id)) {
            $sql = "SELECT idMItem as id, refMItem AS ref FROM {$this->secTableName} WHERE idMenu=$id";
            $res = $this->db->selectAllSQL($sql);
            return $res;
        } else {
            return null;
        }
    }

    function getAllMenuItemsContParent($parent = 0, $status = 1)
    {
        $sql = "SELECT * FROM {$this->secTableName} WHERE idMenu={$this->id} AND parentMItem={$parent} AND status={$status}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllMenuItemsParent($parent = 0, $status = 1)
    {
        $sql = "SELECT * FROM {$this->secTableName} WHERE parentMItem={$parent} AND status={$status}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    //DATA for generate Menus navbar
    public function getAllMenuItems_LevelAccess($refMC = null, $idParent = 0)
    {
        $sqlUser = array("join" => null, "where" => null);
        $sqlMenu = array("join" => null, "where" => null);
        $idParent = (int) $idParent;

        if ($_SESSION['dU']['LEVEL'] != 1) {
            $sqlUser['join'] = " INNER JOIN {$this->thirdTableName} ON {$this->secTableName}.{$this->secIDName} = {$this->thirdTableName}.idMItem ";
            $sqlUser['where'] = " AND {$this->thirdTableName}.idUser = {$_SESSION['dU']['ID']}";
        }
        if ($refMC) {
            $sqlMenu['join'] = " INNER JOIN {$this->mainTableName} on {$this->secTableName}.idMenu={$this->mainTableName}.{$this->mainIDName} ";
            $sqlMenu['where'] = " AND {$this->mainTableName}.refMenu = '{$refMC}' ";
        }
        $sql = "SELECT 
        {$this->secTableName}.idMItem as id,
        {$this->secTableName}.idComp as idCom,
        {$this->secTableName}.nomMItem as nom,
        {$this->secTableName}.titMItem as tit,
        {$this->secTableName}.iconMItem as ico,
        {$this->secTableName}.cssMItem as css,
        {$this->secTableName}.csslMItem as cssl,
        {$this->secTableName}.styMItem as sty,
        {$this->secTableName}.precodeMItem as pre,
        {$this->secTableName}.poscodeMItem as pos,
        {$this->secTableName}.linkMItem as link,
        {$this->secTableName}.linktMItem as linkt,
        {$this->secTableName}.ordMItem as ord

        FROM {$this->secTableName} 

        {$sqlUser['join']}
        {$sqlMenu['join']}

        WHERE 1=1 

        {$sqlUser['where']}
        {$sqlMenu['where']}

        AND {$this->secTableName}.parentMItem = {$idParent} 
        AND {$this->secTableName}.status = 1 

        ORDER BY ord ASC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function listaItemsCont($id = null)
    {
        $ret = [];
        if ($id > 0)
            $sqlParam = " WHERE t3.idMenu={$id} ";
        else
            $sqlParam = null;
        $sql = "SELECT 
        t1.idMItem AS id, 
        t1.nomMItem AS nom, 
        t1.refMItem AS ref, 
        t1.titMItem AS tit, 
        t1.linkMItem AS link, 
        t1.iconMItem AS icon, 
        t1.ordMItem as ord, 
        t1.status AS status,
        t2.nomMItem AS nomPadre,
        t3.nomMenu AS nomCont
        FROM {$this->secTableName} t1 
        LEFT JOIN {$this->secTableName} t2 ON t1.parentMItem= t2.{$this->secIDName}
        LEFT JOIN {$this->mainTableName} t3 ON t1.idMenu = t3.{$this->mainIDName}
        {$sqlParam}
        ORDER BY 1 DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    public function selectMenuContenedores($nameSelect = null, $selSelect = null, $idSelect = null, $cssSelect = null)
    {
        $data = $this->db->detRowGSelA($this->mainTableName, $this->mainIDName, 'nomMenu', 'status', '1');
        return $this->db->genSelectA($data, $nameSelect, $selSelect, $cssSelect, null, $idSelect, TRUE, null, '- Menu contenedor -');
    }
    /*
    CRUD OPERATIONS
    */
    function insertMenu(string $nom, string $ref = null, string $stat = null)
    {
        $sql = "INSERT INTO {$this->mainTableName} (nom,ref,stat) VALUES (?,?,?)";
        $arrayData = array($nom, $ref, $stat);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function insertMenuItem(
        int $idC,
        int $idP,
        string $nom,
        string $tit,
        string $icon,
        string $css,
        string $precode,
        string $poscode,
        string $link,
        int $ord,
        int $idM,
        int $stat
    ) {
        $sql = "INSERT INTO {$this->secTableName} (
            men_idc,men_padre,men_nombre,men_tit,men_icon,men_css,
            men_precode,men_postcode,men_link,men_orden,idMod,men_stat
        )VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrayData = array($idC, $idP, $nom, $tit, $icon, $css, $precode, $poscode, $link, $ord, $idM, $stat);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateMenu(int $id, string $nom, string $ref, int $stat)
    {
        $sql = "UPDATE {$this->mainTableName} SET nom=?,ref=?,stat=? 
        WHERE {$this->mainIDName}=? LIMIT 1";
        $arrayData = array($nom, $ref, $stat, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateMenuItem(
        int $id,
        int $idC,
        int $idP,
        string $nom,
        string $tit,
        string $icon,
        string $css,
        string $precode,
        string $poscode,
        string $link,
        int $ord,
        int $idM,
        int $stat
    ) {
        $sql = "UPDATE {$this->secTableName} SET men_idc=?,men_padre=?,men_nombre=?,
        men_tit=?,men_icon=?,men_css=?,men_precode=?,men_postcode=?,men_link=?,
        men_orden=?,idMod=?,men_stat=? 
        WHERE {$this->secIDName}=? LIMIT 1";
        $arrayData = array($idC, $idP, $nom, $tit, $icon, $css, $precode, $poscode, $link, $ord, $idM, $stat, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMenu(string $id)
    {
        $sql = "DELETE FROM {$this->mainTableName} 
        WHERE md5({$this->mainIDName})='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMenuItem(string $id)
    {
        $sql = "DELETE FROM {$this->secTableName} 
        WHERE md5({$this->secIDName})='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function selectMenu(string $id)
    {
        $sql = "SELECT * FROM {$this->mainTableName} 
        WHERE md5({$this->mainIDName})='{$id}' LIMIT 1";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }
    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE {$this->mainTableName} SET stat=? 
        WHERE {$this->mainIDName}=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatusItem(string $id, int $val)
    {
        $sql = "UPDATE {$this->secTableName} SET men_stat=? 
        WHERE {$this->secIDName} =? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    /*
    TOTALS
    */
    public function getTRmainTable()
    {
        return $this->db->totRowsTab($this->mainTableName);
    }
    public function getTRsecTable()
    {
        return $this->db->totRowsTab($this->secTableName);
    }
}