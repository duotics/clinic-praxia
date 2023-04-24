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
			$mTit = new App\Core\genInterfaceTitle(null, 'card', $contTop, $btnAcc . $btnP, null, 'text-bg-primary', 'h3');
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
			<?php $mTit->render() ?>
			<div class="card mb-2">
				<div class="card-body">
					<fieldset class="row g-2">
						<div class="col-6 col-sm-3">
							<input name="fecha" type="date" required class="form-control form-control-sm" id="fecha" value="<?php echo $dTrat['date'] ?? null ?>" autofocus>
						</div>
						<div class="col-6 col-sm-3">
							<input name="obs" type="text" class="form-control form-control-sm" id="obs" placeholder="Observaciones" value="<?php echo $dTrat['obs'] ?>">
						</div>
						<div class="col-6 col-sm-3">
							<input name="con_diapc" type="number" class="form-control form-control-sm" id="con_diapc" value="<?php echo $dCon['con_diapc'] ?>" placeholder="Dias proxima visita">
						</div>
						<div class="col-6 col-sm-3">
							<?php echo $db->genSelectA($mTipo->getSelTipRef("TIPVIS"), 'con_typvisP', $dCon['con_typvisP'] ?? null, ' form-select form-select-sm setDB', 'data-id="' . $idsCon . '" data-rel="pac"', NULL, true, 0, "- Proxima Visita -") ?>
						</div>
					</fieldset>
				</div>
			</div>
		</form>
		<div>
			<div class="row">
				<div class="col-sm-9">
					<?php include("_tratamientoFormTable.php") ?>
				</div>
				<div class="col-sm-3">
					<?php include("_tratamientoFormHist.php") ?>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				$("#printerButton").trigger("click");
			});
		</script>
	</div>
<?php } catch (Exception $e) { ?>
	<div class="alert alert-danger"><?php echo $e->getMessage() ?></div>
<?php } ?>