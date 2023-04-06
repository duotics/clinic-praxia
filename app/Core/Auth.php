<?php

namespace App\Core;

use App\Core\Database;
use App\Models\Usuario;
use App\Models\Componente;
use App\Models\Menu;
use Exception;

class Auth
{
    private $db;
    private $mCom;
    private $mUser;
    private $mMenu;
    protected $mainTable = "dbUsuario";
    protected $mainID = "idUser";
    protected $loginUsername;
    protected $loginPassword;
    public $detI;

    function __construct()
    {
        $this->db = new Database;
        $this->mCom = new Componente;
        $this->mUser = new Usuario;
        $this->mMenu = new Menu;
    }

    public function setDataLogin($loginUsername, $loginPassword)
    {
        $this->loginUsername = $loginUsername;
        $this->loginPassword = md5($loginPassword);
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
            else $MM_redLS = route['c'];
            $MM_redLF = "index.php";
            $dUser = $this->mUser->verifyUser($this->loginUsername, $this->loginPassword);
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
        $vP = FALSE;
        try {
            $vVL = FALSE;
            $ret = null;
            $LOG = null;
            //Verifico si existen autenticacion
            if (isset($_SESSION['Auth'])) {
                if ($mSel) { //Verifica si buscamos un menu especifico
                    $this->mMenu->setRefMenuItem($mSel); //Establezco el valor de REF a buscar en menu item
                    $dMenuAuth = $this->mMenu->detMenuItemLogin(); //Verifica si el usuario logueado tiene acceso al menu
                }
                if ((dU['LEVEL'] == 1) || $dMenuAuth) {
                    $ret=$this->mMenu->detMenuCompData();
                    $vP = TRUE;
                } else {
                    throw new Exception("Acceso no autorizado");
                }
            } else {
                throw new Exception("No se a iniciado sesión");
            }
            $vP = TRUE;
            return $ret;
        } catch (Exception $e) {
            $LOG = $e->getMessage();
            header("Location: " . routeM . "acceso");
        }
        dep($ret);
        vP($vP, $LOG);
    }
}
