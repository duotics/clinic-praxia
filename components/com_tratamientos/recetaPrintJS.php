<?php include_once('../../init.php');

use App\Models\Tratamiento;
use App\Models\Consulta;
use App\Models\Paciente;

$mTrat = new Tratamiento();
$mCon = new Consulta();
$mPac = new Paciente();

$idt = $_GET['id'] ?? $_POST['id'] ?? null;

if ($idt) {

	$mTrat->setID(md5($idt));
	$mTrat->det();
	$dTrat = $mTrat->det;

	if ($dTrat) {
		$idP = $dTrat['pac_cod'];
		$mPac->setID(md5($dTrat['pac_cod']));
		$mPac->det();
		$dPac = $mPac->det;

		$idC = $dTrat['con_num'];
		$mCon->setID(md5($dTrat['con_num']));
		$mCon->det();
		$dCon = $mCon->det;

		$dTrat_fecha = DateTime::createFromFormat('Y-m-d', $dTrat['fecha']);
		$dTrat_fecha = $dTrat_fecha->format('d \d\e F \d\e Y');
		$dTrat_fecha = changeDateEnglishToSpanish($dTrat_fecha);
		//LISTA DE DIAGNOSTICOS RELACIONADOS (2)
		$lDia = $mCon->getAllDiag(2);

		$resDiag = null;

		//DIAGNOSTICOS
		if ($lDia) {
			foreach ($lDia as $dDiag) {
				$resDiag .= "<td>{$dDiag['COD']}-{$dDiag['NOM']}</td>";
			}
		}
		// MEDICAMENTOS
		$lTrat = $mTrat->listTratamientosDetalle($idt);
		$resReceta = null;
		$proxima = null;
		$contmed = 1;
		$contind = 1;
		if ($lTrat > 0) {
			foreach ($lTrat as $dRStl) {
				$dRStl["generico"] = strtoupper($dRStl["generico"] ?? "");
				if ($dRStl["tip"] == 'G') {
					$resReceta .= "<tr><td>*</td>
					<td><strong style='text-decoration: underline;'>{$dRStl["generico"]}</strong></td>
					<td></td><td>*</td>
					<td><strong style='text-decoration: underline'>{$dRStl["generico"]}</strong><br>
					<span style='font-size:10px'>{$dRStl["descripcion"]}</span></td>
					</tr>";
				}
				$dRStl["generico"] = strtolower($dRStl["generico"] ?? "");
				if ($dRStl["tip"] == 'M') {
					$resReceta .= "<tr><td>•</td>
					<td><strong>{$dRStl["generico"]} ({$dRStl["comercial"]}) {$dRStl["presentacion"]} - # {$dRStl["numero"]}</strong></td>
					<td></td><td>•</td>
					<td><strong>{$dRStl["generico"]} ({$dRStl["comercial"]}) {$dRStl["presentacion"]} - # {$dRStl["numero"]}</strong><br>
					<span style='font-size:10px'>{$dRStl["descripcion"]}</span></td>
					</tr>";
				}
				if ($dRStl["tip"] == 'I') {
					if ($contind == 1) {
						$resReceta .= "<tr><td></td>
						<td></td><td></td>
						<td colspan='2'><div class='divider'></div><strong>INDICACIONES</strong></td>
						</tr>";
					}
					$dRStl["indicacion"] = strtoupper($dRStl["indicacion"]);
					$resReceta .= "<tr><td></td>
					<td></td><td></td><td></td>
					<td style='font-size:10px'>{$dRStl["indicacion"]}</td>
					</tr>";
					$contind++;
				}
				$contmed++;
			}
		}
		//NEW DATE FOR NEXT VISIT
		if ($dCon["con_diapc"]) {

			$finalDate = addDaysToDateNoWeekend($sdate, (int)$dCon["con_diapc"]);

			$datePV = new DateTime($finalDate);
			$nuevafecha = $datePV->format('l j \d\e F \d\e Y');
			$nuevafecha = changeDateEnglishToSpanish($nuevafecha, "all");
		}
		$proxima .= '<strong>PROXIMA VISITA. ' . ($nuevafecha ?? null) . '</strong>';
		if ($dCon["con_typvisP"]) {
			$detTyp = detRow('db_types', 'typ_cod', $dCon["con_typvisP"]);
			$proxima .= '<br>Tipo Visita. <strong>' . $detTyp['typ_val'] . '</strong>';
		}

		$css["body"] = 'cero';
		include(root['f'] . 'head.php');
?>
		<!--BEGIN PRINT RECETA-->
		<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>css/cssPrint_01-02.css" />

		<!--RECETA-->
		<div class="print print-receta">
			<!-- VIEW HEAD -->
			<table class="tabMin tabHead tabClear">
				<col style="width: 10%" class="col1">
				<col style="width: 40%">
				<col style="width: 14%">
				<col style="width: 36%">
				<tr>
					<td></td>
					<td><?php echo $dTrat_fecha ?> <strong>Ficha. <?php echo $dCon['pac_cod'] ?></strong></td>
					<td></td>
					<td><?php echo $dTrat_fecha ?> <strong>Ficha. <?php echo $dCon['pac_cod'] ?></strong></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $dPac['pac_nom'] . ' ' . $dPac['pac_ape'] ?></td>
					<td></td>
					<td style="padding-left:5px;"> <?php echo $dPac['pac_nom'] . ' ' . $dPac['pac_ape'] ?></td>
				</tr>
				<tr>
					<td></td>
					<td>* Documento Identidad. <?php echo $dPac['pac_ced'] ?></td>
					<td></td>
					<td style="padding-left:5px;"> * Documento Identidad. <?php echo $dPac['pac_ced'] ?></td>
				</tr>
			</table>
			<!-- VIEW DIAGNOSTICOS -->
			<div style="display: block; min-height:20px">
				<table class="tabMinA tabDiag tabClear">
					<tr>
						<?php echo $resDiag ?>
						<td></td>
						<?php echo $resDiag ?>

					</tr>
				</table>
			</div>
			<div class="divider"></div>
			<!--VIEW RECETA-->
			<div style="height: 507px; display: block">
				<table class="tabDet tabClear">
					<col style="width: 2%" class="col1">
					<col style="width: 44%">
					<col style="width: 6%">
					<col style="width: 2%">
					<col style="width: 46%">
					<?php echo $resReceta ?>
				</table>
			</div>
			<!--VIEW PROXIMA VISITA-->
			<table class="tabMinA tabClear">
				<col style="width: 5%" class="col1">
				<col style="width: 43%">
				<col style="width: 4%">
				<col style="width: 5%">
				<col style="width: 43%">
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?php echo $proxima ?></td>
				</tr>
			</table>
			<!--VIEW SELLOS-->
			<div>
				<div class="sello">
					<div class="selloR1"><img src="<?php echo $RAIZa ?>images/struct/selloA-02.jpg" alt="" style="width: 100%"></div>
				</div>
				<div class="sello">
					<div class="selloR2"><img src="<?php echo $RAIZa ?>images/struct/selloA-02.jpg" alt="" style="width: 100%"></div>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div class="alert alert-info">
			<h4>No se encontraron la receta</h4>
		</div>
	<?php } ?>
<?php } else { ?>
	<div class="alert alert-info">
		<h4>No se encontraron parámetros</h4>
	</div>
<?php } ?>
<!--END PRINT RECETA-->