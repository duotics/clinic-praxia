<?php require('../../init.php');
$_SESSION['tab']['con'] = 'cTRA';

$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idt = $_GET['idt'] ?? $_POST['idt'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;

//ACCIONES HEADER LOCATION
if ($acc == md5("DELtf")) header(sprintf("Location: %s", '_fncts.php?idt=' . $idt . '&acc=' . $acc));
if ($acc == md5("NEWt")) header(sprintf("Location: %s", '_fncts.php?idc=' . $idc . '&idp=' . $idp . '&acc=' . $acc . '&url=' . $urlc));

use App\Models\Tratamiento;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Medicamento;
use App\Models\Indicacion;

$mTrat = new Tratamiento();
$mCon = new Consulta();
$mPac = new Paciente();
$mMed = new Medicamento();
$mInd = new Indicacion();

$mTrat->setID(md5($idt));
$mTrat->det();
$dTrat = $mTrat->det;

if ($dTrat) {
	$fechaReceta = $dTrat['fecha'];
	$dCon = detRow('db_consultas', 'con_num', $dTrat["con_num"]);
	$acc = 'UPDt';
	$btnAcc = '<button name="btnA" type="submit" class="btn btn-success btn-narvar"><i class="fa fa-refresh"></i> GUARDAR</button>';
	$btnP = '<button name="btnP" type="submit" class="btn btn-default btn-navbar"><i class="fa fa-print"></i> GUARDAR E IMPRIMIR</button>';
	$idc = $dTrat['con_num'];
	$dCon = detRow('db_consultas', 'con_num', $idc);
	$detDiag_nom = $dTrat['diagnostico'];
	$lMedList = $mMed->getAllSelect(); //LISTADO DE MEDICAMENTOS

	$idtd = $_GET['idtd'] ?? $_POST['idtd'] ?? null;
	$detTD = detRow('db_tratamientos_detalle', 'id', $idtd);
	if ($detTD) { //Detalle Tratamiento
		$accTD = md5("UPDtd");
		$btnAccTD = '<button name="btnA" id="dtAG" class="btn btn-success btn-block btn-sm" type="submit"><i class="fa fa-floppy-o fa-lg"></i> Actualizar en la receta</button>';
	} else {
		$accTD = md5("INStd");
		$btnAccTD = '<button id="dtAG" class="btn btn-primary btn-block btn-sm" type="submit"><i class="fa fa-floppy-o fa-lg"></i> Agregar a la receta</button>';
	}
} else {
	$fechaReceta = $sdate;
	$acc = 'INSt';
	$btnAcc = '<button type="submit" class="btn btn-large btn-info"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
	$dCon = detRow('db_consultas', 'con_num', $idc);
	$detDiag = detRow('db_diagnosticos', 'id_diag', $dCon['con_diagd']);
	$detDiag_nom = $detDiag['nombre'];
}
$mCon->setID(md5($idc));
$mCon->det();
$dCon = $mCon->det;

$idp = $dCon['pac_cod'];

$mPac->setID(md5($idp));
$mPac->det();
$dPac = $mPac->det;

$dPac_nom = $dPac['pac_nom'] . ' ' . $dPac['pac_ape'];

$listadoTratamientosAnteriores = $mTrat->listadoTratamientosAnteriores($idp);

$css['body'] = 'cero';
include(RAIZf . 'head.php'); ?>
<?php sLOG('g'); ?>
<form method="post" action="_fncts.php">
	<fieldset>
		<input name="idt" type="hidden" id="idt" value="<?php echo $idt ?>">
		<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
		<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
		<input name="form" type="hidden" id="form" value="tratdet">
	</fieldset>
	<nav class="navbar navbar-default cero" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><i class="fa fa-columns fa-lg"></i> TRATAMIENTO
				<span class="label label-info"><?php echo $idt ?></span></a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse-2">
			<ul class="nav navbar-nav">
				<li class="active"><a><?php echo $dPac_nom ?></a></li>
				<li><a>Consulta <span class="label label-default"><?php echo $idc ?></span></a></li>
				<li><a><?php echo $dTrat['fecha'] ?></a></li>
			</ul>
			<div class="navbar-right btn-group navbar-btn">
				<?php echo $btnAcc ?>
				<?php echo $btnP ?>
				</li>
			</div>
		</div><!-- /.navbar-collapse -->
	</nav>
	<div class="container-fluid">
		<div class="well well-sm">
			<fieldset class="form-inline">
				<label class="control-label">Fecha Receta</label>
				<input name="fecha" type="date" required class="form-control input-sm" id="fecha" value="<?php echo $fechaReceta ?>" autofocus>
				<label class="control-label">Observaciones</label>
				<input name="obs" type="text" class="form-control input-sm" id="obs" placeholder="otras indicaciones" value="<?php echo $dTrat['obs'] ?>">
				<label class="control-label">Proxima Consulta</label>
				<input name="con_diapc" type="number" class="form-control input-sm" id="con_diapc" value="<?php echo $dCon['con_diapc'] ?>">
				<label class="control-label">Tipo de Proxima Visita</label>
				<?php
				$paramsN[] = array(
					array("cond" => "AND", "field" => "typ_ref", "comp" => "=", "val" => 'TIPVIS'),
					array("cond" => "AND", "field" => "typ_stat", "comp" => '=', "val" => 1)
				);
				$RS = detRowGSelNP('db_types', 'typ_cod', 'typ_val', $paramsN, TRUE, 'typ_val', 'ASC');
				genSelect('con_typvisP', $RS, $dCon['con_typvisP'], 'form-control input-sm', ' onChange="setDB(this.name,this.value,' . $idc . ',' . "'con'" . ')"', 'con_typvisP', NULL, TRUE, NULL, '- Seleccione -'); ?>
			</fieldset>
		</div>
	</div>
</form>
<?php if ($dTrat) { ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-9">
				<form method="post" action="_fncts.php">
					<fieldset>
						<input name="trat_id" type="hidden" id="trat_id" value="<?php echo $idt ?>">
						<input name="idtd" type="hidden" id="idtd" value="<?php echo $idtd ?>">
						<input name="acc" type="hidden" id="acc" value="<?php echo $accTD ?>">
						<input name="form" type="hidden" id="form" value="tratdet">
						<input name="tipTD" type="hidden" id="tipTD" value="<?php echo $detTD['tip'] ?>">
						<input name="idref" type="hidden" id="idref" value="">
						<input name="url" type="hidden" value="<?php echo $urlc ?>">
					</fieldset>
					<fieldset class="form-horizontal" style="display: none;">
						<div class="form-group">
							<label for="generico" class="col-sm-2 control-label">Medicamento</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-6"><input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detTD['generico'] ?? null ?>"></div>
									<div class="col-sm-6"><input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detTD['comercial'] ?? null ?>"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="presentacion" class="col-sm-2 control-label">Información</label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-sm-4"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detTD['presentacion'] ?? null ?>"></div>
									<div class="col-sm-4"><input name="cantidad" type="text" class="form-control" id="cantidad" placeholder="Dosis" value="<?php echo $detTD['cantidad'] ?? null ?>"></div>
									<div class="col-sm-4"><input name="numero" type="text" class="form-control" id="numero" placeholder="#" value="<?php echo $detTD['numero'] ?? null ?>"></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="descripcion" class="col-sm-2 control-label" id="txtDesMod">Prescripción</label>
							<div class="col-sm-10">
								<textarea name="descripcion" rows="4" class="form-control" id="descripcion"><?php echo $detTD['descripcion'] ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<?php echo $btnAccTD; ?>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-horizontal">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="generico" class="col-sm-3 control-label">Listado Medicamentos</label>
									<div class="col-sm-9">
										<?php
										echo $db->genSelectA($lMedList, 'listMed', NULL, 'form-control input-sm', "data-val='{$idt}'", 'listMed', true, null, '- Seleccione Medicamento -');
										?>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="generico" class="col-sm-3 control-label">Listado Indicaciones</label>
									<div class="col-sm-9">
										<?php genSelect('listInd', detRowGSel('db_indicaciones', 'id', 'des', 'est', '1', TRUE, 'feat', 'DESC'), NULL, ' form-control input-sm', NULL, NULL, 'Seleccione'); ?>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
				<div class="panel panel-primary">
					<?php $listadoTratamientos = $mTrat->listTratamientosDetalle($idt);
					if ($listadoTratamientos) {
					?>
						<div class="panel-heading">
							<h4 class="panel-title"><i class="fa fa-columns fa-lg"></i> Receta Médica</h4>
						</div>
						<div class="table-responsive">
							<table class="table table-bordered table-striped tbl-qa">
								<thead>
									<tr>
										<th class="table-header">Generico</th>
										<th class="table-header">Comercial</th>
										<th class="table-header">Pres</th>
										<th class="table-header">Dosis</th>
										<th class="table-header">#</th>
										<th class="table-header">Prescripción</th>
										<th class="table-header"></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($listadoTratamientos as $dRStl) { ?>
										<?php switch ($dRStl['tip']) {
											case 'G':
												echo '<tr aux="G">
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'generico'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["generico"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'comercial'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["comercial"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'presentacion'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["presentacion"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'cantidad'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["cantidad"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'numero'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["numero"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'descripcion'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["descripcion"] . '</td>
			<td>
			<a href="_fncts.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '&acc=' . md5("DELtd") . '&url=' . $urlc . '" class="btn btn-danger btn-xs">
			<i class="fa-solid fa-trash"></i> Quitar</a>
			</td>
		</tr>';
												break;
											case 'M':
												echo '<tr aux="M">
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'generico'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["generico"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'comercial'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["comercial"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'presentacion'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["presentacion"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'cantidad'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["cantidad"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'numero'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["numero"] . '</td>
			<td contenteditable="true" onBlur="saveToDatabase(this,' . "'descripcion'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["descripcion"] . '</td>
			<td>
			<a href="_fncts.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '&acc=' . md5("DELtd") . '&url=' . $urlc . '" class="btn btn-danger btn-xs">
			<i class="fa-solid fa-trash"></i> Quitar</a>
			</td>
		</tr>';
												break;
											case 'I':
												echo '<tr class="info" aux="I">
		<td colspan="6" contenteditable="true" onBlur="saveToDatabase(this,' . "'indicacion'" . ',' . "'" . $dRStl["id"] . "'" . ')" onClick="showEdit(this);">' . $dRStl["indicacion"] . '</td>
		<td><a href="_fncts.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '&acc=' . md5("DELtd") . '&url=' . $urlc . '" class="btn btn-danger btn-xs">
		<i class="fa-solid fa-trash"></i> Quitar</a>
		</td>
	</tr>';
												break;
										} ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					<?php } else echo '<div class="alert alert-warning"><h4>Sin Medicamentos Registrados</h4></div>'; ?>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="panel panel-default">
					<div class="panel-heading">Historial Recetas</div>
					<?php if ($listadoTratamientosAnteriores) { ?>
						<table class="table table-condensed">
							<?php foreach ($listadoTratamientosAnteriores as $dRS) { ?>
								<?php
								$listTratAntDetMed = $mTrat->listTratamientosDetalle($dRS['tid'], 'M');
								$listTratAntDetInd = $mTrat->listTratamientosDetalle($dRS['tid'], 'I');
								$resDiag = NULL;
								$mCon->setID(md5($dRS['con_num']));
								$listConsDiag = $mCon->getAllDiag(2);
								if ($listConsDiag > 0) {
									foreach ($listConsDiag as $dRSld) {
										$resDiag .= "<span class='btn btn-default btn-xs'>{$dRSld['NOM']}</span>";
									}
								}
								$fecConAnt = DateTime::createFromFormat('Y-m-d', $dRS['fecha']);
								$fecConAnt = $fecConAnt->format('d \d\e F \d\e Y');
								$fecConAnt = changeDateEnglishToSpanish($fecConAnt);
								?>
								<tr class="info">
									<td colspan="2" class="">
										<span class="btn btn-info btn-xs"><?php echo $fecConAnt ?></span>
										<?php echo $resDiag ?>
									</td>
								</tr>
								<tr>
									<td>
										<?php if ($listTratAntDetMed) { ?>
											<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
												<tbody>
													<?php foreach ($listTratAntDetMed as $dRStl) { ?>
														<?php $detTdet_med = $dRStl['generico'] . ' ( ' . $dRStl['comercial'] . ' )'; ?>
														<tr>
															<td><?php echo $detTdet_med ?></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										<?php } else echo '<div>No hay Medicamentos Prescritos</div>' ?>
									</td>
									<td>
										<?php if ($listTratAntDetInd) { ?>
											<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
												<tbody>
													<?php foreach ($listTratAntDetInd as $dRStli) { ?>
														<tr>
															<td><?php echo $dRStli['indicacion'] ?></td>
														<?php } ?>
												</tbody>
											</table>
										<?php } else echo '<div>No hay Indicaciones</div>' ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					<?php } else { ?>
						<div class="panel-body">
							<p>No hay recetas anteriores</p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php if ($dTrat) { ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#listMed').chosen({
				width: "100%"
			});
			$('#listMed').on('change', function(evt, params) {
				doGetMedicamento(evt, params);
				$('#txtDesMod').html('Prescripcion');
				$('#txtDesMod').focus();
			});
			$('#listInd').chosen({
				width: "100%"
			});
			$('#listInd').on('change', function(evt, params) {
				doGetIndicaciones(evt, params);
				$('#txtDesMod').html('Indicaciones');
				$('#txtDesMod').focus();
			});
			$("#printerButton").trigger("click");
		});

		function doGetMedicamento(evt, params) {
			var id = params.selected;
			$.getJSON("json.medicamento.php?term=" + id, function(data) {
				$.each(data, function(key, val) {

					$("#idref").val(val.id);
					$("#generico").val(val.generico);
					$("#comercial").val(val.comercial);
					$("#presentacion").val(val.presentacion);
					$("#cantidad").val(val.cantidad);
					$("#descripcion").val(val.descripcion);
					$("#tipTD").val('M');
					$("#dtAG").trigger("click");
				});
			});
		}

		function doGetIndicaciones(evt, params) {
			var id = params.selected;
			$.getJSON("json.indicacion.php?term=" + id, function(data) {
				$.each(data, function(key, val) {

					$("#idref").val(val.id);
					$("#descripcion").val(val.des);
					$("#tipTD").val('I');
					$("#dtAG").trigger("click");
				});
			});
		}

		function showEdit(editableObj) {
			$(editableObj).css("background", "#FFF");
		}

		function saveToDatabase(editableObj, column, id) {
			$(editableObj).css("background", "#FFF url(../../assets/images/loader.gif) no-repeat right");
			$.ajax({
				url: "saveDetTrat.php",
				type: "POST",
				data: 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id,
				success: function(data) {
					$(editableObj).css("background", "#FDFDFD");
				}
			});
		}
	</script>
<?php } else { ?>
	<script type="text/javascript">
		$('#diagnostico').focus();
	</script>
<?php } ?>
<?php include(RAIZf . 'footerC.php'); ?>