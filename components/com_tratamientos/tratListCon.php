<?php

use App\Models\Tratamiento;

$mTrat = new Tratamiento();
$mTrat->setIDp($idsPac);
$lTratAnt = $mTrat->listadoTratamientosAnteriores();
$cont = "<i class='fa fa-columns fa-lg'></i> RECETAS";
$accBtn = md5("NEWt");
$btnNew = "<a href='{$route['c']}com_tratamientos/tratamientoForm.php?idp={$idsPac}&idc={$idsCon}&acc={$accBtn}' class='btn btn-sm btn-light'>{$cfg['i']['new']} NUEVA RECETA</a>";
$objTit = new App\Core\genInterfaceTitle(null, "card", $cont, $btnNew, null, null, "h4");
?>

<div>
	<?php $objTit->render() ?>
	<div>
		<?php if ($lTratAnt) { ?>
			<table class="table table-striped table-bordered table-sm">
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
						$mTrat->setID(md5($dRSt['idTrat']));
						$listTratAntDet = $mTrat->listTratamientosDetalleAll();
						//dep($listTratAntDet);
						?>
						<tr>
							<td><?php echo $dRSt['idTrat'] ?></td>
							<td><?php echo $dRSt['fecha'] ?></td>
							<td>
								<div class="row">
									<div class="col-sm-6">
										<?php if ($listTratAntDet) { ?>
											<table class="table table-bordered table-sm table-list mb-0" style="font-size:0.8em;">
												<thead>
													<tr>
														<th width="90%">Medicamento</th>
														<th width="10%">Cantidad</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($listTratAntDet as $dRStl) { ?>
														<?php if (($dRStl['tipo'] != "M") || (empty($dRStl['nombre']))) continue; ?>
														<tr>
															<td><?php echo $dRStl['nombre'] ?></td>
															<td><?php echo $dRStl['can'] ?></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										<?php } else echo '<div>No hay Medicamentos Prescritos</div>' ?>
									</div>
									<div class="col-sm-6">
										<?php if ($listTratAntDet) { ?>
											<table class="table table-bordered table-sm table-list mb-0" style="font-size:0.8em;">
												<thead>
													<tr>
														<th>Instrucciones</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($listTratAntDet as $dRStli) { ?>
														<?php if (($dRStli['tipo'] != "I") || (is_null($dRStli['nombre']))) continue; ?>
														<tr>
															<td><?php echo $dRStli['nombre'] ?? null ?></td>
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
									<a href="<?php echo route['c'] . "com_tratamientos/tratamientoForm.php?idt={$dRSt['idTrat']}" ?>" class=" btn btn-primary fancybox fancybox.iframe fancyreload">
										<?php echo $cfg['b']['edit'] ?>
									</a>
									<a class="printerButton btn btn-default" data-id="<?php echo $dRSt['idTrat'] ?>" data-rel="<?php echo route['c'] . "com_tratamientos/recetaPrintJS.php" ?>">
										<?php echo $cfg['b']['print'] ?>
									</a>
									<a href=" <?php echo route['c'] . "com_tratamientos/tratamientoForm.php?idt={$dRSt['idTrat']}&acc=" . md5("DELtf") ?>" class="btn btn-danger fancybox fancybox.iframe">
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