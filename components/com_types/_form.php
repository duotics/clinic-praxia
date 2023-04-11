<?php

use App\Models\Tipo;

$mTip = new Tipo;
$ids = $_REQUEST['k'] ?? null;
$valRef = $_REQUEST['ref'] ?? null;
$mTip->setID($ids);
$mTip->setValRef($valRef);
$mTip->det();
$det = $mTip->getDet();
if ($det) {
	$acc = md5("UPDt");
	$btnAcc = "<button type='submit' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
	$detRef = $det['refType'] ?? null;
	$btnClon = "<a href='_acc.php?k=$ids&acc=" . md5('CLONEt') . "&url=$urlc' class='btn btn-info'>{$cfg['b']['clone']}</a>";
	$dNom = "{$det['nomType']}";
} else {
	$acc = md5("INSt");
	$btnAcc = "<button type='submit' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
	$btnClon = null;
	$detRef = $valRef;
	$dNom = null;
}
$btnNew = "<a href='$urlc' class='btn btn-outline-dark'>{$cfg['b']['new']}</a>";
$cont = "<span class='badge badge-info'>$ids</span> $dNom";
$objTit = new App\Core\genInterfaceTitle($dM, 'card', $cont, $btnAcc . $btnNew . $btnClon, null, 'mt-3');
?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="form" type="hidden" value="<?php echo md5('formType') ?>">
		<input name="id" type="hidden" value="<?php echo $id ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<?php $objTit->render() ?>
	<div class="card">
		<div class="card-body">
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label" for="iRef">Referencia</label>
				<div class="col-sm-9">
					<input name="iRef" type="text" id="iRef" placeholder="Referencia del módulo" value="<?php echo $detRef ?? null ?>" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label" for="iNom">Nombre</label>
				<div class="col-sm-9">
					<input name="iNom" type="text" id="iNom" placeholder="Nombre del tipo" value="<?php echo $det['nomType'] ?? null ?>" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label" for="iVal">Valor</label>
				<div class="col-sm-9">
					<input name="iVal" type="text" id="iVal" placeholder="Valor del tipo" value="<?php echo $det['valType'] ?? null ?>" class="form-control">
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label" for="iVal">Auxiliar</label>
				<div class="col-sm-9">
					<input name="iAux" type="text" id="iAux" placeholder="Valor auxiliar" value="<?php echo $det['auxType'] ?? null ?>" class="form-control">
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label" for="iIcon">Icono</label>
				<div class="col-sm-9">
					<input name="iIcon" type="text" id="iIcon" placeholder="Icono" value="<?php echo $det['iconType'] ?? null ?>" class="form-control">
				</div>
			</div>
			<div class="row mb-3">
				<label class="col-sm-3 col-form-label" for="iMod">Módulo</label>
				<div class="col-sm-9">
					<input name="iMod" type="text" id="iMod" placeholder="Módulo" value="<?php echo $det['idComp'] ?? null ?>" class="form-control">
				</div>
			</div>
		</div>
	</div>
</form>