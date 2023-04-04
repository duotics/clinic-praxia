<?php
$fi = $_GET['fi'] ?? $_POST['fi'] ?? $sdate; //$_REQUEST[fi];
$ff = $_GET['ff'] ?? $_POST['ff'] ?? $sdate; //$_REQUEST[ff];

$fiF = $fi . ' 00:00:00';
$ffF = $ff . ' 23:59:59';

$sum = 0;
$contPac = 0;

if ($fi && $ff) {
	$qry = sprintf(
		'SELECT * FROM db_consultas WHERE con_fec>=%s AND con_fec<=%s LIMIT 500',
		SSQL($fiF, 'date'),
		SSQL($ffF, 'date')
	);
	$RS = mysqli_query(conn, $qry);
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
}
?>
<div class="well">
	<form action="<?php echo $urlc ?>" method="get">
		<fieldset class="form-inline">
			<div class="form-group">
				<label for="" class="control-label">Fecha Inicio</label>
				<input type="date" value="<?php echo $fi ?>" class="form-control" name="fi">
			</div>
			<div class="form-group">
				<label for="" class="control-label">Fecha Fin</label>
				<input type="date" value="<?php echo $ff ?>" class="form-control" name="ff">
			</div>
			<div class="form-group">
				<button class="btn btn-sm btn-success" type="submit">Consultar</button>
				<a class="printerButton btn btn-default btn-sm" data-val="<?php echo $fi ?>/<?php echo $ff ?>" data-rel="<?php echo $RAIZc ?>com_reportes/rep_resd_printJS.php">
					<i class="fa fa-print fa-lg"></i> Imprimir</a>
			</div>
		</fieldset>
	</form>

</div>
<div class="">
	<?php if ($tRS > 0) { ?>

		<table class="table table-bordered">
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
					<?php $dPac = detRow('db_pacientes', 'pac_cod', $dRS["pac_cod"]);
					$dTC = detRow('db_types', 'typ_cod', $dRS["con_typvis"]);
					$dTP = detRow('db_types', 'typ_cod', $dRS["con_typ"]);
					$sum += $dRS["con_val"];
					if ($fi == $ff) $detFec = date_format(date_create($dRS["con_fec"]), 'H:m:s');
					else $detFec = $dRS["con_fec"];
					$contPac++;
					?>
					<tr>
						<td><a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $dRS["con_num"] ?>"><?php echo $dRS["con_num"] ?></a></td>
						<td><?php echo $detFec ?></td>
						<td><?php echo $dPac["pac_ape"] . ' ' . $dPac["pac_nom"] ?></td>
						<td><?php echo $dTC["typ_val"] ?? null ?></td>
						<td><?php echo $dTP["typ_val"] ?? null ?></td>
						<td><?php echo $dRS["con_val"] ?? null ?></td>
					</tr>
				<?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
			</tbody>
			<tfoot>
				<tr>
					<td style="border-top: 1px solid #eee" colspan="2" class="text-right"><strong>PACIENTES: </strong></td>
					<td style="border-top: 1px solid #eee" class="text-left"><?php echo $contPac ?></td>
					<td colspan="2" class="text-right"><strong>TOTAL</strong></td>
					<td><strong><?php echo number_format($sum, 2) ?></strong></td>
				</tr>
			</tfoot>
		</table>

	<?php } else { ?>
		<div class="alert alert-warning">
			<h4>Sin Resultados</h4>
		</div>
	<?php } ?>
</div>