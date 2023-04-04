<?php
$TRt = totRowsTab('db_signos', 1, 1);
if ($TRt > 0) {
	$pages = new Paginator;
	$pages->items_total = $TRt;
	$pages->mid_range = 8;
	$pages->paginate();
	$RSd = mysqli_query(conn, 'SELECT * FROM db_signos ORDER BY id DESC' . ' ' . $pages->limit) or die(mysqli_error(conn));
	$dRSd = mysqli_fetch_assoc($RSd);
	$TR = mysqli_num_rows($RSd);
}
?>
<?php if ($TR > 0) { ?>
	<table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Fecha</th>
				<th><abbr title="Historia Clinica">H.C.</abbr></th>
				<th>Apellidos</th>
				<th>Nombres</th>
				<th>Peso Kg.</th>
				<th>Talla cm.</th>
				<th>I.M.C.</th>
				<th>P.A.</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php do { ?>
				<?php
				$detPac = detRow('db_pacientes', 'pac_cod', $dRSd['pac_cod']);
				$typ_tsan = fnc_datatyp($detPac['pac_tipsan']);
				$typ_tsan = $typ_tsan['typ_val'] ?? null;
				$typ_eciv = fnc_datatyp($detPac['pac_estciv']);
				$typ_eciv = $typ_eciv['typ_val'] ?? null;
				$typ_sexo = fnc_datatyp($detPac['pac_sexo']);
				$typ_sexo = $typ_sexo['typ_val'] ?? null;
				if ($typ_sexo == 'Masculino') $classsexo = ' label-info';
				if ($typ_sexo == 'Femenino') $classsexo = ' label-important';
				$IMC = calcIMC($dRSd['imc'], $dRSd['peso'], $dRSd['talla']);
				?>
				<tr>
					<td><?php echo $dRSd['id']; ?></td>
					<td><?php echo $dRSd['fecha']; ?></td>
					<td><?php echo $dRSd['pac_cod']; ?></td>
					<td><?php echo strtoupper($detPac['pac_nom']) ?></td>
					<td><?php echo strtoupper($detPac['pac_ape']) ?></td>
					<td><?php echo $dRSd['peso']; ?></td>
					<td><?php echo $dRSd['talla']; ?></td>
					<td><?php echo $IMC['val'] . ' ' . $IMC['inf']; ?></td>
					<td><?php echo $dRSd['paS'] . '/' . $dRSd['paD']; ?></td>
					<td class="text-center">
						<a class="btn btn-info btn-xs" href="form.php?ids=<?php echo md5($dRSd['pac_cod']) ?>">
							<i class="fa fa-stethoscope fa-lg"></i> Registrar</a>
					</td>
				</tr>
			<?php } while ($dRSd = mysqli_fetch_assoc($RSd)); ?>
		</tbody>
	</table>
	<?php include(RAIZf . 'paginator.php') ?>
	<?php mysqli_free_result($RSd); ?>
<?php } else {
	echo '<div class="alert alert-warning"><h4>Sin Coincidencias de Busqueda</h4></div>';
} ?>