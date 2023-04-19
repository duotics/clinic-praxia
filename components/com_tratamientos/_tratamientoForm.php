<?php
$idsTrat = $_GET['kt'] ?? $_POST['kt'] ?? null;

$mTrat = new App\Models\Tratamiento;
$mCon = new App\Models\Consulta;
$mPac = new App\Models\Paciente;
$mMed = new App\Models\Medicamento;
$mInd = new App\Models\Indicacion;
$mTipo = new App\Models\Tipo;

try {
	if ($idsTrat) {
		$mTrat->setID($idsTrat);
		$mTrat->det();
		$dTrat = $mTrat->det;
		if ($dTrat) {
			$acc = md5('UPDt');
			$idt = $dTrat["idTrat"];
			$idc = $dTrat["con_num"] ?? null;
			if ($idc) {
				$idsCon = md5($idc);
				$mCon->setID($idsCon);
				$mCon->det();
				$dCon = $mCon->det;
				$idp = $dCon['pac_cod'] ?? null;
				if ($idp) {
					$idsPac = md5($idp);
					$mPac->setID($idsPac);
					$mPac->det();
					$dPac = $mPac->det;
					$dPac_nom = "{$dPac['pac_nom']} {$dPac['pac_ape']}";
				}
			}

			$btnAcc = "<button name='btnA' type='submit' class='btn btn-success btn-narvar'>{$cfg['b']['ins']}</button>";
			$btnP = "<button name='btnP' type='submit' class='btn btn-light btn-navbar'>{$cfg['i']['print']} GUARDAR E IMPRIMIR</button>";
			$lMedList = $mMed->getAllSelect(); //LISTADO DE MEDICAMENTOS
			$lIndList = $mInd->getAllSelect(); //LISTADO DE INDICACIONES

			$listadoTratamientosAnteriores = $mTrat->listadoTratamientosAnteriores($idsPac);
			$contTop = "";

			$contTop = "<i class='fa fa-columns fa-lg'></i> TRATAMIENTO
			<span class='badge bg-primary'>{$idt}</span>
			<span class='badge bg-dark'>Consulta</span>
			<span class='badge bg-dark'>{$idc}</span>
			<span class='badge bg-light'>{$dPac_nom}</span>";
			$mTpl = new App\Core\TemplateGen(["css" => "cero"], null, null, null, null, null, [null, 'card', $contTop, $btnAcc . $btnP, null, 'text-bg-primary', 'h3']);
			$mTpl->renderHead();
		} else {
			throw new Exception("Tratamiento no existe intente nuevamente");
		}
	} else {
		throw new Exception("ID Tratamiento es requerido");
	}
?>
	<div>
		<form method="post" action="_acc.php">
			<fieldset>
				<input name="idt" type="hidden" id="idt" value="<?php echo $idsTrat ?>">
				<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
				<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
				<input name="form" type="hidden" id="form" value="<?php echo md5("tratForm") ?>">
			</fieldset>
			<?php $mTpl->renderTop() ?>
			<div class="card mb-2">
				<div class="card-body">
					<fieldset class="row row-cols-lg-auto g-3 align-items-center">
						<div class="col-12">
							<label class="control-label">Fecha Receta</label>
							<input name="fecha" type="date" required class="form-control input-sm" id="fecha" value="<?php echo $dTrat['date'] ?? null ?>" autofocus>
						</div>
						<div class="col-12">
							<label class="control-label">Observaciones</label>
							<input name="obs" type="text" class="form-control input-sm" id="obs" placeholder="otras indicaciones" value="<?php echo $dTrat['obs'] ?>">
						</div>
						<div class="col-12">
							<label class="control-label">Proxima Consulta</label>
							<input name="con_diapc" type="number" class="form-control input-sm" id="con_diapc" value="<?php echo $dCon['con_diapc'] ?>">
						</div>
						<div class="col-12">
							<label class="control-label">Tipo de Proxima Visita</label>
							<?php echo $db->genSelectA($mTipo->getSelTipRef("TIPVIS"), 'con_typvisP', $dCon['con_typvisP'] ?? null, ' form-control input-sm setDB', 'data-id="' . $idsCon . '" data-rel="pac"', NULL, true, 0) ?>
						</div>
					</fieldset>
				</div>
			</div>
		</form>
		<div>
			<div class="row">
				<div class="col-sm-9">
					<div class="card mb-2">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<label for="listMed" class="col-sm-4 form-label">Medicamentos</label>
										<div class="col-sm-8">
											<?php echo $db->genSelectA($lMedList, 'listMed', NULL, 'form-select form-select-sm', "data-val='{$idsTrat}'", null, true, null, '- Seleccione Medicamento -') ?>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="row">
										<label for="listInd" class="col-sm-4 form-label">Indicaciones</label>
										<div class="col-sm-8">
											<?php echo $db->genSelectA($lIndList, 'listInd', NULL, 'form-select form-select-sm', "data-val='{$idsTrat}'", null, true, null, '- Seleccione Indicacion -') ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php include("_tratamientoFormTable.php") ?>
				</div>
				<div class="col-sm-3">
					<?php include("_tratamientoFormHist.php") ?>
				</div>
			</div>
		</div>


		<script type="text/javascript">
			$(document).ready(function() {
				$('#listMed').select2({
					width: "100%"
				});
				$('#listInd').select2({
					width: "100%"
				});
				$('#listMed').on('change', function(evt, params) {
					doGetMedicamento(evt, params);
					$('#txtDesMod').html('Prescripcion');
					$('#txtDesMod').focus();
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
	</div>
<?php } catch (Exception $e) { ?>
	<div class="alert alert-danger"><?php echo $e->getMessage() ?></div>
<?php } ?>