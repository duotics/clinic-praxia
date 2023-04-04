<?php
$fi = $_REQUEST["fi"] ?? $sdate ?? null;
$ff = $_REQUEST["ff"] ?? $sdate ?? null;

$fiF = $fi . ' 00:00:00';
$ffF = $ff . ' 23:59:59';

if ($fi && $ff) {
	$qry = sprintf(
		'SELECT *, COUNT(db_tratamientos_detalle.idref) as at FROM db_tratamientos_detalle 
	INNER JOIN db_tratamientos ON db_tratamientos_detalle.tid = db_tratamientos.tid
	INNER JOIN db_consultas ON db_tratamientos.con_num = db_consultas.con_num 
	WHERE con_fec>=%s AND con_fec<=%s AND db_tratamientos_detalle.tip="M"
	GROUP BY db_tratamientos_detalle.idref
	ORDER BY at DESC
	LIMIT 500',
		SSQL($fiF, 'date'),
		SSQL($ffF, 'date')
	);
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
	//echo $qry;

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
				<a class="btn btn-sm btn-default" href="<?php echo $urlc ?>">Limpiar</a>
				<!--<a class="printerButton btn btn-default btn-sm" data-val="<?php echo $fi ?>/<?php echo $ff ?>" data-rel="<?php echo $RAIZc ?>com_reportes/rep_resd_printJS.php">
	<i class="fa fa-print fa-lg"></i> Imprimir</a>-->
			</div>
		</fieldset>
	</form>

</div>
<div class="">
	<?php if ($tRS > 0) { ?>

		<table class="table table-bordered" id="mytable">
			<thead>
				<tr>
					<th>ID</th>
					<th>Laboratorio</th>
					<th>Generico</th>
					<th>Comercial</th>
					<th>Recetas</th>
				</tr>
			</thead>
			<tbody>
				<?php $contAT = 0; ?>
				<?php do { ?>
					<?php $dM = detRow('db_medicamentos', 'id_form', $dRS['idref']);
					$dLab = detRow('db_types', 'typ_cod', $dM['lab']);
					$contAT += $dRS['at'];
					?>
					<tr>
						<td><a href="<?php echo $RAIZc . "com_medicamentos/medicamentosForm.php?id=" . $dM['id_form'] ?>"><?php echo $dM['id_form'] ?></a></td>
						<td><?php echo $dLab['typ_val'] ?? null ?></td>
						<td><?php echo $dM['generico'] ?? null ?></td>
						<td><?php echo $dRS['comercial'] ?? null ?></td>
						<td><?php echo $dRS['at'] ?? null ?></td>
					</tr>
				<?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
			</tbody>
			<tfoot>
				<tr>
					<td style="border-top: 1px solid #eee" colspan="2" class="text-right"><strong>TOTAL RECETADOS: </strong></td>
					<td style="border-top: 1px solid #eee" class="text-left"><?php echo $contAT ?></td>

				</tr>
			</tfoot>
		</table>

	<?php } else { ?>
		<div class="alert alert-warning">
			<h4>Sin Resultados</h4>
		</div>
	<?php } ?>
</div>