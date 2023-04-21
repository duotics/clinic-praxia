<?php
$mTrat->setID($idsTrat);
$listadoTratamientos = $mTrat->listTratamientosDetalleForm();

if ($listadoTratamientos) { ?>
	<div class="card card-primary">
		<div class="card-header p-2">
			<i class="fa fa-columns fa-lg"></i> Detalles del tratamiento
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-striped tbl-qa table-list table-borderless mb-0">
				<thead>
					<tr class="table-info">
						<th class="table-header">Generico</th>
						<th class="table-header">Comercial</th>
						<th class="table-header">Pres</th>
						<th class="table-header">Dosis</th>
						<th class="table-header">#</th>
						<th class="table-header">Prescripción</th>
						<th class="table-header"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listadoTratamientos as $dRStl) { ?>
						<?php
						$btnAccRow = "<a class='btn btn-danger btn-sm'>{$cfg['i']['del']}</a>"
						?>
						<?php if ($dRStl['TIPO'] == "M") { ?>
							<tr>
								<td><?php echo $dRStl["GEN"] ?></td>
								<td><?php echo $dRStl["COM"] ?></td>
								<td><?php echo $dRStl["PRE"] ?></td>
								<td><?php echo $dRStl["CAN"] ?></td>
								<td><?php echo $dRStl["NUM"] ?></td>
								<td><?php echo $dRStl["DES"] ?></td>
								<td><?php echo $btnAccRow ?></td>
							</tr>
						<?php } ?>
						<?php if ($dRStl['TIPO'] == "I") { ?>
							<tr>
								<td colspan="6"><?php echo $dRStl["IND"] ?></td>
								<td><?php echo $btnAccRow ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php } else { ?>
	<div class="alert alert-warning">
		<h4>Sin Detalles Registrados</h4>
	</div>
<?php } ?>