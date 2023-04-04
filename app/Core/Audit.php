<?php

namespace App\Models;

use App\Core\Database;

class Audit
{
    private $db;
    protected $id;
    protected $mainTable = 'dbAuditoria';
    protected $secTable = 'dbAuditoriaDet';
    protected $mainID = 'idAud';
    protected $secID = 'id';
    public $det;
    public function __construct()
    {
        $this->db = new Database;
    }
    public function setID($id)
    {
        $this->id = $id;
    }
    public function det()
    {
        $this->det = detRow($this->mainTable, $this->mainID, $this->id);
    }
    public function detAud(int $id)
    {
        $sql = "SELECT * FROM {$this->mainTable} WHERE {$this->mainID} ='{$id}' LIMIT 1";
        $ret = $this->selectSQL($sql);
        return $ret;
    }
    public function detAudDet(int $id)
    {
        $sql = "SELECT * FROM {$this->secTable} WHERE id ={$id} LIMIT 1";
        $ret = $this->selectSQL($sql);
        return $ret;
    }
    public function getAllAudDet(int $id)
    {
        $sql = "SELECT * FROM {$this->secTable} WHERE {$this->mainID}={$id}";
        $ret = $this->selectSQL($sql);
        return $ret;
    }
    public function AUD(int $id = null, string $nom = null, string $des = null)
    {
        $idAud = null;
        if ($id) {
            $this->setID($id);
            $this->det();
            if ($this->det) {
                $idAud = $this->det[$this->mainID];
                $this->insertAudDet($idAud, $nom, $des);
            }
        } else {
            $retIns = $this->insertAud();
            $idAud = $retIns['ret'];
            $ret = $this->insertAudDet($idAud, $nom, $des);
        }
        return $idAud;
    }

    private function insertAud()
    {
        $sql = "INSERT INTO {$this->mainTable} (status) VALUES (?)";
        $arrayData = array("1");
        $ret = $this->insertSQLR($sql, $arrayData);
        return $ret;
    }

    private function insertAudDet(string $idAud, string $nomAud, string $desAud = null)
    {
        $sql = "INSERT INTO {$this->secTable} (idAud, idUser, nomAud, desAud) 
        VALUES (?,?,?,?)";
        $arrayData = array($idAud, $_SESSION['dU']['ID'], $nomAud, $desAud);
        $ret = $this->insertSQLR($sql, $arrayData);
        return $ret;
    }
}
