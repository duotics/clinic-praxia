<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;
use DateTime;

class Usuario
{
    private $db;
    protected $id;
    public $det;
    public $detAll;

    function __construct()
    {
        $this->db = new Database;
    }
    function setID($id)
    {
        $this->id = $id;
    }
    public function det()
    {
        $this->det = $this->db->detRow("dbUsuario", null, 'md5(idMen)', $this->id);
    }
    public function detParam($fiel = 1, $val = 1)
    {
        $this->det = $this->db->detRow("dbPersona", null, $fiel, $val);
    }
    function detAll() //PENDIENTE DESARROLLAR
    {
        $sql = "SELECT dbUsuario.idUser, dbUsuario.idEmp, dbUsuario.mailUser, dbUsuario.nameUser, dbUsuario.levelUser, dbUsuario.themeUser, dbUsuario.imgUser, dbUsuario.status,
        dbPersona.nomPer, dbPersona.dniPer, dbPersona.nomPer, dbPersona.fecPer, dbTypes.nomType FROM dbUsuario 
        LEFT JOIN dbEmpleado ON dbUsuario.idEmp=dbEmpleado.idEmp 
        LEFT JOIN dbPersona ON dbEmpleado.idPer=dbPersona.idPer 
        LEFT JOIN dbTypes ON dbEmpleado.empTip=dbTypes.idType 
        WHERE md5(dbUsuario.idUser)='{$this->id}'";
        //dep($sql);
        $res = $this->db->selectSQL($sql);
        $this->detAll = $res['ret'];
    }
    function getAll()
    {
        $sql = "SELECT * FROM dbUsuario";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function getAllDet()
    {
        $sql = "SELECT dbUsuario.idUser, dbUsuario.mailUser, dbUsuario.nameUser, dbUsuario.levelUser, dbUsuario.status, dbPersona.dniPer, dbPersona.nomPer, dbTypes.nomType 
        FROM dbUsuario 
        LEFT JOIN dbEmpleado ON dbUsuario.idEmp=dbEmpleado.idEmp 
        LEFT JOIN dbPersona ON dbEmpleado.idPer=dbPersona.idPer 
        LEFT JOIN dbTypes ON dbEmpleado.empTip=dbTypes.idType 
        ORDER BY idUser DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function insertUsuario(string $mailUser, string $nameUser, string $passUser, int $levelUser, string $themeUser = null, int $idEmp = null)
    {
        $AUD = AUD(NULL, 'Creación Usuario');
        $sql = "INSERT INTO dbUsuario (idEmp,mailUser,nameUser,passUser,levelUser,themeUser,idAud) VALUES (?,?,?,?,?,?,?)";
        $arrayData = array($idEmp, $mailUser, $nameUser, $passUser, $levelUser, $themeUser, $AUD);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function updateUsuario(string $mailUser, string $nameUser, int $levelUser, $idEmp, string $themeUser = null, int $status = null)
    {
        $this->det();
        $idAud = AUD('Actualización Usuario', $this->det['idAud']);
        $sql = "UPDATE dbUsuario SET idEmp=?, mailUser=?, nameUser=?, levelUser=?, themeUser=?, idAud=?, status=? WHERE md5(idUser)=? LIMIT 1";
        $arrayData = array($idEmp, $mailUser, $nameUser, $levelUser, $themeUser, $idAud, $status, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
    function updateUsuarioProfile(string $mailUser, string $nameUser, string $themeUser = null)
    {
        $this->det();
        $idAud = AUD('Actualización Usuario', $this->det['idAud']);
        $sql = "UPDATE dbUsuario SET mailUser=?, nameUser=?, themeUser=?, idAud=? WHERE md5(idUser)=? LIMIT 1";
        $arrayData = array($mailUser, $nameUser, $themeUser, $idAud, $this->id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function updateUsuarioPass(int $idUser, string $passA, string $passB, int $idAud = 0)
    {
        $ret = null;
        $LOG = null;
        if (($passA) && ($passB)) {
            if ($passA == $passB) {
                $idAud = AUD($idAud, 'Actualización Contraseña');
                $sql = "UPDATE dbUsuario SET passUser=? WHERE idUser=? LIMIT 1";
                $arrayData = array(md5($passA), $idUser);
                $ret = $this->db->updateSQLR($sql, $arrayData);
                $LOG .= $ret['log'];
            } else $LOG .= '<p>CONTRASEÑA NO SE PUDO ACTUALIZAR, no coinciden</p>';
        } else $LOG .= '<p>CONTRASEÑA VACIA</p>';
        vP($ret['est'], $LOG);
        return $ret;
    }

    function updateUsuarioPassPlus($passOld, $passNewA, $passNewB)
    {
        $LOG = null;
        $detUser = detRow('dbUsuario', 'idUser', $_SESSION['dU']['ID']);
        if ($detUser) { //Usuario Valido
            $datUsu_passAnt = $detUser['passUser'];
            if ($datUsu_passAnt == md5($passOld)) { //Contraseña Anterior Correcta
                if ($datUsu_passAnt != md5($passNewA)) { //Contraseña Nueva Difente a la Original
                    if ($passNewA == $passNewB) { //Contraseñas Nuevas Coincidentes
                        //Actualizo Contraseña
                        $passNew = md5($passNewA);
                        $idAud = AUD($detUser['idAud'], 'Cambio Password Usuario');
                        $sql = "UPDATE dbUsuario SET passUser=?, idAud=? WHERE idUser=?";
                        $arrayData = array($passNew, $idAud, $_SESSION['dU']['ID']);
                        $ret = $this->db->updateSQLR($sql, $arrayData);
                        $LOG .= $ret['log'];
                    } else $LOG .= '<h4>LAS CONTRASEÑAS NUEVAS NO COINCIDEN</h4>Intente otra vez'; //Contraseñas no Coinciden
                } else $LOG .= '<h4>LA NUEVA CONTRASEÑA ES IGUAL A LA ANTERIOR</h4>Ingrese una nueva clave'; //Contraseña Anterior Incorrecta
            } else $LOG .= '<h4>CONTRASEÑA ANTERIOR INCORRECTA</h4>Intente otra vez'; //Contraseña Anterior Incorrecta
        } else $LOG .= '<h4>USUARIO NO EXISTE EN EL SISTEMA</h4>'; //Usuario No Existe
        vP($ret['est'], $LOG);
        return $ret;
    }

    function deleteUsuario(string $id)
    {
        $sql = "DELETE FROM dbUsuario WHERE md5(idUser)='{$id}' LIMIT 1";
        $ret = $this->db->deleteSQLR($sql);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE dbUsuario SET status=? WHERE md5(idUser)=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
