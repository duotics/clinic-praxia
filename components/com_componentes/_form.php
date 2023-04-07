<?php

use App\Models\Componente;

$mCom = new Componente;
$ids = $_REQUEST['ids'] ?? null;
$mCom->setID($ids);
$mCom->det();
$dCom = $mCom->det;

if ($dCom) {
	$acc = md5('UPDc');
	$btnAcc = "<button type='submit' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
} else {
	$acc = md5('INSc');
	$btnAcc = "<button type='submit' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button>";
}
$btnNew = '<a href="' . $urlc . '" class="btn btn-outline-dark"><i class="fas fa-plus-square fa-lg"></i> NUEVO</a>';
$objHeader = new App\Core\genInterfaceTitle($dM, 'navbar');
$cont = '<span class="badge bg-primary">' . ($dCom['idComp'] ?? null) . '</span>
	<span class="badge bg-primary">' . ($dCom['nomComp'] ?? null) . '</span>';
$objHeader2 = new App\Core\genInterfaceTitle(null, 'header', $cont, $btnAcc . $btnNew);
?>

<?php $objHeader->showInterface() ?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="form" type="hidden" value="<?php echo md5('formC') ?>">
		<input name="ids" type="hidden" value="<?php echo $ids ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<?php $objHeader2->showInterface() ?>
	<div class="row">
		<div class="col-sm-7">
			<div class="card p-4">
				<fieldset class="form-horizontal">
					<div class="row mb-3">
						<label class="control-label col-sm-4" for="refComp">Referencia</label>
						<div class="col-sm-8">
							<input name="refComp" type="text" id="refComp" placeholder="Referencia del módulo" value="<?php echo $dCom['refComp'] ?? null ?>" class="form-control" required>
						</div>
					</div>
					<div class="row mb-3">
						<label class="control-label col-sm-4" for="refComp">Nombre / Titulo</label>
						<div class="col-sm-8">
							<input name="nomComp" type="text" id="nomComp" placeholder="Nombre del módulo" value="<?php echo $dCom['nomComp'] ?? null ?>" class="form-control" required>
						</div>
					</div>
					<div class="row mb-3">
						<label class="control-label col-sm-4" for="desComp">Descripcion</label>
						<div class="col-sm-8">
							<input name="desComp" type="text" id="desComp" placeholder="Descripcion del módulo" value="<?php echo $dCom['desComp'] ?? null ?>" class="form-control">
						</div>
					</div>
					<div class="row mb-3">
						<label class="control-label col-sm-4" for="txtIcon">Icono</label>
						<div class="col-sm-8">
							<div class="input-group">
								<input name="iconComp" type="text" id="txtIcon" placeholder="Icono" value="<?php echo $dCom['iconComp'] ?? null ?>" class="form-control">
								<div class="input-group-addon"><i class="<?php echo $dCom['iconComp'] ?? null ?>" id="iconRes"></i></div>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="control-label col-sm-4" for="desComp">Status</label>
						<div class="col-sm-8">
							<?php $params = array("1" => "Activo", "0" => "Inactivo");
							echo genFormsInpRadio($params, $dCom['status'] ?? null, 'inline', 1, 'status'); ?>
						</div>
					</div>

				</fieldset>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="card card-light">
				<div class="card-header">Menus Items Relacionados</div>
				<div class="card-body">menus</div>
			</div>
		</div>

	</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		var txtIcon = $("#txtIcon");
		txtIcon.on('keypress keyup focusout', function(evt, params) {
			iconClass(txtIcon.val());
		});
	});

	function iconClass(clase) {
		$("#iconRes").removeClass();
		$("#iconRes").addClass(clase);
	}
</script>