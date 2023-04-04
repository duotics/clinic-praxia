<?php

use App\Models\Medicamento;
use App\Models\Laboratorio;

$mMed = new Medicamento;
$mLab = new Laboratorio;

$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$mMed->setID($ids);
$mMed->det();
$detMed = $mMed->det;
$lLab = $mLab->getAllList();

if ($detMed) {
	$id = $detMed['id_form'];
	$nom = "<span class='badge badge-info'>$id</span> 
	<span class='badge badge-light'>{$detMed['generico']}</span> 
	<span class='badge badge-light'>{$detMed['comercial']}</span>";
	$acc = md5("UPDm");
	$accClon = md5("CLONm");
	$btnAcc = "<button type='submit' class='btn btn-success'>{$cfg['b']['upd']}</button>";
	$btnClon = "<a class='btn btn-info btn-large navbar-btn' href='_acc.php?ids=$ids&acc=$accClon&url=$urlc'>{$cfg['b']['clone']}</a>";
	$btnAccTD = "<button id='dtAG' class='btn btn-primary btn-block btn-sm' type='submit'>Agregar a la receta</button>";
} else {
	$id = null;
	$nom = null;
	$acc = md5("INSm");
	$btnAcc = "<button type='submit' class='btn btn-primary'>{$cfg['b']['ins']}</button>";
}
$btnNew = "<a href='$urlc' class='btn btn-default navbar-btn'>{$cfg['b']['new']}</a>";

if (isset($_SESSION['tab']['medf'])) {
	$tabS = $_SESSION['tab']['medf'];
	unset($_SESSION['tab']['medf']);
} else {
	$tabS['tabA'] = 'active';
}
?>

<?php

$dC['mod_nom'] = $dM['mod_nom'] ?? null;
echo genHeader($dC, 'page-header', $nom, $btnNew)
?>

<div>
	<div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="<?php echo $tabS["tabA"] ?? null ?>">
				<a href="#tabA" aria-controls="home" role="tab" data-toggle="tab">Datos del Medicamento</a>
			</li>
			<li role="presentation" class="<?php echo $tabS["tabB"] ?? null ?>">
				<a href="#tabB" aria-controls="profile" role="tab" data-toggle="tab">Agrupación de Medicamentos</a>
			</li>
		</ul>
		<div class="tab-content panel panel-default">
			<div role="tabpanel" class="<?php echo $tabS["tabA"] ?? null ?> tab-pane panel-body" id="tabA">
				<form method="post" action="_acc.php" role="form">
					<div class="btn btn-group">
						<?php echo $btnAcc ?? null ?>
						<?php echo $btnClon ?? null ?>
					</div>
					<fieldset>
						<input name="form" type="hidden" id="form" value="<?php echo md5('fmed') ?>">
						<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
						<input name="ids" type="hidden" id="ids" value="<?php echo $ids ?>">
						<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
						<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
					</fieldset>

					<div class="row">
						<div class="col-sm-5">
							<fieldset class="form-horizontal">
								<div class="form-group">
									<label for="generico" class="col-sm-2 control-label">Laboratorio</label>
									<div class="col-sm-10">
										<?php echo $db->genSelectA($lLab, 'lab', $detMed['lab'] ?? null, 'form-control', null, null, TRUE, null, '- Seleccionar laboratorio -') ?>
									</div>
								</div>
								<div class="form-group">
									<label for="generico" class="col-sm-2 control-label">Nombre Generico</label>
									<div class="col-sm-10">
										<input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detMed['generico'] ?? null ?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="generico" class="col-sm-2 control-label">Nombre Comercial</label>
									<div class="col-sm-10">
										<input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detMed['comercial'] ?? null ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="presentacion" class="col-sm-2 control-label">Presentación</label>
									<div class="col-sm-10">
										<input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detMed['presentacion'] ?? null ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="presentacion" class="col-sm-2 control-label">Código Dosis</label>
									<div class="col-sm-10">
										<input name="cantidad" type="text" class="form-control" placeholder="Dosis" value="<?php echo $detMed['cantidad'] ?? null ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="presentacion" class="col-sm-2 control-label">Estado</label>
									<div class="col-sm-10">
										<?php $params = array("1" => "Activo", "0" => "Inactivo");
										echo genFormsInpRadio($params, $detMed['estado'] ?? null, 'inline', 1, 'estado') ?>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="col-sm-7">
							<fieldset class="form-horizontal">

								<div class="form-group">
									<label for="descripcion" class="col-sm-2 control-label">RP.</label>
									<div class="col-sm-10">
										<textarea name="descripcion" rows="9" class="form-control" id="descripcion"><?php echo $detMed['descripcion'] ?? null ?></textarea>
									</div>
								</div>


							</fieldset>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="<?php echo $tabS["tabB"] ?? null ?> tab-pane panel-body" id="tabB">
				<?php include("_medicamentosFormGroup.php") ?>
			</div>
		</div>
	</div>


</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#lab').select2();
	});
</script>