<?php require_once('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$idh = $_GET['idh'] ?? $_POST['idh'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$detPac = dataPac($id);
$dSig = detRow('db_signos', 'id', $idh);
if ($detPac['pac_fec']) $detPac_fec = edad($detPac['pac_fec']) . ' Años';
$det = $_POST;
if (($acc) && ($acc == 'DEL')) {
	$LOG = NULL;
	$qryDEL = sprintf(
		'DELETE FROM `db_signos` WHERE id=%s',
		SSQL($idh, 'int')
	);
	if (@mysqli_query(conn, $qryDEL)) $LOG .= $cfg['p']['del-true'];
	else $LOG .= $cfg['p']['del-false'] . mysqli_error(conn);
}
if (($det['form']) && ($det['form'] == 'hispac')) {
	switch ($acc) {
		case 'INSs';
			$qryI = sprintf(
				"INSERT INTO db_signos (pac_cod,fecha,peso,pa,talla,imc,temp,fc,fr,po2,co2) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				SSQL($id, "int"),
				SSQL($sdate, "date"),
				SSQL($det['hpeso'], "text"),
				SSQL($det['hpa'], "text"),
				SSQL($det['htalla'], "text"),
				SSQL($det['himc'], "text"),
				SSQL($det['htemp'], "text"),
				SSQL($det['hfc'], "text"),
				SSQL($det['hfr'], "text"),
				SSQL($det['hpo2'], "text"),
				SSQL($det['hco2'], "text")
			);
			if (@mysqli_query(conn, $qryI)) $LOG .= $cfg['p']['ins-true'];
			else $LOG .= $cfg['p']['ins-false'];
			break;
		case 'UPDs';
			$qryU = sprintf(
				"UPDATE db_signos SET 
			peso=%s, pa=%s, talla=%s , imc=%s, temp=%s, fc=%s, fr=%s, po2=%s, co2=%s
			WHERE id=%s",
				SSQL($det['hpeso'], "text"),
				SSQL($det['hpa'], "text"),
				SSQL($det['htalla'], "text"),
				SSQL($det['himc'], "text"),
				SSQL($det['htemp'], "text"),
				SSQL($det['hfc'], "text"),
				SSQL($det['hfr'], "text"),
				SSQL($det['hpo2'], "text"),
				SSQL($det['hco2'], "text"),
				SSQL($idh, "int")
			);
			if (@mysqli_query(conn, $qryU)) $LOG .= $cfg['p']['upd-true'];
			else $LOG .= $cfg['p']['upd-false'];
			break;
	}
}
if ($dSig) {
	$acc = 'UPDs';
	$btnAcc = '<button type="submit" class="btn btn-success btn-block"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
} else {
	$acc = 'INSs';
	$btnAcc = '<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}
$btnNew = '<a href="gest_hist.php?id=' . $id . '" class="btn btn-default btn-block"><i class="fa fa-plus"></i> NUEVO</a>';

$_SESSION['LOG']['m'] = $LOG;
$css['body'] = 'cero';
include(root['f'] . 'head.php');
?>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">SIGNOS VITALES</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#"><?php echo $detPac['pac_nom'] . ' ' . $detPac['pac_ape'] ?></a></li>
				<li><a><?php echo $detPac_fec ?></a></li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<?php if ($detPac) {
	$qry = sprintf(
		'SELECT * FROM db_signos WHERE pac_cod=%s ORDER BY id DESC',
		SSQL($id, 'int')
	);
	$RSh = mysqli_query(conn, $qry);
	$dRSh = mysqli_fetch_assoc($RSh);
	$tr_RSh = mysqli_num_rows($RSh);
?>
	<?php sLOG('g') ?>
	<div class="container-fluid">
		<form method="post" action="<?php echo $urlcurrent; ?>">
			<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
			<input name="form" type="hidden" id="form" value="hispac">
			<input name="acc" type="hidden" value="<?php echo $acc ?>">
			<div class="row">
				<div class="col-md-10">
					<fieldset class="form-inline well well-sm">
						<div class="form-group">
							<span class="help-block"><small>Peso en Kilogramos</small></span>
							<input name="hpeso" type="number" step="any" class="form-control input-sm" placeholder="Peso en Kg." value="<?php echo $dSig[peso] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Talla en centimetros</small></span>
							<input name="htalla" type="number" step="any" class="form-control input-sm" placeholder="Talla en cm." value="<?php echo $dSig[talla] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Índice de Masa Corporal</small></span>
							<input name="himc" type="number" step="any" class="form-control input-sm" placeholder="Indice de Masa Corporal" value="<?php echo $dSig[imc] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Temperatura</small></span>
							<input name="htemp" type="text" class="form-control input-sm" placeholder="0,00" value="<?php echo $dSig[temp] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Presión Arterial</small></span>
							<input name="hpa" type="text" class="form-control input-sm" placeholder="Presion Arterial" value="<?php echo $dSig[pa] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Frecuencia Cardiaca</small></span>
							<input name="hfc" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[fc] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Frecuencia Respiratoria</small></span>
							<input name="hfr" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[fr] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>Saturación de Oxigeno</small></span>
							<input name="hpo2" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[po2] ?>">
						</div>
						<div class="form-group">
							<span class="help-block"><small>CO2</small></span>
							<input name="hco2" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig[co2] ?>">
						</div>
					</fieldset>
				</div>
				<div class="col-md-2"><?php echo $btnAcc ?><?php echo $btnNew ?></div>
			</div>
		</form>
		<?php if ($tr_RSh > 0) { ?>
			<div>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Fecha</th>
							<th>Peso</th>
							<th>Talla</th>
							<th>IMC</th>
							<th>Temp.</th>
							<th>P.A.</th>
							<th>F.C.</th>
							<th>F.R.</th>
							<th>PO2</th>
							<th>CO2</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php do {
							$pesoKG = $dRSh['peso'] . ' Kg.';
							$pesoLB = round($dRSh['peso'] * 2.20462262, 2);
							$pesoLB .= ' Lb.';
							$tallaCM;
							$tallaPL;
							if ($dRSh['talla']) {
								$tallaCM = $dRSh['talla'] . ' Cm';
								$tallaPL = round($dRSh['talla'] / 2.54, 2);
								$tallaPL .= ' "';
								$tallaM = $tallaCM / 100;
							}

							$IMC = $dRSh['imc'];
							$IMC = calcIMC($IMC, $pesoKG, $tallaCM);
						?>
							<tr>
								<td><?php echo $dRSh['id'] ?></td>
								<td><?php echo $dRSh['fecha'] ?></td>
								<td><?php echo $pesoKG . ' / ' . $pesoLB ?></td>
								<td><?php echo $tallaCM ?></td>
								<td><?php echo $IMC['val'] . ' ' . $IMC['inf']; ?></td>
								<td><?php echo $dRSh['temp'] ?></td>
								<td><?php echo $dRSh['pa'] ?></td>
								<td><?php echo $dRSh['fc'] ?></td>
								<td><?php echo $dRSh['fr'] ?></td>
								<td><?php echo $dRSh['po2'] ?></td>
								<td><?php echo $dRSh['co2'] ?></td>
								<td><a href="<?php echo $urlc; ?>?id=<?php echo $id ?>&idh=<?php echo $dRSh['id'] ?>" class="btn btn-info btn-xs">
										<i class="fa fa-edit"></i> Editar</a>
									<a href="<?php echo $urlc; ?>?id=<?php echo $id ?>&idh=<?php echo $dRSh['id'] ?>&acc=DEL" class="btn btn-danger btn-xs">
										<i class="fa-solid fa-trash"></i> Eliminar</a>
								</td>
							</tr>
						<?php } while ($dRSh = mysqli_fetch_assoc($RSh));
						$rows = mysqli_num_rows($RSh);
						if ($rows > 0) {
							mysqli_data_seek($RSh, 0);
							$dRSh = mysqli_fetch_assoc($RSh);
						} ?>
					</tbody>
				</table>
			</div>
		<?php } else {
			echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
		} ?>
	</div>
<?php mysqli_free_result($RSh);
} else { ?>
	<div class="alert alert-warning">
		<h4>Paciente No Existe</h4>
	</div>
<?php } ?>
<?php include(root['f'] . 'foot.php') ?>