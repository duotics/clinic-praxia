<?php

namespace App\Core;

use App\Core\Database;
use App\Models\Componente;

class Auth
{
    private $db;
    private $mCom;
    protected $mainTable = "dbUsuario";
    protected $mainID = "idUser";
    protected $loginUsername;
    protected $loginPassword;
    public $detI;

    function __construct()
    {
        $this->db = new Database;
        $this->mCom = new Componente;
    }

    public function setDataLogin($loginUsername, $loginPassword)
    {
        $this->loginUsername = $loginUsername;
        $this->loginPassword = md5($loginPassword);
    }

    protected function verifyUser()
    {
        $sql = "SELECT idUser AS ID, nameUser AS USER, status AS EST, themeUser AS THEME, levelUser AS LEVEL, idAud AS AUD 
        FROM {$this->mainTable}
        WHERE nameUser='{$this->loginUsername}' AND passUser='{$this->loginPassword}'";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }

    protected function detModel($nombreModel)
    {
        $this->detI = $this->db->detRow("db_acl_model", null, 'nomMod', $nombreModel);
        $sql = "SELECT idUser as ID, nomUser as USER, status as EST, 
        idRol as ROL, thmUser as THEME, idAud as AUD FROM db_acl_user WHERE
        nomUser='{$this->loginUsername}' AND passUser='{$this->loginPassword}'";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }

    public function AuthLogin()
    {
        $LOG = null;
        $vL = FALSE;
        $MM_redLS = null;
        $MM_redLF = null;
        if (isset($this->loginUsername)) {
            if (cfg['sys']['acheck'] ?? null) $MM_redLS = cfg['acheck'];
            else $MM_redLS = route['c'] . "com_index";
            $MM_redLF = "index.php";
            $dUser = $this->verifyUser();
            if ($dUser) {
                if ($dUser['EST'] == 1) {
                    session_regenerate_id(true);
                    $_SESSION['Auth'] = TRUE;
                    $_SESSION['dU'] = $dUser;
                    $_SESSION['bsTheme'] = $dUser['THEME'];
                    $vL = TRUE;
                    $LOG .= '<h4>Usuario Identificado</h4>';
                } else $LOG .= '<h4>Usuario Deshabilitado</h4>';
            } else $LOG .= '<h5>Datos de acceso no existen</h5>';
            /* VERIFY LOGIN */
            if ($vL) { //Login TRUE
                $goTo = $MM_redLS;
                $LOGt = cfg['p']['m-ok'];
                $LOGc = cfg['p']['c-ok'];
                $LOGi = route['a'] . cfg['p']['i-ok'];
            } else { //Login False
                $goTo = $MM_redLF;
                $LOGc = cfg['p']['ct-fail'];
                $LOGi = route['a'] . cfg['p']['i-fail'];
            }
            $_SESSION['LOG'] = array('m' => $LOG ?? null, 'c' => $LOGc ?? null, 't' => $LOGt ?? null, 'i' => $LOGi ?? null, 'l' => sys['stime'] ?? null);
            header("Location: " . $goTo);
        }
    }
    function vLogin($mSel = null) //v.0.2 * GIT
    {
        //$mMenu = new Menu;
        $vVL = FALSE;
        $ret = null;
        if (isset($_SESSION['Auth'])) {
            if ($mSel) { //Verifica si buscamos un menu especifico
                $dMenu = $this->detILogin($mSel); //Verifica si el usuario logueado tiene acceso al menu
                $dComp = $this->mCom->detCompDet($mSel); //Obtiene los detalles del componente relacionado al menu
                $ret = array_merge((array)$dMenu, (array)$dComp);
            }
            if ((dU['LEVEL'] == 1) || $dMenu) $vVL = TRUE; //access grant if user level = 1 (super admin)
        }
        if (!$vVL){
            header("Location: " . routeM . "login.php");
        }
        return $ret;
    }
    public function detILogin($menu = null)
    {
        $sql = "SELECT * FROM tbl_menus_items 
		INNER JOIN tbl_menus_usuario ON tbl_menus_items.men_id=tbl_menus_usuario.men_id
		LEFT JOIN db_componentes ON db_componentes.mod_cod=tbl_menus_items.mod_cod
		WHERE tbl_menus_usuario.usr_id={$_SESSION['dU']['ID']} 
        AND tbl_menus_items.men_nombre='{$menu}'";
        $ret = $this->db->selectSQL($sql);
        return $ret;
    }
    function vLogin_rev($mSel = NULL)
    { //v.0.2 * GIT
        $dM = null;
        $dC = null;
        if (isset($_SESSION['dU'])) {
            if ($mSel) {
                echo "mSel";
                $dM = $this->db->detRow("db_acl_menu_item", null, "nomMenItem", $mSel);
                dep($dM, "dM");
                if (isset($dM['idMod'])) $dC = $this->db->detRow("db_acl_model", null, "idMod", $dM['idMod']);
                if ($_SESSION['dU']['ROL'] == 1) {
                    echo "Rol SU";
                    $vVM = TRUE;
                    if (!$dM) $LOG = '<div class="alert alert-warning"><h4>Menu "' . $mSel . '" No declarado en menu_items</h4></div>';
                } else {
                    echo "aaa";
                    try {
                        echo "aqui";
                        $idM = $dM['men_id'];
                        $RS = $this->db->dbh->prepare("SELECT * FROM db_acl_menu_usuario 
                        WHERE idUser=:idUser AND men_id=:men_id");
                        $RS->bindValue("idUser", $_SESSION['dU']['ID'], \PDO::PARAM_INT);
                        $RS->bindValue("men_id", $idM, \PDO::PARAM_INT);
                        $RS->setFetchMode(\PDO::FETCH_ASSOC);
                        $RS->execute();
                        $dRS = $row = $RS->fetch();
                    } catch (\PDOException $e) {
                        $LOG = $e->getMessage();
                        dep($LOG, "vLogin");
                        $vVM = FALSE;
                    }
                    if ($dRS) $vVM = TRUE;
                    else $vVM = FALSE;
                }
            } else $vVM = TRUE;
        }
        //BEG Verification Login access
        $MM_restrictGoTo = routeM;
        if (!((isset($_SESSION['dU']['USER'])) && ($vVM))) {
            $MM_qsChar = "Auth/login";
            $MM_referrer = $_SERVER['PHP_SELF'];
            if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
            if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
            $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar; //. "accesscheck=" . urlencode($MM_referrer);
            header("Location: " . $MM_restrictGoTo);
            exit;
        }
        //END Verification Login access
        if ($mSel) return ($dC);
    }
}
