<?php

use App\Models\Tipo;

$mType = new Tipo;

$param = null;
$rTyp = $_REQUEST['ref'] ?? null;
$lType = $mType->getAllRef($rTyp);
$TRt = $mType->getTRmain();
$TR = ($lType) ? count($lType) : 0;
$btnNew = "<a href='form.php' data-fancybox='form' data-width='800' class='btn btn-primary' data-type='iframe'>{$cfg['b']['new']}</a>";
$btnTR = "<span class='btn btn-dark disabled'>{$cfg['t']['rows']} <strong>{$TRt}</strong></span>";
//echo genHeader($dM, 'header', null, $btnTR . $btnNew) 
?>
<?php sLOG('t'); ?>
<div class="card p-2 mb-2">
	<form class="row row-cols-lg-auto g-3 align-items-center">
		<div class="col-12">
			<span class="badge bg-light"><?php echo $cfg['t']['filters'] ?></span>
		</div>
		<div class="col-12">
			<label class="mr-2">Referencia</label>
		</div>
		<div class="col-12">
			<?php echo $db->genSelect($db->detRowGSel('dbTypes', 'refType', 'DISTINCT (refType)', '1', '1'), 'idType', $rTyp, 'form-select form-select-sm', 'required', NULL, 'Seleccione', TRUE, NULL, 'Todos') ?>
		</div>
	</form>
</div>
<?php if ($TR > 0) { ?>
	<table class="datatable table table-bordered table-striped table-sm" id="itm_table">
		<thead>
			<tr>
				<th>ID</th>
				<th></th>
				<th>Ref</th>
				<th>Nombre</th>
				<th>Valor</th>
				<th>Módulo</th>
				<th>Aux</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lType as $dType) {
				$idRow = $dType['idType'];
				$idsRow = md5($idRow);
				$btnStat = genStatus('_acc.php', array('ids' => $idRow, 'val' => $dType['status'], 'acc' => md5('STt'), 'ref' => $rTyp, "url" => $urlc));
			?>
				<tr>
					<td><?php echo $idRow ?></td>
					<td><?php echo $btnStat ?></td>
					<td><?php echo $dType['refType'] ?></td>
					<td><?php echo $dType['nomType'] ?></td>
					<td><?php echo $dType['valType'] ?></td>
					<td><?php echo $dType['idComp'] ?></td>
					<td><?php echo $dType['auxType'] ?></td>
					<td>
						<div class="btn-group">
							<a data-fancybox="form" data-width="800" href="form.php?id=<?php echo $idRow ?>" class="btn btn-info btn-sm" data-type="iframe">
								<?php echo $cfg['i']['edit'] ?>
							</a>
							<a href="_acc.php?id=<?php echo $idRow ?>&acc=<?php echo md5('DELt') ?>&url=<?php echo $urlc . $uTyp ?>" class="btn btn-danger btn-sm">
								<?php echo $cfg['i']['trash'] ?>
							</a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else { ?>
	<div class="alert alert-warning">
		<h4><?php echo $cfg['t']['list-null'] ?></h4>
	</div>
<?php } ?>
</div>
<script type="text/javascript">
	$("#idType").change(function() {
		window.location.href = "?ref=" + $("#idType").val();
	});
</script>