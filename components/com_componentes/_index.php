<?php

use App\Models\Componente;

$mCom = new Componente;
$lCom = $mCom->getAll();
$btnNew = "<a data-type='iframe' href='form.php' class='btn btn-primary'>{$cfg['b']['new']}</a>";
$objHeader = new App\Core\genInterfaceTitle($dM, 'header', null, $btnNew);
?>
<div>
	<?php $objHeader->render() ?>
	<?php if ($lCom) { ?>
		<table class="datatable table table-hover table-sm table-bordered" id="itm_table">
			<thead>
				<tr>
					<th>ID</th>
					<th></th>
					<th>Ref</th>
					<th>Name</th>
					<th>Description</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lCom as $dCom) { ?>
					<?php
					$id = $dCom['idComp'];
					$ids = md5($id);
					$btnStat = genStatus('_acc.php', array("ids" => $ids, "val" => $dCom['status'], "acc" => md5('STc'), "url" => $urlc));
					?>
					<tr>
						<td><?php echo $id ?></td>
						<td><?php echo $btnStat ?></td>
						<td><?php echo $dCom['refComp'] ?></td>
						<td><?php echo $dCom['nomComp'] ?></td>
						<td><?php echo $dCom['desComp'] ?></td>
						<td>
							<div class="btn-group">
								<a href="form.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-sm" data-type="iframe">
									<?php echo cfg['b']['edit'] ?>
								</a>
								<a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELc') ?>&url=<?php echo $urlc ?>" class="vAccL btn btn-danger btn-sm">
									<?php echo cfg['i']['del'] ?>
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