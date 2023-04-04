<?php $rTyp = $_GET['ref'] ?? $_POST['ref'] ?? null;
if ($rTyp) {
	$param['typ'] = array('typ_ref', '=', $rTyp);
	$uTyp = '&ref=' . $rTyp; //Parametro para URL
}
$paramSQL = getParamSQLA($param ?? null);
$TR = totRowsTabP('db_types', $paramSQL);
if ($TR > 0) {
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->paginate();
	$qry = 'SELECT * FROM db_types WHERE 1=1 ' . $paramSQL . ' ORDER BY typ_cod DESC ' . $pages->limit;
	$RSl = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRSl = mysqli_fetch_assoc($RSl);
	$tRSl = mysqli_num_rows($RSl);
}
?>
<div class="well well-sm">
	<a href="form.php?<?php echo $uTyp ?? null ?>" class="btn btn-primary btn-sm pull-right fancybox.iframe fancyreload">
		<span class="fa fa-plus"></span> Nuevo Tipo
	</a>
	<form class="form-inline">
		<span class="label label-default">Filtros</span>
		<label class="control-label">Referencia</label>
		<?php genSelect('typ_cod', detRowGSel('db_types', 'typ_ref', 'DISTINCT (typ_ref)', '1', '1'), $rTyp, 'form-control', 'required', NULL, 'Seleccione', TRUE, NULL, 'Todos') ?>
	</form>
</div>
<?php if ($tRSl > 0) { ?>
	<div>
		<?php sLOG('g'); ?>
		<div class="well well-sm">
			<div class="row">
				<div class="col-sm-8">
					<ul class="pagination cero"><?php echo $pages->display_pages() ?></ul>
				</div>
				<div class="col-sm-4"><?php echo $pages->display_items_per_page() ?></div>
			</div>

		</div>
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" id="itm_table">
				<thead>
					<tr>
						<th>ID</th>
						<th></th>
						<th>Módulo</th>
						<th>Nombre</th>
						<th>Ref</th>
						<th>Valor</th>
						<th>Aux</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php do {
						$row_cod = $dRSl['typ_cod'] ?? null;
						$row_mref = $dRSl['mod_ref'] ?? null;
						$row_ref = $dRSl['typ_ref'] ?? null;
						$row_nom = $dRSl['typ_nom'] ?? null;
						$row_val = $dRSl['typ_val'] ?? null;
						$row_aux = $dRSl['typ_aux'] ?? null;
						$btnStat = genStatus('fncts.php', array('ids' => $row_cod, 'val' => $dRSl['typ_stat'], 'acc' => md5('STt'), 'ref' => $rTyp, "url" => $urlc));
					?>
						<tr>
							<td><?php echo $row_cod ?></td>
							<td><?php echo $btnStat ?></td>
							<td><?php echo $row_mref ?></td>
							<td><?php echo $row_nom ?></td>
							<td><?php echo $row_ref ?></td>
							<td><?php echo $row_val ?></td>
							<td><?php echo $row_aux ?></td>
							<td>
								<div class="btn-group">
									<a href="form.php?id=<?php echo $row_cod ?>" class="btn btn-info btn-xs fancybox.iframe fancyreload">
										<i class="fa fa-edit fa-lg"></i> Editar</a>
									<a href="fncts.php?id=<?php echo $row_cod ?? null ?>&acc=<?php echo md5('DELt') ?>&url=<?php echo $urlc . ($uTyp ?? null) ?>" class="btn btn-danger btn-xs">
										<i class="fa-solid fa-trash fa-lg"></i> Eliminar</a>
								</div>
							</td>
						</tr>
					<?php } while ($dRSl = mysqli_fetch_assoc($RSl)); ?>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<div class="alert alert-warning">
			<h4>Not Found Items !</h4>
		</div>';
	<?php } ?>
	</div>
	<script type="text/javascript">
		$("#typ_cod").change(function() {
			window.location.href = "?ref=" + $("#typ_cod").val();
			//alert("The text has been changed.");
		});
	</script>