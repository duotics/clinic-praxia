<?php include('../../init.php');
$dM = $Auth->vLogin('CONSULTA');

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Agendamiento;

$mCon = new Consulta();
$mPac = new Paciente();
$mRes = new Agendamiento();

$tabS = $_SESSION['tab']['con'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null;

if ($idp !== null) {
	echo "hay id paciente<br>";
	$mPac->setID($idp);
	$mPac->det();
	$dPac = $mPac->getDet();
	$mRes->getLastResPac($idp);
	$dRes = $mRes->getDet();
	if ($dRes) {
		echo "existe reserva<br>";
		$idr = $dRes['id'] ?? null;
		$statusCons = 'NEW';
	} else {
		echo "no existe reserva obtengo consulta<br>";
		$idc = $dPac['con_num'] ?? null;
		$mCon->getLastConsPac($idp);
		$dCon = $mCon->getDet();
	}
	// Opción 1: ID_PACIENTE
	// Consulta a la base de datos para obtener datos del paciente y última consulta
	// ...
} elseif ($idc !== null) {
	$mCon->setID($idc);
	$mCon->det();
	$dCon = $mCon->getDet();
	$idp = $dCon['pac_cod'] ?? null;
	$mPac->setID(md5($idp));
	$mPac->det();
	$dPac = $mPac->getDet();
	// Opción 2: ID_CONSULTA
	// Consulta a la base de datos para obtener datos de la consulta y datos del paciente
	// ...
} elseif ($idr !== null) {
	$mRes->setID($idr);
	$mRes->detResActive();
	$dRes = $mRes->getDet();
	$idp = $dRes['pac_cod'] ?? null;
	$idc = $dRes['con_num'] ?? null;
	$mPac->setID(md5($idp));
	$mPac->det();
	$dPac = $mPac->getDet();
	// Opción 3: ID_RESERVA
	// Consulta a la base de datos para obtener el ID del paciente
	// ...
	// Dejar la interfaz lista para una nueva consulta
} else {
	$view = false;
}

dep($idp, "idp");
dep($idc, "idc");
dep($idr, "idr");
echo "<hr>";
dep($dPac, "dPac");
dep($dCon, "dCon");
dep($dRes, "dRes");
echo "<hr>";


if ($dRes) $estCon = 3; //Reservada
else $estCon = $dCon['con_stat'] ?? null;
if ($dCon) {
	$acc = md5('UPDc');
	$btnAcc = '<button id="vAcc" type="button" class="btn btn-success navbar-btn">' . $cfg['btn']['updI'] . $cfg['btn']['updT'] . '</button>';
	$mCon->setID(md5($idc));
} else {
	$acc = md5('INSc');
	$btnAcc = '<button id="vAcc" type="button" class="btn btn-info navbar-btn">' . $cfg['btn']['insI'] . $cfg['btn']['insT'] . '</button>';
	$msgErrorNoCons = "<div class='alert alert-warning'><h4>Primero Guarde la Consulta</h4></div>";
}
$btnNew = null; //'<a href="' . $urlc . '?idp=' . $dPac['pac_cod'] . '&acc=NEW" class="btn btn-default navbar-btn">' . $cfg['btn']['newI'] . $cfg['btn']['newT'] . '</a>';

$dirimg = null; //vImg("data/db/pac/", lastImgPac($idp));
$stat = estCon($estCon); //Devuelve el estado de la Consulta en HTML

$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, null, null);
$mTpl->renderHead();
?>
***
<?php if ($dPac) { ?>
	<?php //$mPac->registrarBusquedaPaciente($id) 
	?>
	<form action="_fnc.php" method="post">
		<fieldset>
			<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>" />
			<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>" />
			<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>" />
			<input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>" />
			<input name="cons_stat" type="hidden" id="cons_stat" value="<?php echo $dCon['con_stat']; ?>" />
			<input name="mod" type="hidden" id="mod" value="<?php echo md5('consForm') ?>" />
		</fieldset>
		<div class="container-fluid">
			<!--NVBAR TOP-->
			<nav class="navbar navbar-default cero">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-cons-est">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><?php echo $dM['mod_nom'] ?> <span class="label label-info"><?php echo $idc ?></span>
							<span class="label label-default">Visita <?php echo detNumConAct($idc, $idp) ?></span></a>
					</div>
					<div class="collapse navbar-collapse" id="navbar-cons-est">
						<ul class="nav navbar-nav">
							<li>
								<div class="btn-group">
									<?php echo $status_cons ?? null ?>
									<button type="button" class="btn btn-default navbar-btn disabled">Estado</button>
									<?php echo $stat['inf'] ?>
								</div>
							</li>
						</ul>
						<ul class="nav navbar-nav">
							<li>
								<div class="btn-group">
									<?php echo $btnAcc ?>
									<?php echo $btnNew ?>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<?php include('_fra_con_dat.php') ?>
			<?php sLOG('g') ?>
			<div class="row">
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-2 text-center"><a href="<?php echo $dirimg['n'] ?>" class="fancybox">
								<img src="<?php echo $dirimg['t'] ?>" class="img-thumbnail img-responsive imgPacCons" />
							</a></div>
						<div class="col-md-10">
							<?php include('_fra_con_detpac.php') ?>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<?php include('_fra_histCons.php') ?>
				</div>
			</div>

			<div class="well well-sm">
				<div class="tabbable">
					<div class="row">
						<div class="col-md-2">
							<ul class="nav nav-pills nav-stacked">
								<li class="<?php if (!$tabS) echo 'active' ?>">
									<a href="#cHC" data-toggle="tab" title="" onClick="setTab(this.title)">
										<i class="fa fa-book fa-lg"></i> Historia Clinica</a>
								</li>
								<li class="<?php if ($tabS == 'cCON') echo 'active' ?>">
									<a href="#cCON" data-toggle="tab" title="cCON" onClick="setTab(this.title)" id="loadConData">
										<i class="fa fa-user-md fa-lg"></i> Consulta</a>
								</li>
								<li class="<?php if ($tabS == 'cTRA') echo 'active' ?>">
									<a href="#cTRA" data-toggle="tab" title="cTRA" onClick="setTab(this.title)">
										<i class="fa fa-columns fa-lg"></i> Medicacion</a>
								</li>
								<li class="<?php if ($tabS == 'cEXA') echo 'active' ?>">
									<a href="#cEXA" data-toggle="tab" title="cEXA" onClick="setTab(this.title)">
										<i class="fa fa-list-alt fa-lg"></i> Exámenes</a>
								</li>
								<li class="<?php if ($tabS == 'cCIR') echo 'active' ?>">
									<a href="#cCIR" data-toggle="tab" title="cCIR" onClick="setTab(this.title)">
										<i class="fa fa-medkit fa-lg"></i> Cirugías</a>
								</li>
								<li class="<?php if ($tabS == 'cDOC') echo 'active' ?>">
									<a href="#cDOC" data-toggle="tab" title="cDOC" onClick="setTab(this.title)">
										<i class="fa fa-file-o fa-lg"></i> Documentos</a>
								</li>
								<li class="<?php if ($tabS == 'cANT') echo 'active' ?>">
									<a href="#cANT" data-toggle="tab" title="cANT" onClick="setTab(this.title)">
										<i class="fa fa-history fa-lg"></i> Historia Anterior</a>
								</li>
							</ul>
						</div>
						<div class="col-md-10">
							<div class="tab-content">
								<div class="tab-pane <?php if (!$tabS) echo 'active' ?>" id="cHC">
									<?php include(RAIZc . 'com_hc/historia_det.php') ?>
								</div>
								<div class="tab-pane <?php if ($tabS == 'cCON') echo 'active' ?>" id="cCON">
									<div id="contCons"><?php $vVT = TRUE; ?>
										<?php include('consultaDet.php') ?>
									</div>
								</div>
								<div class="tab-pane <?php if ($tabS == 'cTRA') echo 'active' ?>" id="cTRA">
									<?php if ($dCon) include(RAIZc . 'com_tratamientos/tratListCon.php');
									else echo $msgErrorNoCons ?>
								</div>
								<div class="tab-pane <?php if ($tabS == 'cEXA') echo 'active' ?>" id="cEXA">
									<?php if ($dCon) include(RAIZc . 'com_examen/examListCon.php');
									else echo $msgErrorNoCons ?>
								</div>
								<div class="tab-pane <?php if ($tabS == 'cCIR') echo 'active' ?>" id="cCIR">
									<?php if ($dCon) include(RAIZc . 'com_cirugia/cirugiasListCon.php');
									else echo $msgErrorNoCons ?>
								</div>
								<div class="tab-pane <?php if ($tabS == 'cDOC') echo 'active' ?>" id="cDOC">
									<?php if ($dCon) include(RAIZc . 'com_docs/documentos_con_list.php');
									else echo $msgErrorNoCons ?>
								</div>
								<div class="tab-pane <?php if ($tabS == 'cANT') echo 'active' ?>" id="cANT">
									<?php include(RAIZc . 'com_hc/consulta_ant.php'); ?>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</form>
	<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<?php } else { ?>
	<div class="alert alert-danger">
		<h4>Error Paciente No Existe</h4>
	</div>
<?php } ?>
<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>
<script type="text/javascript">
	$(document).ready(function() {});

	function setTab(val) {
		$.get("setTabJS.php", {
			val: val
		}, function(data) {});
	}
</script>
<?php $mTpl->renderFoot(); ?>