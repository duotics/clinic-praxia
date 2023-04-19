<div class="card card-primary">
	<?php
	$mTrat->setID($idsTrat);
	$listadoTratamientos = $mTrat->listTratamientosDetalleForm();

	if ($listadoTratamientos) {
	?>
		<h4 class="card-header">
			<i class="fa fa-columns fa-lg"></i> Receta Médica
		</h4>
		<div class="table-responsive">
			<table class="table table-bordered table-striped tbl-qa">
				<thead>
					<tr>
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
						<?php if ($dRStl['TIPO'] == "M") { ?>
							<tr>
								<td><?php echo $dRStl["GEN"] ?></td>
								<td><?php echo $dRStl["COM"] ?></td>
								<td><?php echo $dRStl["PRE"] ?></td>
								<td><?php echo $dRStl["CAN"] ?></td>
								<td><?php echo $dRStl["NUM"] ?></td>
								<td><?php echo $dRStl["DES"] ?></td>
							</tr>
						<?php } ?>
						<?php if ($dRStl['TIPO'] == "I") { ?>
							<tr>
								<td colspan="6"></td><?php echo $dRStl["IND"] ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } else echo '<div class="alert alert-warning"><h4>Sin Medicamentos Registrados</h4></div>'; ?>
</div>