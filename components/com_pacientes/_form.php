<?php

use App\Models\Paciente;
use App\Models\Signo;

$mPac = new Paciente;
$mSig = new Signo;

$ids = $_GET['id'] ?? $_POST['id'] ?? null;
$mPac->setID($ids);
$mPac->detF();
$dPac = $mPac->det;

//dep($dPacF);
if ($dPac) {
	$idp = $dPac['pac_cod'];
	$mPac->registrarBusquedaPaciente();
	$img = vImg("data/db/pac/", $mPac->getlastImgPac());
	$acc = md5("UPDp");
	$dPacSig = $mSig->getLastSignPac($ids);

	$IMC = calcIMC($dPacSig['imc'] ?? null, $dPacSig['peso'] ?? null, $dPacSig['talla'] ?? null);
	$btnAcc = "<button type='button' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
	$btnCon = '<a href="' . route['c'] . 'com_consultas/form.php?idp=' . $ids . '" class="btn btn-info"><i class="far fa-eye fa-lg"></i> VER CONSULTA</a>';
} else {
	$acc = md5("INSp");
	$btnAcc = "<button type='button' class='btn btn-info' id='vAcc'>{$cfg['b']['ins']}</button>";
	$btnCon = null;
}
$btnNew = "<a href='{$urlc}' class='btn btn-light'>{$cfg['b']['new']}</a>";

$cont = array("icon" => $dM['icon'] ?? null, "ref" => $dM['nom'] ?? null, "nom" => $dPacF['dPac_fullname'] ?? null, "des" => $idp ?? null);
$objHeadCom = new App\Core\genInterfaceTitle($cont, 'card', null, $btnAcc . $btnNew . $btnCon, NULL, 'bg-dark text-light', 'h2');
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" name="form_grabar" id="form_grabar" role="form">
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc; ?>" />
		<input name="mod" type="hidden" value="<?php echo $dM['ref'] ?>" />
		<input name="id" type="hidden" value="<?php echo $id; ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>
	<?php $objHeadCom->showInterface(); ?>
	<div class="row">
		<div class="col-md-5">
			<?php include("_formMain.php") ?>
			<?php include("_formType.php") ?>
			<?php include("_formSign.php") ?>
		</div>
		<div class="col-sm-7">

			<div class="card">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data" type="button" role="tab" aria-controls="data" aria-selected="true">
								Datos
							</button>
						</li>
						<?php if ($dPac) { ?>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="hist-tab" data-bs-toggle="tab" data-bs-target="#hist" type="button" role="tab" aria-controls="hist" aria-selected="true">
									Historia Clinica
								</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" id="gin-tab" data-bs-toggle="tab" data-bs-target="#gin" type="button" role="tab" aria-controls="gin" aria-selected="true">
									Registro Ginecologico
								</button>
							</li>
						<?php } ?>
					</ul>
				</div>
				<!-- Nav tabs -->
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab" tabindex="0">
							<?php include('_formDatos.php') ?>
						</div>
						<?php if ($dPac) { ?>
							<div class="tab-pane fade" id="hist" role="tabpanel" aria-labelledby="hist-tab" tabindex="0">
								<?php $idST = $idp; //int value, no hashed
								include(root['c'] . 'com_hc/_hcDet.php') ?>
							</div>
							<div class="tab-pane fade" id="gin" role="tabpanel" aria-labelledby="gin-tab" tabindex="0">
								<?php $idST = $idp; //int value, no hashed
								include(root['c'] . 'com_hc/_hcGin.php') ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>