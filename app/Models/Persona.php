<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;
use DateTime;

class Persona
{
    private $db;
    protected $id;
    public $det;

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
        $this->det = $this->db->detRow("dbPersona", null, 'md5(idMen)', $this->id);
    }
    public function detParam($fiel = 1, $val = 1)
    {
        $this->det = $this->db->detRow("dbPersona", null, $fiel, $val);
    }

    function getAll()
    {
        $sql = "SELECT * FROM dbPersona";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }


    function getAllRef($ref = null, $status = 1)
    {
        $sql = "SELECT * FROM dbPersona WHERE refType={$ref} status={$status}";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }

    function insertPersona(string $dniPer, string $nomPer, $fecPer, $imgPer)
    {
        //$sql = "INSERT INTO dbPersona (dniPer,nomPer,fecPer,imgPer) VALUES (?,?,?,?)";
        $sql = "INSERT INTO dbPersona (dniPer,nomPer,fecPer,imgPer) 
        VALUES (?,?,?,?) 
        ON DUPLICATE KEY UPDATE 
        idPer = LAST_INSERT_ID(idPer),
        nomPer=?,fecPer=?,imgPer=? ";
        $arrayData = array($dniPer, $nomPer, $fecPer, $imgPer, $nomPer, $fecPer, $imgPer);
        $ret = $this->db->insertSQLR($sql, $arrayData);
        //dep($ret, "insertPersona ret");
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function verPersona(string $dniPer, string $nomPer, string $fecPer, string $imgPer)
    {
        if ($dniPer) {
            $detPerIns = $this->insertPersona($dniPer, $nomPer, $fecPer ?? null, $imgPer ?? null); // $qInsPer=sprintf("INSERT INTO db_personas")
            $idPer = $detPerIns['ret'];
        } else {
            $idPer = null;
        }
        return $idPer;
    }

    function updatePersona(int $id, string $nom, string $fec, string $img)
    {
        $sql = "UPDATE dbPersona SET nomPer=?,fecPer=?,imgPer=? WHERE idPer=? LIMIT 1";
        $arrayData = array($nom, $fec, $img, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }

    function changeStatus(string $id, int $val)
    {
        $sql = "UPDATE dbPersona SET status=? WHERE md5(idPer)=? LIMIT 1";
        $arrayData = array($val, $id);
        $ret = $this->db->updateSQLR($sql, $arrayData);
        vP($ret['est'], $ret['log']);
        return $ret;
    }
}
