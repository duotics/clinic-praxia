<?php

use App\Models\Paciente;

$mPac = new Paciente;
$sbr = $_GET['sBr'] ?? $_POST['sBr'] ?? null;
$mPac->setTerm($sbr);
$mPac->getPacList();
?>
<?php if ($sbr) { ?>
	<div class="alert alert-info alert-dismissable" id="log">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		Mostrando Su Busqueda: <strong>"<?php echo $sbr ?>"</strong>
	</div>
<?php } ?>
<?php if ($mPac->TRp) { ?>
	<?php
	$objPaginator = new App\Core\genInterfacePaginator($mPac->TR, $mPac->pages->display_pages(), $mPac->pages->display_items_per_page());
	$objPaginator->showInterface()
	?>
	<table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
		<thead>
			<tr>
				<th></th>
				<th><abbr title="Historia Clinica">H.C.</abbr></th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>Edad</th>
				<th>Detalle</th>
				<th>Contacto</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($dRSp = $mPac->RSp->fetch()) { ?>
				<?php
				$idp = $dRSp['pac_cod'];
				$dPac = detRow('db_pacientes', 'pac_cod', $idp);
				$typ_tsan = dTyp($dPac['pac_tipsan']);
				$typ_tsan = $typ_tsan['typ_val'] ?? null;
				$typ_eciv = dTyp($dPac['pac_estciv']);
				$typ_eciv = $typ_eciv['typ_val'] ?? null;
				$typ_sexo = dTyp($dPac['pac_sexo']);
				$typ_sexo = $typ_sexo['typ_val'] ?? null;
				if ($typ_sexo == 'Masculino') $classsexo = ' label-info';
				if ($typ_sexo == 'Femenino') $classsexo = ' label-women';
				?>
				<tr>
					<td>
						<?php if ($dM['mod_ref'] == "PAC") { ?>
							<a href="form.php?id=<?php echo $idp ?>" title="Modificar Paciente" class="btn btn-primary btn-xs">
								<i class="fa fa-user"></i> Ficha</a>
						<?php } ?>
						<?php if ($dM['mod_ref'] == "CON") { ?>
							<a href="<?php echo route['c'] ?>com_consultas/form.php?idp=<?php echo $idp ?>" class="btn btn-primary btn-xs">
								<i class="fa fa-stethoscope fa-lg"></i> Consulta</a>
							<a href="<?php echo route['c'] ?>com_calendar/reserva_form.php?idp=<?php echo $idp ?>" class="btn btn-default btn-xs fancybox.iframe fancyreload">
								<i class="fa fa-calendar-o"></i> Reserva</a>
						<?php } ?>
						<?php if ($dM['mod_ref'] == "REPH") { ?>
							<a href="hcpD.php?id=<?php echo $idp ?>" title="Modificar Paciente" class="btn btn-primary btn-xs">
								<i class="fas fa-database"></i> Reporte</a>
						<?php } ?>


					</td>
					<td><?php echo $idp ?></td>
					<td><?php echo strtoupper($dRSp['pac_nom']) ?></td>
					<td><?php echo strtoupper($dRSp['pac_ape']) ?></td>

					<td><?php echo edad($dRSp['pac_fec']) ?></td>
					<td>
						<?php //echo "***".$typ_sexo 
						?>
						<small>
							<?php
							if ($typ_sexo) echo '<span class="label ' . $classsexo . '">' . $typ_sexo . '</span> ';
							if ($typ_eciv) echo '<span class="badge">' . $typ_eciv . '</span> ';
							if ($typ_tsan) echo '<span class="badge">' . $typ_tsan . '</span> ';
							?>
						</small>
					</td>
					<td><?php
						if ($dPac['pac_lugr']) echo '<abbr title="' . $dPac['pac_lugr'] . '"><i class="fa fa-globe"></i></abbr> ';
						if ($dPac['pac_tel1']) echo '<abbr title="' . $dPac['pac_tel1'] . '"><i class="fa fa-phone"></i></abbr> ';
						if ($dPac['pac_tel2']) echo '<abbr title="' . $dPac['pac_tel2'] . '"><i class="fa fa-phone"></i></abbr> ';
						if ($dPac['pac_email']) echo '<abbr title="' . $dPac['pac_email'] . '"><i class="fa fa-envelope"></i></abbr> ';
						?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php $objPaginator->showInterface() ?>
<?php } ?>