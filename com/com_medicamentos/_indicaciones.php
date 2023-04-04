<?php

use App\Models\Indicacion;

$mInd = new Indicacion;
$lInd = $mInd->getAll();
$TR = count($lInd);
$btnNew = "<a href='indicacionesForm.php' class='btn btn-primary'>{$cfg['b']['new']}</a>";
$btnTR = "<span class='btn btn-default disabled'>{$cfg['t']['rows']}<strong>$TR</strong></span>" ?>
<?php echo 	genHeader($dM, 'page-header', null, $btnTR . $btnNew); ?>
<div>
	<?php if ($lInd) { ?>
		<table class="table table-striped table-bordered table-condensed datatable">
			<colgroup>
				<col width="5%"><!--ID-->
				<col><!--DES-->
				<col width="5%"><!--EST-->
				<col width="5%"><!--DES-->
				<col width="10%"><!--ACC-->
			</colgroup>
			<thead>
				<tr>
					<th>ID</th>
					<th>Descripción</th>
					<th>Estado</th>
					<th>Destacado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lInd as $dInd) { ?>
					<?php
					$idRow = $dInd["id"];
					$idsRow = md5($dInd["id"]);
					$btnStat = genStatus('_acc.php', array('ids' => $idsRow, 'val' => $dInd["est"], 'acc' => md5("STi"), "url" => $urlc));
					$btnFeat = genStatus('_acc.php', array('ids' => $idsRow, 'val' => $dInd["feat"], 'acc' => md5("FTi"), "url" => $urlc));
					$btnEdit = "<a href='indicacionesForm.php?ids=$idsRow' class='btn btn-success btn-xs'>{$cfg['b']['edit']}</a>";
					$btnDel = "<a href='_acc.php?ids=$idsRow&acc=" . md5('DELi') . "&url=$urlc' class='btn btn-danger btn-xs'>{$cfg['i']['del']}</a>";
					?>
					<tr id=<?php echo $idRow ?>>
						<td><?php echo $idRow ?></td>
						<td><?php echo $dInd['des'] ?></td>
						<td><?php echo $btnStat ?></td>
						<td><?php echo $btnFeat ?></td>
						<td>
							<div class="btn-group">
								<?php echo $btnEdit ?>
								<?php echo $btnDel ?>
							</div>
						</td>
						</td>
					<?php } ?>
			</tbody>
		</table>
	<?php } else {
		echo "<div class='alert alert-danger'>{$cfg['t']['list-null']}</div>";
	} ?>
</div>