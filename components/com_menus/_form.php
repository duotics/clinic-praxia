<?php
$ids = null;
$id = null;
if (isset($_REQUEST['ids'])) $ids = $_REQUEST['ids'];
$det = detRow('dbMenu', 'md5(idMenu)', $ids);
if ($det) {
	//dep($det);
	$id = $det['idMenu'];
	$acc = md5('UPDmc');
	$btnAcc = "<button type='submit' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
} else {
	$acc = md5('INSmc');
	$btnAcc = "<button type='submit' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
}
$btnNew = "<a href='{$urlc}' class='btn btn-outline-dark'>{$cfg['b']['new']}</a>";
?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<?php $cont = '<span class="badge bg-info">' . $id . '</span>
<span class="badge bg-info">' . ($det['nomMenu'] ?? null) . '</span>';
	echo genHeader($dM, 'card', $cont, $btnAcc . $btnNew, null, 'mb-3') ?>
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="form" type="hidden" value="<?php echo md5('formMC') ?>">
		<input name="ids" type="hidden" value="<?php echo $ids ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<div class="card">
				<fieldset class="card-body">
					<div class="mb-3 row">
						<label class="col-form-label col-sm-4" for="iNom">Nombre</label>
						<div class="col-sm-8">
							<input name="iNom" type="text" id="iNom" placeholder="Nombre del Menú" value="<?php echo $det['nomMenu'] ?? null ?>" class="form-control">
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-form-label col-sm-4" for="iRef">Referencia</label>
						<div class="col-sm-8">
							<input name="iRef" type="text" id="iRef" placeholder="Referencia del menú" value="<?php echo $det['refMenu'] ?? null ?>" class="form-control">
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="card card-light">
				<div class="card-header">Menus en este contenedor</div>
				<div class="card-body">Coding</div>
			</div>
		</div>
	</div>
</form>