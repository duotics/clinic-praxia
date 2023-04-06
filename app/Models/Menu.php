<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;
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
    public $det;
    public $detI;
    public $TR, $TRt, $TRp, $RS, $RSp;
    public $pages;

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
    function setIDi(string $id)
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
    //FUNCTIONS
    public function det()
    {
        $this->det = $this->db->detRow("dbMenu", null, 'md5(idMen)', $this->id);
    }
    public function detI()
    {
        $this->detI = $this->db->detRow("dbMenuItem", null, 'md5(idMenItem)', $this->idi);
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
    public function detMenuCompData(){
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
    function getList() //function to old view data
    {
        $this->TRt = $this->db->totRowsTab('dbMenu', '1', '1'); //TOTAL RESULTADOS DE LA TABLA
        $qry = "SELECT * FROM dbMenu";
        $RS = $this->db->dbh->prepare($qry); //BUSCAR RESULTADOS RELACIONADOS A MI BUSQUEDA SI EXISTIERAN
        $RS->setFetchMode(PDO::FETCH_ASSOC);
        $RS->execute();
        $a = $RS->fetch();
        $this->TR = $RS->rowCount(); //TOTAL RESULTADOS DE LA BUSQUEDA
        if ($this->TR > 0) {
            $this->pages = new Paginator;
            $this->pages->items_total = $this->TR;
            $this->pages->mid_range = 8;
            $this->pages->paginate();
            $this->RSp = $this->db->dbh->prepare($qry . $this->pages->limit);
            $this->RSp->execute();
            $this->TRp = $this->RSp->rowCount();
        }
    }
    function getListI($idMC = null)
    {
        $this->TRt = $this->db->totRowsTab('dbMenuItem', '1', '1'); //TOTAL RESULTADOS DE LA TABLA
        $qry = "SELECT * FROM dbMenuItem";
        $RS = $this->db->dbh->prepare($qry); //BUSCAR RESULTADOS RELACIONADOS A MI BUSQUEDA SI EXISTIERAN
        $RS->setFetchMode(PDO::FETCH_ASSOC);
        $RS->execute();
        $a = $RS->fetch();
        $this->TR = $RS->rowCount(); //TOTAL RESULTADOS DE LA BUSQUEDA
        if ($this->TR > 0) {
            $this->pages = new Paginator;
            $this->pages->items_total = $this->TR;
            $this->pages->mid_range = 8;
            $this->pages->paginate();
            $this->RS = $this->db->dbh->prepare($qry . $this->pages->limit);
            $this->RS->execute();
            $this->TRp = $this->RS->rowCount();
        }
    }
    function getAllMenu()
    {
        $sql = "SELECT * FROM dbMenu";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllMenuItems()
    {
        $sql = "SELECT * FROM dbMenuItem";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllMenuItemsContParent($parent = 0, $status = 1)
    {
        $sql = "SELECT * FROM dbMenuItem WHERE idMenu={$this->id} AND parentMItem={$parent} AND status={$status}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllMenuItemsParent($parent = 0, $status = 1)
    {
        $sql = "SELECT * FROM dbMenuItem WHERE parentMItem={$parent} AND status={$status}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    //DATA for generate Menus navbar
    public function getAllMenuItems_LevelAccess($refMC = null, $idParent = 0)
    {
        $sqlUser = array("join" => null, "where" => null);
        $sqlMenu = array("join" => null, "where" => null);
        $idParent = (int)$idParent;

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
        $qryParam = null;
        $ret = [];
        if (($id) && ($id > 0)) $qryParam = " WHERE idMen={$id} ";
        $sql = "SELECT idMenItem, nomMenItem, linkMenuItem, titMenItem FROM dbMenuItem " . $qryParam;
        $res = $this->db->selectAllSQL($sql);
        if ($res) {
            foreach ($res as $val) {
                array_push($ret, array("id" => $val['idMenItem'], "text" => $val['nomMenItem'], "link" => $val['linkMenuItem'], "tit" => $val['titMenItem']));
            }
        }
        $ret = array("results" => $ret);
        return $ret;
    }
    function insertMenu(string $nom, string $ref = null, string $stat = null)
    {
        $sql = "INSERT INTO dbMenu (nom,ref,stat) VALUES (?,?,?)";
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
        $sql = "INSERT INTO dbMenuItem (
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
        $sql = "UPDATE dbMenu SET nom=?,ref=?,stat=? WHERE id=? LIMIT 1";
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
        $sql = "UPDATE dbMenuItem SET men_idc=?,men_padre=?,men_nombre=?,
        men_tit=?,men_icon=?,men_css=?,men_precode=?,men_postcode=?,men_link=?,
        men_orden=?,idMod=?,men_stat=? WHERE men_id=? LIMIT 1";
        $arrayData = array($idC, $idP, $nom, $tit, $icon, $css, $precode, $poscode, $link, $ord, $idM, $stat, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMenu(string $id)
    {
        $sql = "DELETE FROM dbMenu WHERE md5(id)='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function deleteMenuItem(string $id)
    {
        $sql = "DELETE FROM dbMenuItem WHERE md5(men_id)='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function selectMenu(string $id)
    {
        $sql = "SELECT * FROM dbMenu WHERE md5(idMen)='{$id}' LIMIT 1";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }
    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE dbMenu SET stat=? WHERE id=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function changeStatusItem(string $id, int $val)
    {
        $sql = "UPDATE dbMenuItem SET men_stat=? WHERE men_id =? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
