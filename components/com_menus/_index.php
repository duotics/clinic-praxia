<?php

use App\Core\genInterfaceHeader;
use App\Models\Menu;

$mMenu = new Menu();
$lMenu = $mMenu->getAllMenu();
$cMenu = count($lMenu);
$btnItems = ' <a href="indexItems.php" class="btn btn-secondary"><i class="far fa-eye"></i> Gestionar Items</a> ';
$btnNew = " <a href='form.php' class='btn btn-primary' data-type='iframe'>{$cfg['b']['new']}</a> ";
$btnTR = " <span class='btn btn-outline-secondary disabled'>{$cfg['t']['rows']} <strong>{$cMenu}</strong></span> ";
$objHead=new genInterfaceHeader($dM, 'card', null, $btnItems . $btnNew . $btnTR, null, 'mt-3 mb-3');
?>
<div>
	<?php $objHead->showInterface() ?>
	<?php if ($cMenu > 0) { ?>
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered datatable">
				<thead>
					<tr>
						<th>ID</th>
						<th></th>
						<th>Nombre</th>
						<th>Ref</th>
						<th>Items</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lMenu as $dRSm) {
						$id = $dRSm['idMenu'];
						$ids = md5($id);
						$btnStat = genStatus('_acc.php', array("ids" => $ids, "val" => $dRSm['status'], "acc" => md5('STmc'), "url" => $urlc));
						$totI = $db->totRowsTab('dbMenuItem', 'idMenu', $id);
					?>
						<tr>
							<td><?php echo $id ?></td>
							<td><?php echo $btnStat ?></td>
							<td><?php echo $dRSm['nomMenu'] ?></td>
							<td><?php echo $dRSm['refMenu'] ?></td>
							<td><?php echo $totI ?></td>
							<td>
								<div class="btn-group">
									<a href="form.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-sm">
										<?php echo $cfg['b']['edit'] ?>
									</a>
									<?php if (!($totI)) { ?>
										<a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELmc') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-sm vAccL">
											<i class="fas fa-trash fa-lg"></i>
										</a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<div class="alert alert-warning">
			<h4><?php echo $cfg['t']['list-null'] ?></h4>
		</div>
	<?php } ?>
</div>