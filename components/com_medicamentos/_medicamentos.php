<?php

use App\Models\Medicamento;

$mMed = new Medicamento();
$lMed = $mMed->getAllLab();
$TR = count($lMed ?? []);

$btnNew = "<a href='medicamentosForm.php' class='btn btn-primary'>{$cfg['b']['new']}</a>";
$btnTR = "<span class='btn btn-primary disabled'>{$cfg['t']['rows']}<strong>$TR</strong></span>"
?>
<?php echo genHeader($dM, 'page-header', null, $btnTR . $btnNew) ?>
<div>
	<?php if ($lMed) { ?>
		<table class="table table-striped table-bordered table-condensed datatable">
			<colgroup>
				<col width="10%">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="">
				<col width="5%">
				<col width="10%">
			</colgroup>
			<thead>
				<tr>
					<th>Laboratorio</th>
					<th>Generico</th>
					<th>Comercial</th>
					<th>Presentacion</th>
					<th>Cantidad</th>
					<th style="width:35%">Prescripción</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lMed as $dMed) { ?>
					<?php
					$idsRow = $dMed['ID'];
					$btnStat = genStatus('_acc.php', array('ids' => $idsRow, 'val' => $dMed['STATUS'], 'acc' => md5("STm"), "url" => $urlc));
					$btnEdit = "<a href='medicamentosForm.php?ids=$idsRow' class='btn btn-info btn-xs'>{$cfg['b']['edit']}</a>";
					$btnDel = "<a href='_acc.php?ids=$idsRow&acc=" . md5('DELm') . "&url=$urlc' class='btn btn-danger btn-xs vAccL' data-title='Eliminar Medicamento'>{$cfg['i']['del']}</a>";
					?>
					<tr>
						<td><?php echo $dMed['LAB'] ?></td>
						<td><?php echo $dMed['GEN'] ?></td>
						<td><?php echo $dMed['COM'] ?></td>
						<td><?php echo $dMed['PRES'] ?></td>
						<td><?php echo $dMed['CANT'] ?></td>
						<td><?php echo $dMed['PRESCRIP'] ?></td>
						<td><?php echo $btnStat ?></td>
						<td>
							<div class="btn-group">
								<?php echo $btnEdit ?>
								<?php echo $btnDel ?>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } else {
		echo "<div class='alert alert-danger'>{$cfg['t']['list-null']}</div>";
	} ?>
</div>