<?php
$fi = $_REQUEST["fi"] ?? $sdate ?? null;
$ff = $_REQUEST["ff"] ?? $sdate ?? null;

$fiF = $fi . ' 00:00:00';
$ffF = $ff . ' 23:59:59';

if ($fi && $ff) {
	$qry = sprintf(
		'SELECT *, COUNT(db_consultas_diagostico.id_diag) as at FROM db_consultas_diagostico 
	INNER JOIN db_diagnosticos ON db_consultas_diagostico.id_diag = db_diagnosticos.id_diag
	INNER JOIN db_consultas ON db_consultas_diagostico.con_num = db_consultas.con_num 
	WHERE con_fec>=%s AND con_fec<=%s 
	GROUP BY db_consultas_diagostico.id_diag
	ORDER BY at DESC
	LIMIT 500',
		SSQL($fiF, 'date'),
		SSQL($ffF, 'date')
	);
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
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
				<a class="btn btn-sm btn-default" href="<?php echo $urlc ?>">Limpiar</a>
				<!--<a class="printerButton btn btn-default btn-sm" data-val="<?php echo $fi ?>/<?php echo $ff ?>" data-rel="<?php echo route['c'] ?>com_reportes/rep_resd_printJS.php">
	<i class="fa fa-print fa-lg"></i> Imprimir</a>-->
			</div>
		</fieldset>
	</form>

</div>
<div class="">
	<?php if ($tRS > 0) { ?>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>codigo</th>
					<th>Nombre</th>
					<th>Atenciones</th>
				</tr>
			</thead>
			<tbody>
				<?php $contAT = 0; ?>
				<?php do { ?>
					<?php
					$contAT += $dRS["at"];
					?>
					<tr>
						<td><?php echo $dRS['codigo'] ?? null ?></td>
						<td><?php echo $dRS['nombre'] ?? null ?></td>
						<td><?php echo $dRS['at'] ?? null ?></td>
					</tr>
				<?php } while ($dRS = mysqli_fetch_assoc($RS)); ?>
			</tbody>
			<tfoot>
				<tr>
					<td style="border-top: 1px solid #eee" colspan="2" class="text-right"><strong>DIAGNOSTICOS: </strong></td>
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