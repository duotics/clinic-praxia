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
} else {
	$id = null;
	$acc = md5("INSl");
	$btnAcc = "<button type='button' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
}
$btnNew = "<a href='{$urlc}' class='btn btn-default'>{$cfg['b']['new']}</a>";
?>

<form method="post" action="_acc.php" role="form">
	<fieldset>
		<input name="form" type="hidden" id="form" value="<?php echo md5("fLab") ?>">
		<input name="ids" type="hidden" id="id" value="<?php echo $ids ?>">
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
	</fieldset>

	<?php $cont = "<span class='label label-info'>$id</span>";
	$dH['mod_nom'] = 'LABORATORIOS';
	echo genHeader($dH, 'page-header', $cont, $btnAcc . $btnNew) ?>

	<div class="container">
		<fieldset class="form-horizontal">
			<div class="form-group">
				<label for="des" class="col-sm-2 control-label">Nombre Laboratorio</label>
				<div class="col-sm-10">
					<input type="text" name="iNom" class="form-control" value="<?php echo $dInd['nomLab'] ?? null ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="des" class="col-sm-2 control-label">Descripción Laboratorio</label>
				<div class="col-sm-10">
					<textarea name="iDes" rows="9" class="form-control"><?php echo $dInd['desLab'] ?? null ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Estado</label>
				<div class="col-sm-10">
					<?php $params = array("1" => "Activo", "0" => "Inactivo");
					echo genFormsInpRadio($params, $dInd['status'] ?? 1, 'inline', 1, 'iEst'); ?>
				</div>
			</div>
		</fieldset>
	</div>
</form>