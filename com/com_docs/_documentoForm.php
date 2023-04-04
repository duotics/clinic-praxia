<?php
$dD = detRow('db_documentos', 'id_doc', $idd); //fnc_datadoc($idd);
$dF = detRow('db_documentos_formato', 'id_df', $iddf);
if ($idd) {
	$idp = $dD['pac_cod'];
	$idc = $dD['con_num'];
}
$dPac = detRow('db_pacientes', 'pac_cod', $idp);
$dCon = detRow('db_consultas', 'con_num', $idc);
if ($dD) {
	$acc = md5('UPDd');
	if ($iddf) {
		$dD_nom = $dF['nombre'];
		$doc_con = $dF['formato'];
	} else {
		$dD_nom = $dD['nombre'];
		$doc_con = $dD['contenido'];
	}
	$btnAcc = '<button id="vAcc" type="submit" class="btn btn-success navbar-btn" name="btnA"><i class="fas fa-save fa-lg"></i> ACTUALIZAR</button>';
	$btnAccP = '<button type="submit" class="btn btn-primary navbar-btn" name="btnP"><i class="fas fa-save fa-lg"></i> ACTUALIZAR E IMPRIMIR</button>';
} else {
	$acc = md5('INSd');
	$dD_nom = $dF['nombre'];
	$doc_con = $dF['formato'];

	$dat['pac'] = $dPac;
	$dat['con'] = $dCon;

	$doc_conG = genDoc($iddf, $dat);
	$doc_con = $doc_conG['format'];
	$btnAcc = '<button id="vAcc" type="submit" class="btn btn-info navbar-btn" name="btnA"><i class="fas fa-save fa-lg"></i> GUARDAR</button>';
	$btnAccP = '<button type="submit" class="btn btn-primary navbar-btn" name="btnP"><i class="fas fa-save fa-lg"></i> GUARDAR E IMPRIMIR</button>';
}
$NE = new EnLetras();
$NumD = $NE->ValorEnLetras((int)date('d'), '');
$NumA = $NE->ValorEnLetras((int)date('Y'), '');
//echo (int)(date('d'));
//echo date('Y');
?>
<form action="_acc.php" method="post" enctype="multipart/form-data">
	<fieldset>
		<input name="idd" type="hidden" id="idd" value="<?php echo $idd ?>">
		<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
		<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
		<input name="iddf" type="hidden" id="iddf" value="<?php echo $iddf ?>">
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
		<input name="form" type="hidden" id="form" value="<?php echo md5('fDocs') ?>">
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>

	<?php
	$cont = '<span class="badge badge-primary">' . $idd . '</span>
	<span class="badge badge-info">Consulta</span>
	<span class="badge badge-info">' . $idc . '</span>
	<span class="badge badge-light">' . $dPac['pac_nom'] . ' ' . $dPac['pac_ape'] . '</span>
    <span class="badge badge-light">' . ($dD['fecha'] ?? null) . '</span>';
	echo genHeader($dM, 'page-header', $cont, $btnAcc . $btnAccP, null, 'mb-3') ?>
	<div class="">
		<div class="row">
			<div class="col-sm-8">
				<fieldset>
					<?php $doc_con2 = str_replace('{RAIZ}', $RAIZ, $doc_con) ?>
					<textarea name="contenido" style="min-height: 575px" class="tinymce" id="contenido" placeholder="Resultados"><?php echo $doc_con2 ?></textarea>
				</fieldset>
			</div>
			<div class="col-sm-4">
				<div class="card p-2 mb-3">
					<fieldset class="form-horizontal">
						<div class="form-group row mb-0">
							<label for="fecha" class="col-form-label col-sm-3">Fecha Creación</label>
							<div class="col-sm-9"><span class="badge badge-light"><?php echo $dD['fecha'] ?? null ?></span></div>
						</div>
						<div class="form-group row mb-0">
							<label for="nombre" class="col-form-label col-sm-3">Nombre</label>
							<div class="col-sm-9"><input name="nombre" type="text" class="form-control form-control-sm" id="nombre" placeholder="Descripcion" value="<?php echo $dD_nom ?>"></div>
						</div>
					</fieldset>
				</div>
				<div class="card card-primary mb-3">
					<h4 class="card-header">Dias de Reposo</h4>
					<div class="card-body">
						<fieldset class="form-horizontal">
							<div class="form-group row">
								<label for="" class="col-form-label col-sm-3">Inicio del Reposo</label>
								<div class="col-sm-9">
									<input type="date" class="form-control" id="dpFec" value="<?php echo $sdate ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-form-label col-sm-3">Dias de Reposo</label>
								<div class="col-sm-9">
									<input type="number" class="form-control input-lg" id="dpDia" value="1">
								</div>
							</div>

							<span id="genReposo" class="btn btn-info btn-sm btn-block">Generar Dias Reposo</span>

						</fieldset>
					</div>
				</div>
				<div class="card p-2 text-center">
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Fechas / Horas <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo strftime("%A %d de %B del %Y") ?>');return false;">
									<i class="icon-calendar icon-white"></i> <?php echo strftime("%A %d de %B del %Y") ?></a></li>
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo strftime("a los " . $NumD . " dias del mes de %B de " . $NumA . "") ?>');return false;">
									<i class="icon-calendar icon-white"></i> Fecha en letras</a></li>
							<li class="divider"></li>
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo date("h:i:s") ?>');return false;">
									<i class="icon-calendar icon-white"></i> Hora /12</a></li>
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo date("H:i:s") ?>');return false;">
									<i class="icon-calendar icon-white"></i> Hora /24</a></li>
						</ul>
					</div>
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Paciente <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac_nom ?>');return false;">Nombre Paciente</a></li>
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detpac['pac_ced'] ?>');return false;">Cedula</a></li>
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo edad($detpac['pac_fec']) ?>');return false;">Edad</a></li>
						</ul>
					</div>
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Datos Consulta <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<!--<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('<?php echo $detDD_nom ?>');return false;">Diagnostico Definitivo</a></li>
            <li class="divider"></li>-->
							<li><a href="javascript:;" onClick="tinymce.activeEditor.insertContent('Ricardo Ordoñez V.');return false;">Ricardo Ordoñez V.</a></li>
						</ul>
					</div>
				</div>
				<div class="well well-sm text-center">
					<div class="btn-group">
						<a class="btn dropdown-toggle btn-primary btn-sm" data-toggle="dropdown" href="#">Cambiar a <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php
							//
							$qrydf = 'SELECT * FROM  db_documentos_formato ORDER BY nombre ASC';
							$RSdf = mysqli_query($conn, $qrydf);
							$row_RSdf = mysqli_fetch_assoc($RSdf);
							$tr_RSdf = mysqli_num_rows($RSdf);
							//
							?>
							<?php do { ?>
								<li><a href="<?php echo $RAIZc ?>com_docs/documentoForm.php?idd=<?php echo $idd ?>&iddf=<?php echo $row_RSdf['id_df'] ?>&idp=<?php echo $idp ?>&idc=<?php echo $idc ?>&action=NEW"><i class="icon-file"></i> <small>Cambiar a</small> <?php echo $row_RSdf['nombre'] ?></a></li>
							<?php } while ($row_RSdf = mysqli_fetch_assoc($RSdf)); ?>

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$.ajaxSetup({
			async: false
		});

		$('#genReposo').click(function() {
			var dias = $('#dpDia').val();
			$.ajax({
				url: 'json.getDate.v4.php',
				type: 'POST',
				data: {
					dias
				},
				success: function(response) {
					tinymce.activeEditor.insertContent(response);
				}
			});
		});

	});
</script>