<?php
$ids = null;
if (isset($_REQUEST['ids'])) $ids = $_REQUEST['ids'];
$det = detRow('dbMenuItem', 'md5(idMItem)', $ids);
if ($det) {
	$acc = md5('UPDmi');
	$btnAcc = " <button type='submit' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button> ";
} else {
	$acc = md5('INSmi');
	$btnAcc = " <button type='submit' class='btn btn-primary' id='vAcc'>{$cfg['b']['ins']}</button> ";
}
$btnNew = "<a href='{$urlc}' class='btn btn-outline-dark'>{$cfg['b']['new']}</a>";
?>
<form enctype="multipart/form-data" method="post" action="_acc.php" class="form-horizontal">
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="form" type="hidden" value="<?php echo md5('formMI') ?>">
		<input name="ids" type="hidden" value="<?php echo $ids ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<?php $cont = "<span class='badge bg-info'>" . ($det['idMItem'] ?? null) . "</span> 
	<span class='badge bg-info'>" . ($det['nomMItem'] ?? null) . "</span>";
	echo genHeader($dM, 'header', $cont, $btnAcc . $btnNew, null, 'mb-2') ?>
	<div class="row">
		<div class="col-sm-5">
			<div class="card card-light">
				<h5 class="card-header">Estructura del Menu</h5>
				<div class="card-body">
					<fieldset>
						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="dNom">Nombre</label>
							<div class="col-sm-8">
								<input name="dNom" id="dNom" type="text" placeholder="Nombre / REFERENCIA" value="<?php echo $det['nomMItem'] ?? null ?>" class="form-control" required autofocus>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="menu_id">MENU CONTENEDOR</label>
							<div class="col-sm-8">
								<?php echo $db->genSelect($db->detRowGSel('dbMenu', 'idMenu', 'nomMenu', 'status', '1'), 'dIDC', $det['idMenu'] ?? null, 'form-control', 'required onChange="loadMI(this.value,0)"'); ?>
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-sm-4">MENU PADRE</label>
							<div class="col-sm-8">
								<select name="dIDP" id="LMI" class="form-control" required></select>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="ordMItem">Orden</label>
							<div class="col-sm-8">
								<input name="dOrd" type="number" min="0" step="1" id="ordMItem" placeholder="0" value="<?php echo $det['ordMItem']; ?>" class="form-control">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="menu_id">COMPONENTE</label>
							<div class="col-sm-8">
								<?php echo $db->genSelect($db->detRowGSel('dbComponente', 'idComp', 'nomComp', 'status', '1'), 'dMod', $det['idComp'] ?? null, 'form-select'); ?>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4">Estado</label>
							<div class="col-sm-8">
								<?php $params = array("1" => "ACTIVO", "0" => "INACTIVO");
								echo genFormsInpRadio($params, $det['status'] ?? null, 'inline', 1, 'dStat'); ?>
							</div>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
		<div class="col-sm-7">
			<div class="card card-light">
				<h5 class="card-header">Opciones Visuales del Menu</h5>
				<div class="card-body">
					<fieldset>
						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="linkMItem">Link</label>
							<div class="col-sm-8">
								<input name="dLnk" type="text" id="linkMItem" placeholder="Enlace al Archivo" value="<?php echo $det['linkMItem'] ?? null ?>" class="form-control">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="titMItem">Titulo Visible</label>
							<div class="col-sm-8">
								<input name="dTit" type="text" id="titMItem" placeholder="Titulo" value="<?php echo $det['titMItem'] ?? null ?>" class="form-control">
							</div>
						</div>
						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="txtIcon">Icono</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input name="dIco" type="text" id="txtIcon" placeholder="Icono" value="<?php echo $det['iconMItem'] ?? null ?>" class="form-control">
									<div class="input-group-addon"><i id="iconRes" class="<?php echo $det['iconMItem'] ?>"></i></div>
								</div>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="cssMItem">Clase CSS</label>
							<div class="col-sm-8">
								<input name="dCss" type="text" id="cssMItem" placeholder="Estilo" value="<?php echo $det['cssMItem'] ?? null ?>" class="form-control">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="csslMItem">Clase CSS post list</label>
							<div class="col-sm-8">
								<input name="dCssl" type="text" id="csslMItem" placeholder="Estilo" value="<?php echo $det['csslMItem'] ?? null ?>" class="form-control">
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="precodeMItem">Pre Codigo</label>
							<div class="col-sm-8">
								<textarea name="dPreCode" id="precodeMItem" placeholder="Codigo para mostrar antes del Menu" class="form-control"><?php echo $det['precodeMItem'] ?? null ?></textarea>
							</div>
						</div>

						<div class="row mb-3">
							<label class="col-form-label col-sm-4" for="men_poscode">Post Codigo</label>
							<div class="col-sm-8">
								<textarea name="dPostCode" id="men_poscode" placeholder="Codigo para mostrar despues del Menu" class="form-control"><?php echo $det['poscodeMItem'] ?? null ?></textarea>
							</div>
						</div>

					</fieldset>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$('#dMod').select2();
		var idmc = <?php echo intval($det['idMenu'] ?? null) ?>;
		var idmp = <?php echo intval($det['parentMItem'] ?? null) ?>;
		loadMI(idmc, idmp);
		var txtIcon = $("#txtIcon");
		txtIcon.on('keypress keyup focusout', function(evt, params) {
			iconClass(txtIcon.val());
		});
	});

	function iconClass(clase) {
		$("#iconRes").removeClass();
		$("#iconRes").addClass(clase);
	}

	function loadMI(id, sel) {
		sel = sel || '0';
		var miselect = $("#LMI");
		$.post("jsonMI.php", {
			id: id
		}, function(data) {
			miselect.empty();
			for (var i = 0; i < data.length; i++) {
				if (sel == data[i]['id']) {
					miselect.append('<option value="' + data[i]['id'] + '" selected>' + data[i]['literal'] + '</option>');
				} else {
					miselect.append('<option value="' + data[i]['id'] + '">' + data[i]['literal'] + '</option>');
				}
			}
		}, "json");
	}
</script>