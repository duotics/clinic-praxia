<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;

class Paciente
{
    private $db;
    protected $mainTable = "db_pacientes";
    protected $secTable = "db_pacientes_nom";
    protected $mainID = "pac_cod";
    protected $secID = "pac_cod";
    protected $id;
    protected $detAll;
    protected $termBus, $cadBus;
    public $TR, $TRt, $TRp, $RSp, $pages;
    public $det, $detF, $detV;
    public function __construct()
    {
        $this->db = new Database();
    }
    function setID($id)
    {
        $this->id = $id;
    }
    public function getMainTableName()
    {
        return $this->mainTable;
    }
    public function getMainIDName()
    {
        return $this->mainID;
    }
    public function getDetAll()
    {
        return $this->detAll;
    }
    public function setTerm($param)
    {
        $this->termBus = $param;
    }
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    function getAll()
    {
        $sql = "SELECT * FROM {$this->mainTable} ORDER BY {$this->mainID} DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getAllMedia()
    {
        $sql = "SELECT * FROM db_cirugias_media WHERE md5(id_cir)='{$this->id}' ORDER BY id DESC";
        $res = $this->db->selectAllSQL($sql);
        return $res;
    }
    function getPacList()
    {
        //echo "function getParList<br>";
        $this->TRt = $this->db->totRowsTab('db_pacientes', '1', '1'); //TOTAL RESULTADOS DE LA TABLA
        //dep($this->TRt,"TRt");
        $this->genCadSearchPac();    //$qry=genCadSearchPac($sbr);
        $RS = $this->db->dbh->prepare($this->cadBus); //BUSCAR RESULTADOS RELACIONADOS A MI BUSQUEDA SI EXISTIERAN
        $RS->setFetchMode(PDO::FETCH_ASSOC);
        $RS->execute();
        $a = $RS->fetch();
        $this->TR = $RS->rowCount(); //TOTAL RESULTADOS DE LA BUSQUEDA
        if ($this->TR > 0) {
            $this->pages = new Paginator;
            $this->pages->items_total = $this->TR;
            $this->pages->mid_range = 8;
            $this->pages->paginate();
            $sql = $this->cadBus . $this->pages->limit;
            $this->RSp = $this->db->dbh->prepare($sql);
            $this->RSp->setFetchMode(PDO::FETCH_ASSOC);
            $this->RSp->execute();
            $this->detAll = $this->RSp->fetchAll();
            $this->TRp = count($this->detAll);
            echo $sql;
        }
    }
    public function searchPacTerm()
    {
        $this->genCadSearchPac();
        $res = $this->db->selectAllSQL($this->cadBus);
        return $res;
    }
    private function genCadSearchPac($list = FALSE, $limit = 100)
    {
        $qry = null;
        if ($this->termBus) {
            $cadBus = fnc_cutblanck($this->termBus);
            $cadBusT = explode(" ", $cadBus);
            $cadBusN = count($cadBusT);
            $sqlBus = array("select" => null, "where" => null);
            if ($list) {
                $sqlBus['select'] = "
                {$this->mainTable}.pac_nom as pac_nom, 
                {$this->mainTable}.pac_ape as pac_ape, 
                {$this->mainTable}.pac_nom as pac_nom, 
                ";
            }
            if ($cadBusN > 1) {
                $sqlBus['select'] = " MATCH ({$this->secTable}.pac_nom, {$this->secTable}.pac_ape) AGAINST ('{$cadBus}') AS score, ";
                $sqlBus['where'] = " AND MATCH ({$this->secTable}.pac_nom, {$this->secTable}.pac_ape) AGAINST ('{$cadBus}') ";
                $sqlBus['order'] = " ORDER BY score DESC ";
            } else {
                $sqlBus['where'] = " AND ({$this->secTable}.pac_nom LIKE '%{$cadBus}%'
                OR {$this->secTable}.pac_ape LIKE '%{$cadBus}%' 
                OR {$this->secTable}.pac_cod LIKE '%{$cadBus}%') ";
                $sqlBus['order'] = " ORDER BY code DESC ";
            }
            $qry = "SELECT 
            {$sqlBus['select']}
            {$this->secTable}.pac_cod AS code, 
            CONCAT_WS(' ', {$this->secTable}.pac_nom, {$this->secTable}.pac_ape) AS value 
            FROM {$this->secTable}
            INNER JOIN {$this->mainTable} ON {$this->secTable}.{$this->secID}={$this->mainTable}.{$this->mainID}
            WHERE 1=1 
            {$sqlBus['where']} 
            {$sqlBus['order']} 
            LIMIT {$limit}";
        } else {
            $qry = "SELECT 
            {$this->mainTable}.{$this->mainID} AS code, 
            CONCAT_WS(' ',{$this->mainTable}.pac_nom, {$this->mainTable}.pac_ape) AS value 
            FROM {$this->mainTable} 
            ORDER BY code DESC LIMIT {$limit}";
        }
        $this->cadBus = $qry;
    }
    private function genCadListPac()
    {
        if ($this->termBus) {
            $cadBus = fnc_cutblanck($this->termBus);
            $cadBusT = explode(" ", $cadBus);
            $cadBusN = count($cadBusT);
            //echo $cadBusN;
            if ($cadBusN > 1) {
                $qry = sprintf(
                    'SELECT *, MATCH (db_pacientes_nom.pac_nom, db_pacientes_nom.pac_ape) AGAINST (%s) AS Score 
				FROM db_pacientes_nom
				INNER JOIN db_pacientes ON db_pacientes.pac_cod=db_pacientes_nom.pac_cod
				WHERE MATCH (db_pacientes_nom.pac_nom, db_pacientes_nom.pac_ape) AGAINST (%s)
				ORDER BY Score DESC ',
                    SSQL($cadBus, 'text'),
                    SSQL($cadBus, 'text')
                );
            } else {
                $qry = sprintf(
                    'SELECT * FROM db_pacientes_nom
				INNER JOIN db_pacientes ON db_pacientes.pac_cod=db_pacientes_nom.pac_cod
				WHERE db_pacientes.pac_nom LIKE %s OR db_pacientes.pac_ape LIKE %s OR db_pacientes.pac_cod LIKE %s ',
                    SSQL('%' . $cadBus . '%', 'text'),
                    SSQL('%' . $cadBus . '%', 'text'),
                    SSQL('%' . $cadBus . '%', 'text')
                );
            }
        } else {
            $qry = 'SELECT * FROM db_pacientes ORDER BY pac_cod DESC';
        }
        $this->cadBus = $qry;
    }
    public function detF()
    {
        $ret = [];
        $this->det();
        $ret = null;
        //dep($this->det);
        if ($this->det) {
            $dPac_edad = edad($this->det['pac_fec']);
            $dPac_img = vImg("data/db/pac/", $this->lastImgPac($this->id));
            $dPacSig = $this->db->detRow("db_signos", null, "md5(pac_cod)", $this->id, "id", "DESC");
            //$typ['tsan']=$this->db->detRow_type($dPac['pac_tipsan'])['VAL'];
            $typ = array(
                "tsan" => $this->db->detRow_type($this->det['pac_tipsan'])['VAL'] ?? null,
                "tsanp" => $this->db->detRow_type($this->det['pac_tipsanpar'])['VAL'] ?? null,
                "eciv" => $this->db->detRow_type($this->det['pac_estciv'])['VAL'] ?? null,
                "sex" => $this->db->detRow_type($this->det['pac_sexo'])['VAL'] ?? null,
                "est" => $this->db->detRow_type($this->det['pac_tipst'])['VAL'] ?? null
            );
            $IMC = calcIMC($dPacSig['peso'] ?? null, $dPacSig['talla'] ?? null);
            $ret = array(
                "id" => $this->det['pac_cod'],
                "idS" => md5($this->det['pac_cod']),
                "dPac" => $this->det,
                "dPac_fullname" => $this->det['pac_nom'] . ' ' . $this->det['pac_ape'],
                "IMC" => $IMC,
                "dPac_edad" => $dPac_edad,
                "dPac_img" => $dPac_img,
                "dPacSig" => $dPacSig,
                "typ" => $typ,
                "dataVIN" => $this->detV
            );
        }
        $this->detF = $ret;
        //dep($this->detF);
    }
    function lastImgPac($param1)
    {
        $ret = null;
        $detPacMed = $this->db->detRow('db_pacientes_media', null, 'md5(cod_pac)', $param1, 'id', 'DESC');
        if ($detPacMed) {
            $detMed = $this->db->detRow('db_media', null, 'id_med', $detPacMed['id_med']);
            $ret = $detMed['file'];
        }
        return $ret;
    }
    public function registrarBusquedaPaciente($idp)
    {
        /* db_pacientes_bus
        Este registro sirve para almacenar las busquedas de pacientes 
        para llenar los signos vitales en el dispositivo mobil
        */
        $LOG = null;
        $vP = FALSE;
        $dPacRegToday = $this->getBusquedaPacienteToday($idp); //Busco si hay un paciente registrado en la fecha actual
        if (!$dPacRegToday) { //Registro la busqueda Si no hay lo registro
            $sql = "INSERT INTO db_pacientes_bus (pac_cod, date, status) VALUES (?,?,?)";
            $params = array($idp, sys['date'], 0);
            $this->db->insertSQL($sql, $params);
        }
    }
    public function getBusquedaPacienteToday($idp)
    {
        $paramsN[] = array(
            array("cond" => "AND", "field" => "pac_cod", "comp" => "=", "val" => $idp),
            array("cond" => "AND", "field" => "date", "comp" => '=', "val" => sys['date'])
        );
        $ret = $this->db->detRowNP('db_pacientes_bus', $paramsN);
        return $ret;
    }
}
