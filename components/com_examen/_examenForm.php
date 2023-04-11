<?php
$dExa = detRow('db_examenes', 'id_exa', $ide); //fnc_dataexam($ide);
if ($ide) {
	$idp = $dExa['pac_cod'];
	$idc = $dExa['con_num'];
}
$dPac = detRow('db_pacientes', 'pac_cod', $idp);
if ($dExa) {
	$acc = md5('UPDe');
	$dExa_fec = $dExa['fechae'];
	$dEF = detRow('db_examenes_format', 'id', $dExa['id_ef']);
	$idef = $dEF["id"];
	$btnAcc = '<button type="button" id="vAcc" name="btnA" class="btn btn-success" id=""><i class="fa fa-refresh fa-lg"></i> GUARDAR</button>';
	$btnAccJS = '<button type="submit" name="btnJ" class="btn btn-default" id=""><i class="fa fa-close fa-lg"></i> GUARDAR & CERRAR</button>';
	//$btnPrint='<button type="submit" name="btnP" class="btn btn-info" id=""><i class="fa fa-refresh fa-lg"></i> GUARDAR & IMPRIMIR</button>';
	$RSe = detRowGSel('db_examenes_format', 'id', 'nom', '1', '1');
} else {
	$dExa_fec = date('Y-m-d');
	$acc = md5('INSe');
	$btnAcc = '<button type="button" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
	$RSe = detRowGSel('db_examenes_format', 'id', 'nom', 'stat', '1');
}
?>
<form action="_fncts.php" method="post" id="formexam" enctype="multipart/form-data" class="cero">
	<fieldset>
		<input name="ide" type="hidden" value="<?php echo $ide ?>">
		<input name="idp" type="hidden" value="<?php echo $idp ?>">
		<input name="idc" type="hidden" value="<?php echo $idc ?>">
		<input name="idef" type="hidden" value="<?php echo $idef ?>">
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="form" type="hidden" value="<?php echo md5("fExam") ?>">
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>
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
				<a class="navbar-brand" href="#">EXAMEN</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a><span class="label label-info"><?php echo $ide ?></span></a></li>
					<li><a><?php echo $dPac['pac_nom'] . ' ' . $dPac['pac_ape'] ?></a></li>
					<li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
					<li><a><?php echo $dExa['fecha'] ?></a></li>
					<li><a>
							<div id="logF"></div>
						</a></li>
				</ul>
				<div class="navbar-right btn-group navbar-btn">
					<?php echo $btnAcc ?? null ?>
					<?php echo $btnPrint ?? null ?>
					<?php echo $btnAccJS ?? null ?>
				</div>
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#tabA" aria-controls="tabA" role="tab" data-toggle="tab">DATOS</a></li>
				<li role="presentation"><a href="#tabB" aria-controls="tabB" role="tab" data-toggle="tab">MULTIMEDIA</a></li>
				<li role="presentation"><a href="#tabC" aria-controls="tabC" role="tab" data-toggle="tab">OTROS</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="tabA">
					<div class="row">
						<div class="col-sm-3">
							<fieldset class="form-horizontal well well-sm">
								<div class="form-group">
									<label class="control-label col-sm-3" for="resultado">Fecha</label>
									<div class="col-sm-9">
										<input name="fechae" type="date" id="fechae" value="<?php echo $dExa_fec; ?>" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="resultado">Formato</label>
									<div class="col-sm-9">
										<input type="text" class="form-control disabled" value="<?php echo $dEF["nom"] ?>" disabled>
										<?php //genSelect('idef', $RSe, $dExa['id_ef'], 'form-control', NULL, 'idEf', NULL, TRUE, NULL, "- Seleccione Formato -")
										?>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-sm-3" for="obs">Observaciones</label>
									<div class="col-sm-9">
										<input name="obs" type="text" class="form-control" id="obs" placeholder="Observaciones" value="<?php echo $dExa['obs'] ?>" autofocus>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-3" for="resultado">Resultados</label>
									<div class="col-sm-9">
										<textarea name="resultado" rows="8" class="form-control" id="resultado" placeholder="Resultados"><?php echo $dExa['resultado'] ?></textarea>
									</div>
								</div>
							</fieldset>
						</div>
						<?php
						$qryLTEF = sprintf(
							'SELECT * FROM db_examenes_format_det WHERE idef=%s',
							SSQL($idef, 'int')
						);
						$RSltef = mysqli_query(conn, $qryLTEF);
						$dRSltef = mysqli_fetch_assoc($RSltef);
						$tRSltef = mysqli_num_rows($RSltef);
						if ($tRSltef > 0) {
							$spanE["a"] = 4;
							$spanE["b"] = 5;
						} else {
							$spanE["a"] = 2;
							$spanE["b"] = 7;
						}
						?>
						<div class="col-sm-<?php echo $spanE["a"] ?>">
							<?php if ($tRSltef > 0) { ?>
								<table class="table table-condensed">
									<tr>
										<th>Sel</th>
										<th>Resultado</th>
									</tr>
									<?php do { ?>
										<?php
										$paramsN = NULL;
										$paramsN[] = array(
											array("cond" => "AND", "field" => "idefd", "comp" => "=", "val" => $dRSltef["id"]),
											array("cond" => "AND", "field" => "ide", "comp" => '=', "val" => $ide)
										);
										$dEFDS = detRowNP('db_examenes_det',null, $paramsN);
										$checkSel = NULL;
										//$enabRes='disabled';
										if ($dEFDS) {
											$checkSel = 'checked';
											//$enabRes=NULL;
											//$valED='ED-'.$dEFDS[id];
										} //else{ $valED='EF-'.$dRSltef[id]; }
										?>
										<tr>
											<td>
												<div class="checkbox cero">
													<label>
														<input type="checkbox" name="lefs[<?php echo $dRSltef["id"] ?>]" value="<?php echo $dRSltef["id"] ?>" <?php echo $checkSel ?>>
														<?php echo $dRSltef['nom'] ?>
													</label>
												</div>
											</td>
											<td>
												<input type="text" class="form-control input-sm" name="lefsR[<?php echo $dRSltef["id"] ?>]" data-id="<?php echo $dEFDS['id'] ?>" value="<?php echo $dEFDS['res'] ?? null ?>" <?php echo $enabRes ?? null ?> style="height: 25px" />
											</td>
										</tr>
									<?php } while ($dRSltef = mysqli_fetch_assoc($RSltef)); ?>
								</table>
							<?php } else { ?>
								<div><span class="label label-default">No Existen sub-examenes</span></div>
							<?php } ?>
						</div>
						<div class="col-sm-<?php echo $spanE["b"] ?>">
							<div class="form-group">
								<textarea name="iDes" class="form-control tmceExamE" id="iDes" placeholder="Detalle" style="height: 200px"><?php echo $dExa['des'] ?></textarea>
							</div>
							<!--
				<div class="form-group">
					<textarea name="iPie" class="form-control" id="pieExa" placeholder="iPie"><?php echo $dExa['pie'] ?></textarea>
				</div>
				-->
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="tabB">
					<div class="well well-sm">
						<?php if ($dExa) {
							$qryfc = sprintf(
								'SELECT * FROM db_examenes_media WHERE id_exa=%s ORDER BY id DESC',
								SSQL($ide, 'int')
							);
							$RSfc = mysqli_query(conn, $qryfc);
							$row_RSfc = mysqli_fetch_assoc($RSfc);
							$tr_RSfc = mysqli_num_rows($RSfc);
						?>
							<div class="well well-sm" style="background:#FFF">

								<textarea name="dfile" rows="2" class="form-control" id="dfile" placeholder="Descripcion de la Imagen"></textarea>
								<input name="efile[]" id="efile" type="file" onChange="uploadImage();" class="form-control" accept="image/gif, image/jpeg, image/png, image/bmp" multiple />
							</div>
							<?php if ($tr_RSfc > 0) { ?>



								<div class="row">
									<?php do { ?>
										<?php $detMedia = detRow('db_media', 'id_med', $row_RSfc['id_med']);
										$detMedia_file = $RAIZ . 'data/db/exam/' . $detMedia['file'];
										?>

										<div class="col-sm-4">
											<div class="thumbnail">
												<img src="<?php echo $detMedia_file ?>" alt="<?php echo $detMedia['des'] ?>" class="img-md">
												<div class="caption text-center">
													<span class="label label-default"><?php echo $detMedia['des'] ?></span>
													<div>
														<a href="<?php echo $detMedia_file ?>" class="btn btn-primary btn-xs fancybox" rel="gall">
															<i class="fa fa-eye"></i> Ver</a>
														<a href="_fncts.php?ide=<?php echo $ide ?>&id=<?php echo $row_RSfc['id'] ?>&acc=delEimg" class="btn btn-danger btn-xs">
															<i class="fa-solid fa-trash"></i> Eliminar</a>
													</div>
												</div>
											</div>
										</div>

									<?php } while ($row_RSfc = mysqli_fetch_assoc($RSfc)); ?>
								</div>

							<?php } else echo '<div class="alert alert-warning">No han guardado archivos de este Examen</div>'; ?>

						<?php } else echo '<div class="alert alert-warning"><h4>No se puede cargar archivos</h4>Aun No Se ha Guardado el Examen</div>'; ?>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="tabC">...</div>
			</div>

		</div>

	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#idEf').chosen();
		$('#idEf').on('change', function(evt, params) {
			doGetEF(evt, params);
		});
		$('.setDB_old').keyup(function() {
			var campo = $(this).attr("name");
			var valor = $(this).val();
			var cod = $(this).attr("data-id");
			var tbl = $(this).attr("data-rel");
			setDB(campo, valor, cod, tbl);
		});
	});

	function setDB_old(campo, valor, cod, tbl) {
		$.get(RAIZc + "com_comun/actionsJS.php", {
			campo: campo,
			valor: valor,
			cod: cod,
			tbl: tbl
		}, function(data) {
			showLoading();
			$("#logF").show(100).text(data.inf).delay(3000).hide(200);
			hideLoading();
		}, "json");
	}

	function doGetEF(evt, params) {
		var url = RAIZs + 'fnc/getRow.php';
		var id = params.selected;
		$.getJSON(url, {
				tab: "db_examenes_format",
				field: "id",
				param: id
			})
			.done(function(json) {
				tinymce.activeEditor.setContent('');
				tinymce.activeEditor.insertContent(json.rVal.des);
				return false;
			})
			.fail(function(jqxhr, textStatus, error) {
				var err = textStatus + ", " + error;
				alert("Request Failed: " + err);
			});
	}

	function uploadImage() {
		formexam.submit();
	}
</script>