<?php require('../../init.php');
$_SESSION['tab']['con'] = 'cTRA';
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idt = $_GET['idt'] ?? $_POST['idt'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
//Eliminar Tratamiento
if ($acc == md5("DELtf")) header(sprintf("Location: %s", "_fncts.php?idt=$idt&acc=$acc"));
if ($acc == md5("NEWt")) header(sprintf("Location: %s", "_fncts.php?idc$idc&idp=$idp&acc$acc&url=$urlc"));
//FORM
$detTrat = detRow('db_tratamientos', 'tid', $idt);
if ($detTrat) {
	$fechaReceta = $detTrat['fecha'];
	$dCon = detRow('db_consultas', 'con_num', $detTrat["con_num"]);
	$acc = 'UPDt';
	$btntrat = '<button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> ACTUALIZAR</button>';
	$idc = $detTrat['con_num'];
	$detCon = detRow('db_consultas', 'con_num', $idc);
	$detDiag_nom = $detTrat['diagnostico'];
	//LISTADO DE MEDICAMENTOS
	$qRSlm = sprintf('SELECT id_form AS sID, CONCAT_WS(" ",generico," ( ",comercial," ) "," : ",presentacion, cantidad) as sVAL FROM db_medicamentos WHERE estado=1 OR generico IS NULL OR comercial IS NULL OR presentacion IS NULL OR cantidad IS NULL');
	$RSlm = mysqli_query(conn, $qRSlm) or die(mysqli_error(conn));

	$idtd = vParam('idtd', $_GET['idtd'], $_POST['idtd']);
	$detTD = detRow('db_tratamientos_detalle', 'id', $idtd);
	if ($detTD) { //Detalle Tratamiento
		$accTD = md5("UPDtd");
		$btnAccTD = '<button class="btn btn-success btn-block btn-sm" type="submit"><i class="fa fa-floppy-o fa-lg"></i> Actualizar en la receta</button>';
	} else {
		$accTD = md5("INStd");
		$btnAccTD = '<button class="btn btn-primary btn-block btn-sm" type="submit"><i class="fa fa-floppy-o fa-lg"></i> Agregar a la receta</button>';
	}
} else {
	$fechaReceta = $sdate;
	$acc = 'INSt';
	$btntrat = '<button type="submit" class="btn btn-large btn-info"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
	$detCon = detRow('db_consultas', 'con_num', $idc);
	$detDiag = detRow('db_diagnosticos', 'id_diag', $detCon['con_diagd']);
	$detDiag_nom = $detDiag['nombre'];
}
$detCon = detRow('db_consultas', 'con_num', $idc);
$idp = $detCon['pac_cod'];
$detPac = detRow('db_pacientes', 'pac_cod', $idp); //dPac($idp);
$detPac_nom = $detPac['pac_nom'] . ' ' . $detPac['pac_ape'];
$css['body'] = 'cero';
include(root['f'] . 'head.php'); ?>
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
	<nav class="navbar navbar-default" role="navigation">
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
				<li class="active"><a><?php echo $detPac_nom ?></a></li>
				<li><a>Consulta <span class="label label-default"><?php echo $idc ?></span></a></li>
				<li><a><?php echo $detTrat['fecha'] ?></a></li>
			</ul>
			<div class="navbar-right btn-group navbar-btn">
				<?php echo $btntrat ?>
				<?php echo $btnaction ?>
				<?php if ($idt) { ?>
					<a href="<?php echo $RAIZc; ?>com_tratamientos/receta_print.php?idt=<?php echo $idt ?>" class="btn btn-info"><i class="fa fa-print"></i> Imprimir</a>
				<?php } ?>
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
				<input name="obs" type="text" class="form-control input-sm" id="obs" placeholder="otras indicaciones" value="<?php echo $detTrat['obs'] ?>">
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

<?php if ($detTrat) { ?>


	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-5">

				<div class="panel panel-default">
					<div class="panel-body">
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
							<fieldset class="form-horizontal">

								<div class="form-group">
									<label for="generico" class="col-sm-3 control-label">Listado Medicamentos</label>
									<div class="col-sm-9">
										<?php genSelect('listMed', $RSlm, NULL, 'form-control input-sm', ''); ?>
									</div>
								</div>
								<div class="form-group">
									<label for="generico" class="col-sm-3 control-label">Listado Indicaciones</label>
									<div class="col-sm-9">
										<?php genSelect('listInd', detRowGSel('db_indicaciones', 'id', 'des', 'est', '1'), NULL, ' form-control input-sm', NULL, NULL, 'Seleccione');
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="generico" class="col-sm-2 control-label">Medicamento</label>
									<div class="col-sm-10">
										<div class="row">
											<div class="col-sm-6"><input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detTD['generico'] ?>"></div>
											<div class="col-sm-6"><input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detTD['comercial'] ?>"></div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="presentacion" class="col-sm-2 control-label">Información</label>
									<div class="col-sm-10">
										<div class="row">
											<div class="col-sm-4"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detTD['presentacion'] ?>"></div>
											<div class="col-sm-4"><input name="cantidad" type="text" class="form-control" id="cantidad" placeholder="Dosis" value="<?php echo $detTD['cantidad'] ?>"></div>
											<div class="col-sm-4"><input name="numero" type="text" class="form-control" id="numero" placeholder="#" value="<?php echo $detTD['numero'] ?>"></div>
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
						</form>
					</div>
				</div>


			</div>
			<div class="col-sm-7">
				<div class="well well-sm">
					<?php
					$qrytl = 'SELECT * FROM db_tratamientos_detalle WHERE tid=' . $idt . ' ORDER BY tip DESC';
					$RStl = mysqli_query(conn, $qrytl);
					$dRStl = mysqli_fetch_assoc($RStl);
					$tr_RStl = mysqli_num_rows($RStl);
					if ($tr_RStl > 0) {
					?>
						<h4><i class="fa fa-columns fa-lg"></i> Receta Medica</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Generico</th>
										<th>Comercial</th>
										<th>Pres</th>
										<th>Dosis</th>
										<th>#</th>
										<th>Prescripción</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php do { ?>
										<?php
										switch ($dRStl["tip"]) {
											case 'M':
												echo '<tr>
			<td>' . $dRStl['generico'] . '</td>
			<td>' . $dRStl['comercial'] . '</td>
			<td>' . $dRStl['presentacion'] . '</td>
			<td>' . $dRStl['cantidad'] . '</td>
			<td>' . $dRStl['numero'] . '</td>
			<td>' . $dRStl['descripcion'] . '</td>
			<td>
			<a href="tratamiento_form.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '" class="btn btn-primary btn-xs">
			<i class="fa fa-edit"></i> Editar</a>
			<a href="_fncts.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '&acc=' . md5("DELtd") . '&url=' . $urlc . '" class="btn btn-danger btn-xs">
			<i class="fa-solid fa-trash"></i> Quitar</a>
			</td>
			</tr>';
												break;
											case 'I':
												echo '<tr>
				<td colspan="6">' . $dRStl['indicacion'] . '</td>
				<td>
				<a href="tratamiento_form.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '" class="btn btn-primary btn-xs">
				<i class="fa fa-edit"></i> Editar</a>
				<a href="_fncts.php?idt=' . $idt . '&idtd=' . $dRStl['id'] . '&acc=' . md5("DELtd") . '&url=' . $urlc . '" class="btn btn-danger btn-xs">
				<i class="fa-solid fa-trash"></i> Quitar</a>
				</td>
			</tr>';
												break;
										} ?>
									<?php } while ($dRStl = mysqli_fetch_assoc($RStl)); ?>
								</tbody>
							</table>
						</div>
					<?php } else echo '<div class="alert alert-warning"><h4>Sin Medicamentos Registrados</h4></div>'; ?>
				</div>

			</div>
		</div>
	</div>

<?php } ?>

<?php if ($detTrat) {

?>
	<script type="text/javascript">
		$('#medicamento').focus();
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
				});
			});
		}
	</script>
<?php } else { ?>
	<script type="text/javascript">
		$('#diagnostico').focus();
	</script>
<?php } ?>
<?php include(root['f'] . 'footer.php'); ?>