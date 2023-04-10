<?php

namespace App\Models;

use \PDO;
use App\Core\Database;
use App\Core\Paginator;
use App\Models\Media;

class Paciente
{
    private $db;
    protected $mMedia;
    protected $mainTable = "db_pacientes";
    protected $secTable = "db_pacientes_nom";
    protected $mainID = "pac_cod";
    protected $secID = "pac_cod";
    protected $mediaTable = "db_pacientes_media";
    protected $mediaID = "id";
    protected $mediaIDRef = "pac_cod";
    protected $id;
    protected $detAll;
    protected $termBus;
    protected $cadBus;
    protected $termBusPac;
    public $TR, $TRt, $TRp, $RSp, $pages;
    public $det, $detF, $detV, $detMedia;
    public function __construct($id = null)
    {
        $this->db = new Database();
        $this->mMedia = new Media();
        if ($id) {
            $this->id = $id;
            $this->det();
        }
    }
    //SETTERS
    function setID($id)
    {
        $this->id = $id;
    }
    public function setTerm($param)
    {
        $this->termBus = $param;
    }
    //GETTERS
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
    public function getDet()
    {
        return $this->det;
    }
    //FUNCIONES
    public function det()
    {
        $this->det = $this->db->detRow($this->mainTable, null, "md5({$this->mainID})", $this->id);
    }
    public function detMediaPac()
    {
        $this->detMedia = $this->db->detRow($this->mediaTable, null, "md5({$this->mediaIDRef})", $this->id);
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
        $this->genCadSearchPac(TRUE);    //$qry=genCadSearchPac($sbr);
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
            //dep($sql,"SQL FINAL PACIENTE");
            $this->RSp = $this->db->dbh->prepare($sql);
            $this->RSp->setFetchMode(PDO::FETCH_ASSOC);
            $this->RSp->execute();
            $this->detAll = $this->RSp->fetchAll();
            $this->TRp = count($this->detAll);
        }
    }
    public function getAllSearchPacTerm()
    {
        $this->genCadSearchPac(false, 100);
        $res = $this->db->selectAllSQL($this->cadBus);
        return $res;
    }
    private function genCadSearchPac($list = FALSE, $limit = null)
    {
        $qry = null;
        $sqlBus = array("select" => null, "where" => null, "limit" => null, "order" => null);

        //SQL LIMIT
        if ($limit) $sqlBus['limit'] = " LIMIT {$limit} ";
        //SQL SELECT MORE DETAILL FIELDS IF $list TRUE
        if ($list) {
            $sqlBus['select'] .= "
            {$this->mainTable}.pac_cod as pac_cod, 
            {$this->mainTable}.pac_ape as pac_ape, 
            {$this->mainTable}.pac_nom as pac_nom, 
            {$this->mainTable}.pac_lugp as pac_lugp, 
            {$this->mainTable}.pac_lugr as pac_lugr, 
            {$this->mainTable}.pac_tel1 as pac_tel1, 
            {$this->mainTable}.pac_tel2 as pac_tel2, 
            {$this->mainTable}.pac_email as pac_email, 
            ";
        }
        //SQL EXISTS TERMBUS
        if ($this->termBus) {
            $cadBus = fnc_cutblanck($this->termBus);
            $cadBusT = explode(" ", $cadBus);
            $cadBusN = count($cadBusT);
            if ($cadBusN > 1) {
                $sqlBus['select'] .= " MATCH ({$this->secTable}.pac_nom, {$this->secTable}.pac_ape) AGAINST ('{$cadBus}') AS score, ";
                $sqlBus['where'] .= " AND MATCH ({$this->secTable}.pac_nom, {$this->secTable}.pac_ape) AGAINST ('{$cadBus}') ";
                $sqlBus['order'] .= " ORDER BY score DESC ";
            } else {
                $sqlBus['where'] .= " AND ({$this->secTable}.pac_nom LIKE '%{$cadBus}%'
                OR {$this->secTable}.pac_ape LIKE '%{$cadBus}%' 
                OR {$this->secTable}.pac_cod LIKE '%{$cadBus}%') ";
                $sqlBus['order'] .= " ORDER BY {$this->secTable}.pac_cod DESC ";
            }
            $qry = "SELECT 
            {$sqlBus['select']}
            MD5({$this->secTable}.pac_cod) AS code, 
            CONCAT_WS(' ', {$this->secTable}.pac_nom, {$this->secTable}.pac_ape) AS value 
            FROM {$this->secTable}
            INNER JOIN {$this->mainTable} ON {$this->secTable}.{$this->secID}={$this->mainTable}.{$this->mainID}
            WHERE 1=1 
            {$sqlBus['where']} 
            {$sqlBus['order']} 
            {$sqlBus['limit']}";
        } else { //SQL NO EXISTS TERMBUS
            $qry = "SELECT 
            {$sqlBus['select']}
            MD5({$this->mainTable}.{$this->mainID}) AS code, 
            CONCAT_WS(' ',{$this->mainTable}.pac_nom, {$this->mainTable}.pac_ape) AS value 
            FROM {$this->mainTable} 
            ORDER BY pac_cod DESC 
            {$sqlBus['limit']}";
        }
        //dep($qry, "genCadSearchPac()");
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
            $dPac_img = vImg("data/db/pac/", $this->getlastImgPac());
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
    function getlastImgPac()
    {
        try {
            $ret = null;
            $this->detMediaPac();
            $detMediaPac = $this->detMedia;
            if ($detMediaPac) {
                $idMedia = $detMediaPac['id_med'];
                $this->mMedia->setID(md5($idMedia));
                $this->mMedia->det();
                $detMedia = $this->mMedia->det;
                if ($detMedia) {
                    $ret = $detMedia['file'];
                    return $ret;
                }
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function registrarBusquedaPaciente()
    {
        /* db_pacientes_bus
        Este registro sirve para almacenar las busquedas de pacientes 
        para llenar los signos vitales en el dispositivo mobil
        */
        $LOG = null;
        $vP = FALSE;
        $idp = $this->det[$this->mainID];
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
