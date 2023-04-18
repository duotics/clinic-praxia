<?php

use App\Models\ConsultaInterfaz;
use App\Models\PacienteInterfaz;
use App\Models\Tipo;
use App\Models\Agendamiento;

$objCon = new ConsultaInterfaz();
$objPac = new PacienteInterfaz();
$mTipo = new Tipo();

$view = false;
$acc = null;
$dPac = null;
$dCon = null;
$dRes = null;
$LOG = null;
$statusCon = null;

$idsPac = $_GET['kp'] ?? null;
$idsCon = $_GET['kc'] ?? null;
$idsRes = $_GET['kr'] ?? null;
$acc = $_GET['acc'] ?? null;

if ($idsCon) {
	$LOG .= "recibo id Consulta<br>";
	$objCon->setID($idsCon);
	$objCon->det();
	$dCon = $objCon->getDet();
	if ($dCon) {
		$idsPac = isset($dCon['pac_cod']) ? md5($dCon['pac_cod']) : $idsPac;
		$statusCon = $dCon['status'];
		$objCon->setIDp($idsPac);
	}
}
if ($idsPac) {
	$LOG .= "Recibo id paciente<br>";
	$objPac->setID($idsPac);
	$objPac->detF();
	$dPac = $objPac->det;
	$dPacF = $objPac->detF;
	$objCon->setIDp($idsPac);
	if ($acc == 'new') {
		$LOG .= "Nueva consulta<br>";
	} else {
		if (is_null($dCon)) {
			$LOG .= "RECUPERO LA ULTIMA DATA SI NO EXISTE AUN<br>";
			$objCon->getLastConsPac();
			$dCon = $objCon->getDet();
			if ($dCon) {
				$idsCon = md5($dCon['con_num']);
				$statusCon = $dCon['status'];
				$objCon->setID($idsCon) ?? null;
			}
		} else {
			$LOG .= "No se recupera porque ya se encontro antes<br>";
		}
	}
}

if ($dPac) $view = true;

if ($dCon) :
	$acc = md5('UPDc');
	$btnAcc = "<button type='submit' class='btn btn-success'>{$cfg['b']['upd']}</button>";
	$objCon->detSec();
	$dConSec = $objCon->detSec;
else :
	$acc = md5('INSc');
	$btnAcc = "<button type='submit' class='btn btn-primary'>{$cfg['b']['ins']}</button>";
endif;
$stat = $objCon->statusCons($statusCon); //Devuelve el estado de la Consulta en HTML
$btnNew = "<a href='$urlc?kp=$idsPac&acc=NEW' class='btn btn-light'>{$cfg['b']['new']}</a>";
$btnStat = "<span class='btn btn-light disabled'>Estado</span> $stat[inf]";
?>
<?php if ($dPac) : ?>
	<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
		<a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Consulta</a>
		<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
	</header>
	<div class="container-fluid">
		<div class="row">
			<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark text-light sidebar collapse">
				<?php include('_formLat.php') ?>
			</nav>
			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				<?php include('_formCent.php') ?>
			</main>
		</div>
	</div>
<?php else : ?>
	<div class="container">
		<div class="alert alert-danger">
			<h4>Error Paciente No Existe</h4>
		</div>
	</div>
<?php endif ?>