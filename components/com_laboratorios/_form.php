<?php

use App\Models\Laboratorio;

$mInd = new Laboratorio;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$mInd->setID($ids);
$mInd->det();
$dInd = $mInd->det;
if ($dInd) {
	$id = $dInd['idLab'];
	$acc = md5("UPDl");
	$btnAcc = "<button type='button' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
	$cont = "<span class='badge bg-primary'>{$dInd['idLab']}</span>
	{$dInd['nomLab']}";
} else {
	$id = null;
	$acc = md5("INSl");
	$btnAcc = "<button type='button' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
}
$btnNew = "<a href='{$urlc}' class='btn btn-default'>{$cfg['b']['new']}</a>";

$dH['mod_nom'] = 'LABORATORIOS';
$objTit = new App\Core\genInterfaceTitle(null, "card", $cont ?? null, $btnAcc . $btnNew, null, null, "h2");
?>


<form method="post" action="_acc.php" role="form">
	<fieldset>
		<input name="form" type="hidden" id="form" value="<?php echo md5("fLab") ?>">
		<input name="ids" type="hidden" id="id" value="<?php echo $ids ?>">
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
	</fieldset>
	<?php $objTit->render() ?>
	<fieldset class="card card-body">
		<div class="row mb-3">
			<label for="des" class="col-sm-2 form-label">Nombre Laboratorio</label>
			<div class="col-sm-10">
				<input type="text" name="iNom" class="form-control form-control-lg" value="<?php echo $dInd['nomLab'] ?? null ?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="des" class="col-sm-2 form-label">Descripción Laboratorio</label>
			<div class="col-sm-10">
				<textarea name="iDes" rows="4" class="form-control"><?php echo $dInd['desLab'] ?? null ?></textarea>
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-sm-2 form-label">Estado</label>
			<div class="col-sm-10">
				<?php //$params = array("1" => "Activo", "0" => "Inactivo");
				//echo genFormsInpRadio($params, $dInd['status'] ?? 1, 'inline', 1, 'iEst'); 
				?>

				<?php echo genFormsInpSwitch("iEst", $dInd['status']) ?>

			</div>
		</div>
	</fieldset>
</form>