<?php

namespace App\Models;

class ConsultaInterfaz extends Consulta
{
    public $objBtnHis;
    protected $objNavLis;
    protected $objNavTab;
    protected $list;
    protected $tabAct;

    function __construct()
    {
        parent::__construct();
    }
    /*
    GETTERS
    */
    public function getobjNavList()
    {
        return $this->objNavLis;
    }
    public function getobjNavTab()
    {
        return $this->objNavTab;
    }
    public function getTabAct()
    {
        return $this->tabAct;
    }
    /*
    SETTERS
    */
    private function setTabAct()
    {
        $this->tabAct = $_SESSION['tab']['con'] ?? "con-hc";
    }
    /*
    FAT
    */
    public function ConsultaInterfaz_nav()
    {
        $this->setTabAct();
        $this->list = [
            ["id" => "con-hc", "nom" => "Historia Clinica", "icon" => '<i class="fa fa-book fa-lg"></i>', "include" => root['c'] . 'com_hc/_hcDet.php'],
            ["id" => "con-con", "nom" => "Consulta", "icon" => '<i class="fa fa-book fa-lg"></i>', "include" => root['c'] . 'com_consultas/consultaDet.php'],
            ["id" => "con-tra", "nom" => "Tratamientos", "icon" => '<i class="fa fa-columns fa-lg"></i>', "include" => root['c'] . 'com_tratamientos/tratListCon.php'],
            ["id" => "con-exa", "nom" => "Examenes", "icon" => '<i class="fa fa-list-alt fa-lg"></i>', "include" => root['c'] . 'com_examen/examLisCon.phpp'],
            ["id" => "con-cir", "nom" => "Cirugías", "icon" => '<i class="fa fa-medkit fa-lg"></i> ', "include" => root['c'] . 'com_cirugia/cirLisCon.php'],
            ["id" => "con-doc", "nom" => "Documentos", "icon" => '<i class="fas fa-file fa-lg"></i>', "include" => root['c'] . 'com_docs/docLisCon.php'],
            ["id" => "con-iess", "nom" => "IESS", "icon" => '<i class="fas fa-hospital"></i> ', "include" => root['c'] . 'com_iess/iessRepList.php'],
            ["id" => "con-ant", "nom" => "Historia Anterior", "icon" => '<i class="fa fa-history fa-lg"></i> ', "include" => root['c'] . 'com_hc/consulta_ant.php'],
        ];
        $this->objNavLis = $this->ConsultaINterfaz_nav_list();
        $this->objNavTab = $this->ConsultaInterfaz_nav_tab();
    }
    //FOR CONSULTA INTERFACE : ConsultaInterfaz_nav
    private function ConsultaINterfaz_nav_list()
    {
        $ret = null;
        if ($this->list) :
            $ret .= "<div class='position-sticky pt-3 sidebar-sticky me-2 ms-2 mb-4'>
            <div class='nav flex-column nav-pills text-light' id='v-pills-tab' role='tablist' aria-orientation='vertical'>";
            foreach ($this->list as $dList) :
                $cssActive = ($this->tabAct == $dList['id']) ? "active" : null;
                $ret .= "
                <button class='nav-link setTab {$cssActive}' id='{$dList['id']}-tab' data-val='{$dList['id']}' data-rel='con' data-bs-toggle='pill' data-bs-target='#{$dList['id']}' type='button' role='tab' aria-controls='{$dList['id']}' aria-selected='false'>
                {$dList['icon']} {$dList['nom']}
                </button>";
            endforeach;
            $ret .= "</div></div>";
        endif;
        return $ret;
    }
    //FOR CONSULTA INTERFACE : ConsultaInterfaz_nav
    public function ConsultaInterfaz_nav_tab()
    {
        $ret = null;
        $ret = $this->list;
        /*
        if ($list) :
            $ret .= "<div class='tab-content card card-body mt-2' id='v-pills-tabContent'>";
            foreach ($list as $dList) :
                $cssActive = ($this->tabAct == $dList['id']) ? "active" : null;
                $ret .= "<div class='tab-pane fade show {$cssActive}' id='{$dList['id']}' role='tabpanel' tabindex='0'>";
                ob_start();
                $idsPac=$this->idp;
                $dCon=$this->getDet();
                include($dList['include']);
                $ret .= ob_get_clean();
                $ret .= "</div>";
            endforeach;
            $ret .= "</div>";
        endif;*/
        return $ret;
    }
    public function ConsultaInterfaz_ListDiagHist()
    {
        $ret = null;
        $lConDiagHist = $this->getAllConsultasPacienteDiagnosticos();
        if ($lConDiagHist) {
            $ret .= "<div class='table-responsive'>
            <table class='table table-sm m-0'>";
            foreach ($lConDiagHist as $dRow) :
                $ret .= "<tr>
						<th><span class='badge bg-light'>{$dRow['date']}</span></th>
						<td>{$dRow['diag']}</td>
					</tr>";
            endforeach;
            $ret .= "</table>
            </div>";
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
