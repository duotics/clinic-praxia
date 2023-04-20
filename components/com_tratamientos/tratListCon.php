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
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr>
							<th>ID</th>
							<th>Fecha</th>
							<th>Detalle Tratamiento</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($lTratAnt as $dRSt) { ?>
							<?php
							$idsTratRow = md5($dRSt['idTrat']);
							$mTrat->setID($idsTratRow);
							$listTratAntDet = $mTrat->listTratamientosDetalleAll();

							?>
							<tr>
								<td><?php echo $dRSt['idTrat'] ?></td>
								<td><?php echo formatFecha($dRSt['date']) ?></td>
								<td>
									<div class="row">
										<div class="col-sm-12 col-md-6">
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
											<?php } else echo '<div>Medicamento</div>' ?>
										</div>
										<div class="col-sm-12 col-md-6">
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
											<?php } else echo '<div>Indicación</div>' ?>
										</div>
									</div>
								</td>
								<td>
									<div class="btn-group">
										<a href="<?php echo route['c'] . "com_tratamientos/tratamientoForm.php?kt={$idsTratRow}" ?>" class=" btn btn-primary btn-sm" data-fancybox="form" data-type="iframe">
											<span class="d-block d-md-none">
												<?php echo $cfg['i']['edit'] ?>
											</span>
											<span class="d-none d-md-block">
												<?php echo $cfg['b']['edit'] ?>
											</span>
										</a>
										<a class="printerButton btn btn-light btn-sm" data-id="<?php echo $idsTratRow ?>" data-rel="<?php echo route['c'] . "com_tratamientos/recetaPrintJS.php" ?>">
											<span class="d-block d-md-none">
												<?php echo $cfg['i']['print'] ?>
											</span>
											<span class="d-none d-md-block">
												<?php echo $cfg['b']['print'] ?>
											</span>
										</a>
										<a href=" <?php echo route['c'] . "com_tratamientos/tratamientoForm.php?idt={$idsTratRow}&acc=" . md5("DELtf") ?>" class="btn btn-danger btn-sm fancybox fancybox.iframe">
											<?php echo $cfg['i']['del'] ?>
										</a>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } else { ?>
			<div class="alert alert-warning">
				<h4>Sin Registros</h4>
			</div>
		<?php } ?>
	</div>
	<div class="panel-footer">Resultados. <?php echo count($lTratAnt ?? 0) ?></div>
</div>