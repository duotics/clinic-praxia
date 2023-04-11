<?php
$det = null;
$dNom = null;
$id = $_REQUEST['id'] ?? null;
$ref = $_REQUEST['ref'] ?? null;
$det = detRow('dbTypes', 'idType', $id);
if ($det) {
	$acc = md5("UPDt");
	$btnAcc = "<button type='submit' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
	$detRef = $det['refType'] ?? null;
	$btnNewR = "<a href='{$urlc}?ref={$detRef}' class='btn btn-outline-dark'>{$cfg['i']['new']} NUEVO SIMILAR</a>";
	$btnClon = '<a href="_acc.php?id=' . $id . '&acc=' . md5('CLONEt') . '&url=' . $urlc . '" class="btn btn-info"><i class="fas fa-clone"></i> CLONAR</a>';
} else {
	$acc = md5("INSt");
	$btnAcc = "<button type='submit' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
	$btnNewR = null;
	$btnClon = null;
	$detRef = $ref;
}
$btnNew = "<a href='$urlc' class='btn btn-outline-dark'>{$cfg['b']['new']}</a>";
?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="form" type="hidden" value="<?php echo md5('formType') ?>">
		<input name="id" type="hidden" value="<?php echo $id ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<?php
	$cont = '<span class="badge badge-info">' . $id . '</span>' . $dNom;
	echo genHeader($dM, 'card', $cont, $btnAcc . $btnNew . $btnNewR . $btnClon, null, 'mt-3') ?>
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