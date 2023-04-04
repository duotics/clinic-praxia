<?php

use App\Models\Laboratorio;

$mInd = new Laboratorio;
$lInd = $mInd->getAll();
$TR = count($lInd);
$btnNew = "<a href='laboratorioForm.php' class='btn btn-primary'>{$cfg['b']['new']}</a>";
$btnTR = "<span class='btn btn-default disabled'>{$cfg['t']['rows']}<strong>$TR</strong></span>" ?>
<?php echo 	genHeader($dM, 'page-header', null, $btnTR . $btnNew); ?>
<div>
	<?php if ($lInd) { ?>
		<table class="table table-striped table-bordered table-condensed datatable">
			<colgroup>
				<col width="5%"><!--ID-->
				<col><!--DES-->
				<col width="5%"><!--EST-->
				<col width="10%"><!--ACC-->
			</colgroup>
			<thead>
				<tr>
					<th>ID</th>
					<th>Laboratorio</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lInd as $dRow) { ?>
					<?php
					$idRow = $dRow["idLab"];
					$idsRow = md5($dRow["idLab"]);
					$btnStat = genStatus('_acc.php', array('ids' => $idsRow, 'val' => $dRow["status"], 'acc' => md5("STl"), "url" => $urlc));
					$btnEdit = "<a href='laboratorioForm.php?ids=$idsRow' class='btn btn-success btn-xs'>{$cfg['b']['edit']}</a>";
					$btnDel = "<a href='_acc.php?ids=$idsRow&acc=" . md5('DELl') . "&url=$urlc' class='btn btn-danger btn-xs'>{$cfg['i']['del']}</a>";
					?>
					<tr id=<?php echo $idRow ?>>
						<td><?php echo $idRow ?></td>
						<td><?php echo $dRow['nomLab'] ?></td>
						<td><?php echo $btnStat ?></td>
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