<?php

namespace App\Models;

class ConsultaInterfaz extends Consulta
{
    public $objBtnHis;

    function __construct()
    {
        parent::__construct();
    }

    public function ConsultaInterfaz_nav()
    {
        $list = [
            "id" => "v-pills-hc-tab",
            "data-bs-toggle" => "pill",
            "nom" => "Historia Clinica",
            "icon" => "<i class='fa fa-book fa-lg'></i>"

        ];

        /*
        <button class="nav-link active setTab" id="v-pills-hc-tab" data-bs-toggle="pill" data-bs-target="#v-pills-hc" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
             
        </button>
        <button class="nav-link setTab" id="v-pills-con-tab" data-bs-toggle="pill" data-bs-target="#v-pills-con" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
            <i class="fas fa-user-md fa-lg fa-fw"></i> Consulta
        </button>
        <button class="nav-link setTab" id="v-pills-tra-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tra" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false">
            <i class="fa fa-columns fa-lg"></i> Tratamientos
        </button>
        <button class="nav-link setTab" id="v-pills-exa-tab" data-bs-toggle="pill" data-bs-target="#v-pills-exa" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">
            <i class="fa fa-list-alt fa-lg"></i> Examenes
        </button>
        <button class="nav-link setTab" id="v-pills-cir-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cir" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
            <i class="fa fa-medkit fa-lg"></i> Cirugías
        </button>
        <button class="nav-link setTab" id="v-pills-doc-tab" data-bs-toggle="pill" data-bs-target="#v-pills-doc" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
            <i class="fas fa-file fa-lg"></i> Documentos
        </button>
        <button class="nav-link setTab" id="v-pills-iess-tab" data-bs-toggle="pill" data-bs-target="#v-pills-iess" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
            <i class="fas fa-hospital"></i> IESS
        </button>
        <button class="nav-link setTab" id="v-pills-ant-tab" data-bs-toggle="pill" data-bs-target="#v-pills-ant" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
            <i class="fa fa-history fa-lg"></i> Historia Anterior
        </button>*/
    }
    private function ConsultaINterfaz_nav_list()
    {
    }
    public function ConsultaInterfaz_nav_tab()
    {
    }
    public function ConsultaInterfaz_pacienteLat()
    {
    }
    public function ConsultaInterfaz_ListDiagHist()
    {
        $ret = null;
        $lConDiagHist = $this->getAllConsultasPacienteDiagnosticos();
        if ($lConDiagHist) {
            $ret .= "<table class='table table-sm m-0'>";
            foreach ($lConDiagHist as $dRow) :
                $ret .= "<tr>
						<th><span class='badge bg-light'>{$dRow['date']}</span></th>
						<td>{$dRow['diag']}</td>
					</tr>";
            endforeach;
            $ret .= "</table>";
        }
        return $ret;
    }
    public function ConsultaInterfaz_BotonHistory()
    {
        $ret = null;
        $this->btnHisCon();
        $cont = array("linkS" => null, "linkE" => null, "cssS" => null, "cssE" => null, "cssP" => null, "cssN" => null, "bS" => null, "bE" => null, "bP" => null, "bN" => null); //Arrays content interfaz obj and properties 

        /*
        Conditions 
        */
        if ($this->btnHis['idS'] == $this->id) {
            $cont['cssS'] = 'disabled';
            $cont['cssP'] = 'disabled';
        } else $cont['linkS'] = 'form.php?kc=' . $this->btnHis['idS'];
        if ($this->btnHis['idE'] == $this->id) {
            $cont['cssE'] = 'disabled';
            $cont['cssN'] = 'disabled';
        } else $cont['linkE'] = 'form.php?kc=' . $this->btnHis['idE'];
        $cont['linkP'] = 'form.php?kc=' . $this->btnHis['idP'];
        $cont['linkN'] = 'form.php?kc=' . $this->btnHis['idN'];
        /*
        genInterface 
        */
        $cont['bS'] = "<a href='$cont[linkS]' class='btn btn-outline-secondary text-light btn-sm $cont[cssS]'> <i class='fa fa-fast-backward'></i></a>";
        $cont['bE'] = "<a href='$cont[linkE]' class='btn btn-outline-secondary text-light btn-sm $cont[cssE]'> <i class='fa fa-fast-forward'></i></a>";
        $cont['bP'] = "<a href='$cont[linkP]' class='btn btn-outline-secondary text-light btn-sm $cont[cssP]'> <i class='fa fa-step-backward'></i></a>";
        $cont['bN'] = "<a href='$cont[linkN]' class='btn btn-outline-secondary text-light btn-sm $cont[cssN]'> <i class='fa fa-step-forward'></i></a>";
        if ($this->id) {
            $this->objBtnHis = "<div class='btn-group'>$cont[bS] $cont[bP] <span class='btn btn-outline-light text-light btn-sm'> " . $this->btnHis['TRs'] . " | " . $this->btnHis['TR'] . " </span> $cont[bN] $cont[bE] </div>";
        } else {
            $this->objBtnHis = "<div class='btn-group'> $cont[bS] <span class='btn btn-outline-light text-light btn-sm'> " . $this->btnHis['TRs'] . " | " . $this->btnHis['TR'] . " </span> $cont[bE] </div>";
        }
    }
    public function statusCons($est)
    {
        if ($est == '0') {
            $stat['txt'] = 'Pendiente';
            $stat['inf'] = '<a class="btn disabled btn-info navbar-btn">Pendiente <i class="fa fa-exclamation-circle"></i></a>';
        } else if ($est == '1') {
            $stat['txt'] = 'Tratada';
            $stat['inf'] = '<a class="btn disabled btn-info navbar-btn">Tratada <i class="fa fa-check-square-o"></i></a>';
        } else if ($est == '2') {
            $stat['txt'] = 'Finalizada';
            $stat['inf'] = '<a class="btn disabled btn-danger navbar-btn">Finalizada <i class="fa fa-check-square-o"></i></a>';
        } else if ($est == '3') {
            $stat['txt'] = 'Anulada';
            $stat['inf'] = '<a class="btn disabled btn-danger navbar-btn">Anulada <i class="fa fa-check-square-o"></i></a>';
        } else if ($est == '5') {
            $stat['txt'] = 'Reservada';
            $stat['inf'] = '<a class="btn btn-info navbar-btn">Reservada <i class="fa fa-check-square-o"></i></a>';
        } else if (!$est) {
            $stat['txt'] = 'NO GUARDADA';
            $stat['inf'] = '<a class="btn disabled btn-danger navbar-btn">NO GUARDADA <i class="fa fa-arrow-circle-right"></i></a>';
        }
        return ($stat);
    }
}
