<?php

use App\Models\Indicacion;

$mInd = new Indicacion;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$mInd->setID($ids);
$mInd->det();
$dInd = $mInd->det;
if ($dInd) {
	$id = $dInd['id'];
	$acc = md5("UPDi");
	$btnAcc = "<button type='button' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
} else {
	$id = null;
	$acc = md5("INSi");
	$btnAcc = "<button type='button' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
}
$btnNew = "<a href='{$urlc}' class='btn btn-default'>{$cfg['b']['new']}</a>";
?>

<form method="post" action="_acc.php" role="form">
	<fieldset>
		<input name="form" type="hidden" id="form" value="<?php echo md5("find") ?>">
		<input name="ids" type="hidden" id="id" value="<?php echo $ids ?>">
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
	</fieldset>

	<?php $cont = "<span class='label label-info'>$id</span>";
	$dH['mod_nom'] = 'INDICACIONES';
	echo genHeader($dH, 'page-header', $cont, $btnAcc . $btnNew) ?>

	<div class="container">
		<fieldset class="form-horizontal">
			<div class="form-group">
				<label for="des" class="col-sm-2 control-label">Indicación</label>
				<div class="col-sm-10">
					<textarea name="des" rows="9" class="form-control" id="des"><?php echo $dInd['des'] ?? null ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="ord" class="col-sm-2 control-label">Orden</label>
				<div class="col-sm-10">
					<input name="ord" type="number" class="form-control" value="<?php echo $dInd['ord'] ?? null ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Destacado</label>
				<div class="col-sm-10">
					<?php $params = array("1" => "Activo", "0" => "Inactivo");
					echo genFormsInpRadio($params, $dInd['feat'] ?? 0, 'inline', 1, 'feat'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-10">
					<?php $params = array("1" => "Activo", "0" => "Inactivo");
					echo genFormsInpRadio($params, $dInd['est'] ?? 1, 'inline', 1, 'est'); ?>
				</div>
			</div>
		</fieldset>
	</div>
</form>