<?php
$param['idmc']['v'] = null;
$param['idmc']['q'] = null;
$TR = null;
if (isset($_REQUEST['idmc'])) $param['idmc']['v'] = $_REQUEST['idmc'];
$TRt = totRowsTab('dbMenuItem', '1', '1');
if ($TRt > 0) {
	$pages = new Paginator;
	$pages->items_total = $TRt;
	$pages->mid_range = 8;
	$pages->paginate();
	if ($param['idmc']['v']) $param['idmc']['q'] = 'AND idMenu=' . $param['idmc']['v'];
	$query_RSd = sprintf(
		'SELECT * FROM  dbMenuItem WHERE 1=1 %s ORDER BY parentMItem ASC, idMItem ASC, ordMItem ASC ' . $pages->limit,
		SSQL($param['idmc']['q'], '')
	);
	$RSd = mysqli_query($conn, $query_RSd) or die(mysqli_error($conn));
	$dRSd = mysqli_fetch_assoc($RSd);
	$TR = mysqli_num_rows($RSd);
}
$btnCont = ' <a href="index.php" class="btn btn-light"><i class="far fa-eye fa-lg"></i> Gestionar Contenedores</a> ';
$btnNew = ' <a href="formItems.php" class="btn btn-primary"><i class="fas fa-plus-square fa-lg"></i> Nuevo</a> ';
$btnTR = " <span class='btn btn-outline-secondary disabled'>{$cfg['t']['rows']} <strong>{$TRt}</strong></span> ";
?>

<?php echo genHeader($dM, 'header', null, $btnCont . $btnNew . $btnTR, null, 'mt-3 mb-3') ?>
<div class="card p-2 mb-3">
	<form class="row row-cols-sm-auto g-3 align-items-center">
		<div class="col-12">
			<span class="badge bg-light">Filtros</span>
		</div>
		<div class="col-12">
			<label for="exampleInputName2" class="">Menu Contenedor</label>
		</div>
		<div class="col-12">
			<?php echo $db->genSelect($db->detRowGSel('dbMenu', 'idMenu', 'nomMenu', 'status', '1'), 'idmc', $param['idmc'], 'form-select', null, null, '- Menu contenedor -', TRUE, null, '- Menu Contenedor -'); ?>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-light btn-sm"><?php echo $cfg['b']['filter'] ?></button>
		</div>
	</form>
</div>
<?php if ($TR > 0) { ?>
	<div class="table-responsive">
		<table class="table table-hover table-sm table-bordered" id="itm_table">
			<thead>
				<tr>
					<th>ID</th>
					<th></th>
					<th>MENU</th>
					<th>Padre</th>
					<th>Nombre</th>
					<th>Link</th>
					<th>Titulo</th>
					<th>Icon</th>
					<th>Orden</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php do {
					$id = $dRSd['idMItem'];
					$ids = md5($id);
					$detMC = detRow('dbMenu', 'idMenu', $dRSd['idMenu']);
					//if($det_parent_id==0) $css_tr='info'; else unset($css_tr);
					$detMP = detRow('dbMenuItem', 'idMItem', $dRSd['parentMItem']);
					$btnStat = genStatus('_acc.php', array("ids" => $ids, "val" => $dRSd['status'], "acc" => md5('STmi'), "url" => $urlc));
				?>
					<tr class="<?php echo $css_tr ?>">
						<td><?php echo $id ?></td>
						<td><?php echo $btnStat ?></td>
						<td><span class="label label-info"><?php echo $detMC['nomMenu'] ?></span></td>
						<td><?php echo $detMP['nomMItem'] ?? null ?></td>
						<td><?php echo $dRSd['nomMItem'] ?></td>
						<td><?php echo $dRSd['linkMItem'] ?></td>
						<td><?php echo $dRSd['titMItem'] ?></td>
						<td><i class="<?php echo $dRSd['iconMItem'] ?>"></i></td>
						<td><?php echo $dRSd['ordMItem'] ?></td>
						<td>
							<div class="btn-group">
								<a href="formItems.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-sm">
									<?php echo $cfg['i']['edit'] ?>
									<a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELmi') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-sm vAccL">
										<?php echo $cfg['i']['del'] ?>
						</td>
					</tr>
				<?php } while ($dRSd = mysqli_fetch_assoc($RSd)); ?>
			</tbody>
		</table>
	</div>
	<?php include(root['f'] . 'paginator.php') ?>
<?php } else { ?>
	<div class="alert alert-warning">
		<h4><?php echo $cfg['t']['list-null'] ?></h4>
	</div>
<?php } ?>