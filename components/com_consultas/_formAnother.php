<?php
//INIT VARS
$tabS = $_SESSION['tab']['con'] ?? null;
$view = false;
$dPac = null;
$dCon = null;
$dRes = null;
$LOG = null;
$statusCon = null;
$mCon = new App\Models\ConsultaInterfaz();
$mPac = new App\Models\PacienteInterfaz;
$mRes = new App\Models\Agendamiento;

$tabS = $_SESSION['tab']['con'] ?? null;
$idsPac = $_GET['kp'] ?? null;
$idsCon = $_GET['kc'] ?? null;
$idsRes = $_GET['kr'] ?? null;

if ($idsPac !== null) {
	// Opción 1: ID_PACIENTE
	$LOG.= "* hay ID Paciente<br>";
	$idsCon = null;
	$mPac->setID($idsPac);
	$mPac->det();
	$dPac = $mPac->getDet();
	$mRes->getLastResPac($idsPac);
	$dRes = $mRes->getDet();
	if ($dRes) {
		$LOG.= " - Reserva Existe<br>";
		$LOG.= "existe reserva<br>";
		$idr = $dRes['id'] ?? null;
		$statusCon = 3;
	} else {
		$LOG.= " - Reserva no Existe<br>";
		$LOG.= "no existe reserva obtengo consulta<br>";
		$idc = $dPac['con_num'] ?? null;
		$mCon->getLastConsPac($idsPac);
		$dCon = $mCon->getDet();
		if ($dCon) {
			$statusCon = $dCon['status'];
		}
	}
} elseif ($idsCon !== null) {
	// Opción 2: ID_CONSULTA
	$LOG.= "* hay ID Consulta<br>";
	$mCon->setID($idsCon);
	$mCon->det();
	$dCon = $mCon->getDet();
	if ($dCon) {
		$LOG.= " - existe detalle de consulta<br>";
		$statusCon = $dCon['status'];
		$idsPac = md5($dCon['pac_cod']);
		dep($idsPac);
		$mPac->setID($idsPac);
		$mPac->det();
		$dPac = $mPac->getDet();
	}
} elseif ($idsRes !== null) {
	// Opción 3: ID_RESERVA
	$LOG.= "* hay ID Reserva<br>";
	$mRes->setID($idsRes);
	$mRes->detResActive();
	$dRes = $mRes->getDet();
	$statusCon = 5;
	$idsPac = $dRes['pac_cod'] ?? null;
	if ($idsPac) {
		$LOG.= "- existe paciente relacionado a reserva<br>";
		$mPac->setID(md5($idsPac));
		$mPac->det();
		$dPac = $mPac->getDet();
	}
} else {
	$view = false;
}

//echo $LOG;

if ($dPac) $view = true;

if ($dCon) {
	$acc = md5('UPDc');
	$btnAcc = '<button type="submit" class="btn btn-success">' . cfg['i']['upd'] . ' ' . cfg['b']['upd'] . '</button>';
} else {
	$acc = md5('INSc');
	$btnAcc = '<button type="submit" class="btn btn-primary">' . cfg['i']['ins'] . ' ' . cfg['b']['ins'] . '</button>';
}
$stat = $mCon->statusCons($statusCon); //Devuelve el estado de la Consulta en HTML
$btnNew = "<a href='$urlc?idp=$idsPac' class='btn btn-light>{cfg['b']['new']}</a>";
$btnStat = "<span class='btn btn-light disabled'>Estado</span>$stat[inf]";
?>

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