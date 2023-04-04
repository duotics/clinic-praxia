<?php if ($dExamF) {
	$acc = md5('UPDef');
	$dateexam = $dExamF['fechae'] ?? null;
	$btnAcc = '<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR</button>';
} else {
	$acc = md5('INSef');
	$dateexam = $sdate;
	$btnAcc = '<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}

$idefd = $_GET['idefd'] ?? $_POST['idefd'] ?? null;
$dEFD = detRow('db_examenes_format_det', 'id', $idefd);
if ($dEFD) {
	$accD = md5('UPDefd');
	$btnAccD = '<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR</button>';
} else {
	$accD = md5('INSefd');
	$btnAccD = '<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}
if (isset($_SESSION['tab']['examf'])) {
	$tabS = $_SESSION['tab']['examf'];
	unset($_SESSION['tab']['examf']);
} else {
	$tabS['tabA'] = 'active';
}
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
			<a class="navbar-brand" href="#">EXAMEN FORMATO</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a><span class="label label-info"><?php echo $id ?></span></a></li>
			</ul>
			<div class="navbar-right btn-group navbar-btn">
				<a href="<?php echo $urlc ?>" class="btn btn-default"><i class="fa fa-plus"></i> NUEVO</a>
			</div>
		</div>
	</div>
</nav>
<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="<?php echo $tabS["tabA"] ?? null ?>"><a href="#tabA" aria-controls="home" role="tab" data-toggle="tab">Datos</a></li>
		<li role="presentation" class="<?php echo $tabS["tabB"] ?? null ?>"><a href="#tabB" aria-controls="profile" role="tab" data-toggle="tab">Tipos</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content panel panel-default panel-body">
		<div role="tabpanel" class="tab-pane <?php echo $tabS["tabA"] ?? null ?>" id="tabA">
			<form action="actions.php" method="post" id="formexam" enctype="multipart/form-data">
				<fieldset>
					<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
					<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
					<input name="form" type="hidden" id="form" value="<?php echo md5('fexamenf') ?>">
					<input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
				</fieldset>

				<fieldset class="form-horizontal">

					<div class="form-group">
						<div class="col-sm-10 col-md-offset-2">
							<?php echo $btnAcc ?>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="resultado">NOMBRE DEL GRUPO DE EXAMENES</label>
						<div class="col-sm-10">
							<input name="iNom" type="text" class="form-control" placeholder="Nombre del Formato" value="<?php echo $dExamF['nom'] ?>" autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2" for="resultado">Pre-Formato</label>
						<div class="col-sm-10">
							<textarea name="iDes" rows="50" class="form-control tmceExamE" style="height: 100px"><?php echo $dExamF['des'] ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="resultado">Pie</label>
						<div class="col-sm-10">
							<textarea name="iPie" rows="50" class="form-control tmceExamE" style="height: 100px"><?php echo $dExamF['pie'] ?></textarea>
						</div>
					</div>
				</fieldset>
			</form>

		</div>
		<div role="tabpanel" class="tab-pane <?php echo $tabS["tabB"] ?? null ?>" id="tabB">
			<form action="actions.php" method="post">
				<fieldset>
					<input type="hidden" name="form" value="<?php echo md5('fexamenfd') ?>">
					<input type="hidden" name="id" value="<?php echo $id ?>">
					<input type="hidden" name="idefd" value="<?php echo $idefd ?>">
					<input type="hidden" name="acc" value="<?php echo $accD ?>">
					<input type="hidden" name="url" id="url" value="<?php echo $urlc ?>">
				</fieldset>
				<?php
				$qLEFD = sprintf(
					'SELECT * FROM db_examenes_format_det WHERE idef=%s',
					SSQL($id, 'int')
				);
				$RSlefd = mysqli_query(conn, $qLEFD);
				$dRSlefd = mysqli_fetch_assoc($RSlefd);
				$tRSlefd = mysqli_num_rows($RSlefd);
				?>
				<div class="row">
					<div class="col-sm-5">
						<fieldset class="form-horizontal well">
							<div class="form-group">
								<label for="" class="control-label col-sm-4">NOMBRE DEL EXAMEN</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="iNom" value="<?php echo $dEFD["nom"] ?? null ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-sm-4">DESCRIPCION ADICIONAL DEL EXAMEN</label>
								<div class="col-sm-8">
									<textarea name="iVal" cols="30" rows="5" class="form-control"><?php echo $dEFD["val"] ?? null ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-sm-4">MARCADO</label>
								<div class="col-sm-8">
									<label class="radio-inline">
										<input type="radio" name="isCheck" value="1" <?php if (isset($dEFD["act"]) && $dEFD["act"] == 1) echo 'checked' ?>> SI
									</label>
									<label class="radio-inline">
										<input type="radio" name="isCheck" value="0" <?php if (isset($dEFD["act"]) && $dEFD["act"] == 0) echo 'checked' ?>> NO
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-sm-4">ESTADO</label>
								<div class="col-sm-8">
									<label class="radio-inline">
										<input type="radio" name="isAct" value="1" <?php if (isset($dEFD["est"]) && $dEFD["est"] == 1) echo 'checked' ?>> SI
									</label>
									<label class="radio-inline">
										<input type="radio" name="isAct" value="0" <?php if (isset($dEFD["est"]) && $dEFD["est"] == 0) echo 'checked' ?>> NO
									</label>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-8 col-md-offset-4">
									<?php echo $btnAccD ?>
									<a href="<?php echo $urlc ?>?id=<?php echo $id ?>" class="btn btn-default"><i class="fa fa-plus"></i>NUEVO</a>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-sm-7">
						<?php if ($tRSlefd > 0) { ?>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>ID</th>
										<th>NOMBRE</th>
										<th>MARCADO</th>
										<th>ACTIVO</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php do { ?>
										<?php
										$btnView = fncStat('actions.php', array("id" => $id, "idefd" => $dRSlefd["id"], "val" => $dRSlefd["act"], "acc" => md5('SELefd'), "url" => $urlc));
										$btnStat = fncStat('actions.php', array("id" => $id, "idefd" => $dRSlefd["id"], "val" => $dRSlefd["est"], "acc" => md5('STefd'), "url" => $urlc));
										?>
										<tr>
											<td><?php echo $dRSlefd["id"] ?></td>
											<td><?php echo $dRSlefd["nom"] ?></td>
											<td><?php echo $btnView ?></td>
											<td><?php echo $btnStat ?></td>
											<td>
												<a href="<?php echo $urlc ?>?id=<?php echo $id ?>&idefd=<?php echo $dRSlefd["id"] ?>" class="btn btn-primary btn-xs">
													<i class="fa fa-edit"></i></a>
												<a href="actions.php?id=<?php echo $id ?>&idefd=<?php echo $dRSlefd["id"] ?>&acc=<?php echo md5("DELefd") ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
													<i class="fa fa-trash"></i></a>
											</td>
										</tr>
									<?php } while ($dRSlefd = mysqli_fetch_assoc($RSlefd)); ?>
								</tbody>
							</table>
						<?php } else { ?>
							<div class="alert alert-info">
								<h4>No hay tipos de examen relacionados</h4>
							</div>
						<?php } ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>