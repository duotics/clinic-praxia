<?php

use App\Models\Examen;

$mExam = new Examen;

$lExamFormat = $mExam->getAllExamFormat();

?>
<div class="container">

	<div class="btn-group pull-right">
		<a href="examenFormatForm.php" class="btn btn-primary fancybox.iframe fancyreload"><span class="fa fa-plus fa-lg"></span> Nuevo</a>
	</div>

	<?php echo genHeader($dM, 'page-header') ?>

	<?php if ($lExamFormat) { ?>
		<div class="table-responsive">
			<table class="table table-hover table-bordered datatable" id="itm_table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Creado</th>
						<th></th>
						<th>Nombre</th>
						<th>Preview</th>
						<!--<th>Cantidad</th>-->
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lExamFormat as $dRSd) { ?>
						<?php $id = $dRSd['id'];
						$dA = dataAud($dRSd['idA']);
						if ($dA) {
							$date = date_create($dA['audd_datet']);
							$date = date_format($date, 'Y-m-d');
						} else $date = NULL;
						$btnStat = fncStat('actions.php', array("id" => $id, "val" => $dRSd['stat'], "acc" => md5('STef'), "url" => $urlc));
						$btnView = NULL;
						if ($dRSd['des']) $btnView = '<a href="examenFormatPreview.php?id=' . $id . '" class="btn btn-default btn-xs fancybox.iframe fancyreload"><i class="fa fa-eye"></i></a>';
						//$TRrow = totRowsTab('db_examenes', 'id_ef', $id);
						?>
						<tr>
							<td><?php echo $id ?></td>
							<td><?php echo $date ?></td>
							<td><?php echo $btnStat ?></td>
							<td><?php echo $dRSd['nom'] ?></td>
							<td><?php echo $btnView ?></td>
							<!--<td><?php //echo $TRrow ?></td>-->
							<td align="center">
								<div class="btn-group">
									<a href="examenFormatForm.php?id=<?php echo $id ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
										<i class="fa fa-edit fa-lg"></i> Editar</a>
									<a href="actions.php?id=<?php echo $id ?>&acc=<?php echo md5("DELef") ?>" class="btn btn-danger btn-xs fancybox.iframe fancyreload">
										<i class="fa fa-trash fa-lg"></i> Eliminar</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<div class="alert alert-warning">
			<h4>No se encontraron resultados !</h4>
		</div>
	<?php } ?>
</div>

</html>