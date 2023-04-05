<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;

class Menu
{
    private $db;
    protected $id;
    protected $idi;
    public $det;
    public $detI;
    public $TR, $TRt, $TRp, $RS, $RSp;
    public $pages;

    function __construct()
    {
        $this->db = new Database();
    }
    function setID($id)
    {
        $this->id = $id;
    }
    function setIDi(string $id)
    {
        $this->idi = $id;
    }
    public function det()
    {
        $this->det = $this->db->detRow("dbMenu", null, 'md5(idMen)', $this->id);
    }
    public function detI()
    {
        $this->detI = $this->db->detRow("dbMenuItem", null, 'md5(idMenItem)', $this->idi);
    }
    public function detILogin($menu = null)
    {
        $sql = "SELECT * FROM dbMenuItem 
		INNER JOIN dbMenuItemUser ON dbMenuItem.idMItem=dbMenuItemUser.idMItem
		LEFT JOIN dbComponente ON dbMenuItem.idComp=dbComponente.idComp
		WHERE dbMenuItemUser.idUser={$_SESSION['dU']['ID']} AND dbMenuItem.nomMItem='{$menu}'";
        dep($sql);
        $ret = $this->db->selectSQLR($sql);
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
    public function getAllMenuParent($refMC)
    {
        $sql = "SELECT * FROM tbl_menus_items 
        INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
        INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
        WHERE tbl_menus.ref = '{$refMC}' 
        AND tbl_menus_items.men_padre = 0 AND tbl_menu_usuario.usr_id = {$_SESSION['dU']['ID']} 
        AND tbl_menus_items.men_stat = 1 
        ORDER BY men_orden ASC";
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
