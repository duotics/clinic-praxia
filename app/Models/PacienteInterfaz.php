<?php

namespace App\Models;

class PacienteInterfaz extends Paciente
{
    //public $objBtnHis;
    public $datVIN;
    public $objNavLG;
    public $objNavSM;
    public $objNavLPA;
    public $objNavLPB;

    function __construct()
    {
        parent::__construct();
    }

    public function PacienteInterfaz_dataVIN()
    {
        //dep($this->det,"det PACIENTE");
        //dep($this->detF,"detF PACIENTE");
        $this->datVIN = array();
        if ($this->detF['dPac_fullname']) $this->datVIN['nombre'] = array("", $this->detF['dPac_fullname'], "btn-primary");
        if ($this->detF['dPac']['pac_fec']) $this->datVIN['edad'] = array("Edad", $this->detF['dPac_edad']['yF'], "btn-primary", true, $this->detF['dPac']['pac_fec']);
        if (isset($this->detF['typ']['tsan'])) $this->datVIN['tsan'] = array("Sangre", $this->detF['typ']['tsan'], "btn-primary disabled");
        if (isset($this->detF['typ']['eciv'])) $this->datVIN['eciv'] = array("", $this->detF['typ']['eciv'], "btn-primary disabled", true);
        if (isset($this->detF['typ']['sex'])) $this->datVIN['sex'] = array("", $this->detF['typ']['sex'], "btn-primary disabled");
        if (isset($this->detF['dPacSig']['peso'])) $this->datVIN['peso'] = array("Peso (kg)", $this->detF['dPacSig']['peso'], "btn-info disabled");
        if (isset($this->detF['dPacSig']['talla'])) $this->datVIN['talla'] = array("Talla (cm)", $this->detF['dPacSig']['talla'], "btn-info disabled");
        if ($this->detF['IMC']) $this->datVIN['IMC'] = array("", $this->detF['IMC']['min'], $this->detF['IMC']['css'] . " text-light", true);
        if (isset($this->detF['dPacSig']['po2'])) $this->datVIN['po2'] = array("PO2", $this->detF['dPacSig']['po2'], "btn-success disabled");
        if ($this->detF['dPacSig']['co2'] ?? null) $this->datVIN['co2'] = array("CO2", $this->detF['dPacSig']['co2'], "btn-success disabled");
        if ($this->detF['dPac']['pac_dir']) $this->datVIN['dir'] = array("<i class='fas fa-map-marker'></i>", null, "btn-warning", null, $this->detF['dPac']['pac_dir']);
        if ($this->detF['dPac']['pac_tel1']) $this->datVIN['tel1'] = array("<i class='fas fa-phone'></i>", null, "btn-warning", null, $this->detF['dPac']['pac_tel1']);
        if ($this->detF['dPac']['pac_email']) $this->datVIN['email'] = array("<i class='fas fa-envelope'></i>", null, "btn-warning", null, $this->detF['dPac']['pac_email']);
    }
    //
    public function PacienteInterfaz_ConsultaNav()
    {
        $this->PacienteInterfaz_dataVIN();
        $this->PacienteInterfaz_ConsultaNav_LG();
        $this->PacienteInterfaz_ConsultaNav_SM();
    }
    public function PacienteInterfaz_ConsultaNav_LG()
    {
        $array = array($this->datVIN['nombre'] ?? null, $this->datVIN['edad'] ?? null);
        $this->objNavLG = $this->PacienteInterfaz_ConsultaNav_PRINT($array);
    }
    public function PacienteInterfaz_ConsultaNav_SM()
    {
        $array = array(
            $this->datVIN['edad'] ?? null, $this->datVIN['sex'] ?? null, $this->datVIN['tsan'] ?? null, $this->datVIN['eciv'] ?? null,
            $this->datVIN['peso'] ?? null, $this->datVIN['talla'] ?? null, $this->datVIN['IMC'] ?? null,
            $this->datVIN['po2'] ?? null, $this->datVIN['co2'] ?? null,
            $this->datVIN['dir'] ?? null, $this->datVIN['tel1'] ?? null, $this->datVIN['email'] ?? null
        );
        $this->objNavSM = $this->PacienteInterfaz_ConsultaNav_PRINT($array);
    }
    //
    public function PacienteInterfaz_PacList()
    {
        $this->PacienteInterfaz_dataVIN();
        $this->PacienteInterfaz_PacList_A();
        $this->PacienteInterfaz_PacList_B();
    }
    public function PacienteInterfaz_PacList_A()
    {
        $array = array($this->datVIN['sex'] ?? null, $this->datVIN['tsan'] ?? null);
        $this->objNavLPA = $this->PacienteInterfaz_ConsultaNav_PRINT($array);
    }
    public function PacienteInterfaz_PacList_B()
    {
        $array = array($this->datVIN['dir'] ?? null, $this->datVIN['tel1'] ?? null, $this->datVIN['email'] ?? null);
        $this->objNavLPB = $this->PacienteInterfaz_ConsultaNav_PRINT($array);
    }
    public function PacienteInterfaz_ConsultaNav_PRINT($array)
    {
        $ret = null;
        foreach ($array as $val) {
            if ($val) {
                $tooltip = null;
                $tooltipCss = null;
                if (!isset($val[2])) $val[2] = "btn-light";
                if (isset($val[3])) $val[3] = "<div class='vr ms-1 me-1'></div>";
                else {
                    $val[3] = null;
                }
                if (isset($val[4])) {
                    $tooltip = "data-bs-toggle='tooltip' data-bs-title='$val[4]'";
                    $tooltipCss = "tooltipC";
                }
                $ret .= " <span class='btn btn-sm $val[2] $tooltipCss' $tooltip> <span class='fw-bold'>$val[0]</span> $val[1] </span> $val[3]";
            }
        }
        return $ret;
    }
    public function PacienteInterfaz_showSearchTerm()
    {
        $ret = null;
        $obj = null;
        if ($this->termBusPac) {
            $obj .= "<div class='alert alert-info alert-dismissible fade show mt-2' id='log' role='alert'>
            Mostrando Su Busqueda: <strong> {$this->termBusPac} </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        echo $obj;
    }
    public function PacienteInterfaz_listBtnEdit($param)
    {
        $ret = null;
        if ($param == "PAC") {
            $ret .= "<a href='" . routeM . "paciente/det/" . $this->detF['idS'] . "' class='btn btn-primary btn-sm'><i class='fas fa-user fa-fw'></i> Ficha</a>";
        }
        if ($param == "CON") {
            $ret .= "<a href='" . routeM . "consulta/det/" . $this->detF['idS'] . "' class='btn btn-primary btn-sm'>
            <i class='fas fa-stethoscope'></i> Consulta</a>";
            $ret .= "<a href='" . routeM . "reserva/det/" . $this->detF['idS'] . "' class='btn btn-primary btn-sm'>
            <i class='fas fa-calendar'></i> Reserva</a>";
        }
        echo $ret;
    }
}
