<?php

use App\Models\Tratamiento;

$mTrat = new Tratamiento();

$lTratAnt = $mTrat->listadoTratamientosAnteriores($idp);
?>

<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-columns fa-lg"></i> RECETAS
		<a href="<?php echo "{$RAIZc}com_tratamientos/tratamientoForm.php?idp=$idp&idc=$idc&acc=" . md5("NEWt") ?>" class="btn btn-default fancybox.iframe fancyreload">
			<?php echo $cfg['i']['new'] ?> NUEVA RECETA
		</a>
	</div>
	<div class="panel-body">
		<?php if ($lTratAnt) { ?>
			<table class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Fecha</th>
						<th style="width:50%">Detalle Tratamiento</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($lTratAnt as $dRSt) { ?>
						<?php
						$listTratAntDetMed = $mTrat->listTratamientosDetalle($dRSt['tid'], 'M');
						$listTratAntDetInd = $mTrat->listTratamientosDetalle($dRSt['tid'], 'I');
						?>
						<tr>
							<td><?php echo $dRSt['tid'] ?></td>
							<td><?php echo $dRSt['fecha'] ?></td>
							<td>
								<div class="row">
									<div class="col-sm-6">
										<?php if ($listTratAntDetMed) { ?>
											<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
												<thead>
													<tr>
														<th width="90%">Medicamento</th>
														<th width="10%">Cantidad</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($listTratAntDetMed as  $dRStl) { ?>
														<tr>
															<td><?php echo "{$dRStl['generico']} ({$dRStl['comercial']})" ?></td>
															<td><?php echo $dRStl['numero'] ?></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										<?php } else echo '<div>No hay Medicamentos Prescritos</div>' ?>
									</div>
									<div class="col-sm-6">
										<?php if ($listTratAntDetInd) { ?>
											<table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
												<thead>
													<tr>
														<th>Instrucciones</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($listTratAntDetInd as $dRStli) { ?>
														<tr>
															<td><?php echo $dRStli['indicacion'] ?></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										<?php } else echo '<div>No hay Indicaciones</div>' ?>
									</div>
								</div>
							</td>
							<td>
								<div class="btn-group">
									<a href="<?php echo "{$RAIZc}com_tratamientos/tratamientoForm.php?idt={$dRSt['tid']}" ?>" class=" btn btn-primary fancybox fancybox.iframe fancyreload">
										<?php echo $cfg['b']['edit'] ?>
									</a>
									<a class="printerButton btn btn-default" data-id="<?php echo $dRSt['tid'] ?>" data-rel="<?php echo $RAIZc ?>com_tratamientos/recetaPrintJS.php">
										<?php echo $cfg['b']['print'] ?>
									</a>
									<a href="<?php echo "{$RAIZc}com_tratamientos/tratamientoForm.php?idt={$dRSt['tid']}&acc=" . md5("DELtf") ?>" class="btn btn-danger fancybox fancybox.iframe">
										<?php echo $cfg['i']['del'] ?>
									</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>'; ?>
	</div>
	<div class="panel-footer">Resultados. <?php echo count($lTratAnt ?? 0) ?></div>
</div>