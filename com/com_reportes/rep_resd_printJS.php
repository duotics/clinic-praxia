<?php include('../../init.php');
$val = $_REQUEST["val"] ?? null;
$valF = explode('/', $val);
$fi = $valF[0];
$ff = $valF[1];

$sum = 0;
$contPac = 0;
if (!$fi) $fi = $sdate;
if (!$ff) $ff = $sdate;

$fiF = $fi . ' 00:00:00';
$ffF = $ff . ' 23:59:59';
if ($fi && $ff) {
	$qry = sprintf(
		'SELECT * FROM db_consultas WHERE con_fec>=%s AND con_fec<=%s LIMIT 500',
		SSQL($fiF, 'date'),
		SSQL($ffF, 'date')
	);
	$RS = mysqli_query(conn, $qry);
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
} ?>
<link rel="stylesheet" type="text/css" href="<?php echo $RAIZa ?>css/cssPrint_01-02.css" />
<?php $css["body"] = 'cero';
include(RAIZf . "head.php"); ?>
<div class="print print-report">
	<div class="titRep">Resumen de Visitas</div>
	<div class="titRep-b"><span>Desde <strong><?php echo $fi ?></strong></span> - <span>Hasta <strong><?php echo $ff ?></strong></span></div>

	<div>
		<?php if ($tRS > 0) { ?>

			<table class="tabMinC">
				<thead>
					<tr>
						<th>NUMERO</th>
						<th>FECHA</th>
						<th>PACIENTE</th>
						<th>TIPO DE VISITA</th>
						<th>TIPO DE PACIENTE</th>
						<th>VALOR</th>
					</tr>
				</thead>
				<tbody>
					<?php do { ?>
						<?php
						$dPac = detRow('db_pacientes', 'pac_cod', $dRS["pac_cod"]);
						$dTC = detRow('db_types', 'typ_cod', $dRS["con_typvis"]);
						$dTP = detRow('db_types', 'typ_cod', $dRS["con_typ"]);
						$sum += $dRS["con_val"];
						if (!$dRS["con_val"]) $dRS["con_val"] = '-';
						if ($fi == $ff) $detFec = date_format(date_create($dRS['con_fec']), 'H:m:s');
						else $detFec = $dRS["con_fec"];
						$contPac++;
						?>
						<tr>
							<td><?php echo $dRS["con_num"] ?></td>
							<td><?php echo $detFec ?></td>
							<td><?php echo $dPac["pac_ape"] . ' ' . $dPac["pac_nom"] ?></td>
							<td><?php echo $dTC["typ_val"] ?></td>
							<td><?php echo $dTP["typ_val"] ?></td>
							<td><?php echo $dRS["con_val"] ?></td>
						</tr>
					<?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
				</tbody>
				<tfoot>
					<tr>
						<td style="border-top: 1px solid #eee" colspan="2" class="text-right"><strong>PACIENTES: </strong></td>
						<td style="border-top: 1px solid #eee" class="text-left"><?php echo $contPac ?></td>
						<td style="border-top: 1px solid #eee" colspan="2" class="text-right"><strong>TOTAL: </strong></td>
						<td style="border-top: 1px solid #eee"><strong><?php echo number_format($sum, 2) ?></strong></td>
					</tr>
				</tfoot>
			</table>

		<?php } else { ?>
			<div class="alert alert-warning">
				<h4>Sin Resultados</h4>
			</div>
		<?php } ?>
	</div>
</div>
<?php include(RAIZf . "footerC.php") ?>