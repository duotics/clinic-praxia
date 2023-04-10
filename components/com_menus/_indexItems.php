<?php

use App\Models\Menu;

$mMenuI = new Menu();
$idMenu = $_REQUEST['idmc'] ?? null;
$lMenuI = $mMenuI->listaItemsCont($idMenu);
$TRt = $mMenuI->getTRsecTable();
$selMenu = $mMenuI->selectMenuContenedores('idmc', $idMenu);
$cMenuI = count($lMenuI);

$btnCont = " <a href='index.php' class='btn btn-light'>{$cfg['i']['view']} Gestionar Contenedores</a> ";
$btnNew = " <a href='formItems.php' class='btn btn-primary'>{$cfg['t']['rows']}</a> ";
$btnTR = " <span class='btn btn-outline-secondary'>{$cfg['t']['rows']} <strong>{$TRt}</strong></span> ";

$objTit = new App\Core\genInterfaceTitle($dM, 'header', null, $btnCont . $btnNew . $btnTR, null, 'mt-3 mb-3');
?>

<?php $objTit->render() ?>
<div class="card p-2 mb-3">
	<form class="row row-cols-sm-auto g-3 align-items-center">
		<div class="col-12">
			<span class="badge bg-light">Filtros</span>
		</div>
		<div class="col-12">
			<label for="exampleInputName2" class="">Menu Contenedor</label>
		</div>
		<div class="col-12">
			<?php echo $selMenu ?>
		</div>
		<div class="col-12">
			<button type="submit" class="btn btn-outline-primary btn-sm"><?php echo $cfg['b']['filter'] ?></button>
			<a href="<?php echo $urlc ?>" class="btn btn-outline-light btn-sm"><?php echo $cfg['b']['del-filter'] ?></a>
		</div>
	</form>
</div>
<?php if ($cMenuI > 0) { ?>
	<div class="table-responsive">
		<table class="table table-hover table-sm table-bordered datatable" id="itm_table">
			<thead>
				<tr>
					<th></th>
					<th>MENU</th>
					<th>Padre</th>
					<th>Ref</th>
					<th>Nombre</th>
					<th>Link</th>
					<th>Titulo</th>
					<th>Icon</th>
					<th>Orden</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lMenuI as $dRSd) {
					$ids = md5($dRSd['id']);
					$btnStat = genStatus('_acc.php', array("ids" => $ids, "val" => $dRSd['status'], "acc" => md5('STmi'), "url" => $urlc));
				?>
					<tr>
						<td><?php echo $btnStat ?></td>
						<td><span class="label label-info"><?php echo $dRSd['nomCont'] ?></span></td>
						<td><?php echo $dRSd['nomPadre'] ?? null ?></td>
						<td><?php echo $dRSd['ref'] ?></td>
						<td><?php echo $dRSd['nom'] ?></td>
						<td><?php echo $dRSd['link'] ?></td>
						<td><?php echo $dRSd['tit'] ?></td>
						<td><i class="<?php echo $dRSd['icon'] ?>"></i></td>
						<td><?php echo $dRSd['ord'] ?></td>
						<td>
							<div class="btn-group">
								<a href="formItems.php?ids=<?php echo $ids ?>" class="btn btn-primary btn-sm">
									<?php echo $cfg['i']['edit'] ?>
									<a href="_acc.php?ids=<?php echo $ids ?>&acc=<?php echo md5('DELmi') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-sm vAccL">
										<?php echo $cfg['i']['del'] ?>
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