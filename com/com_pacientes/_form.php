<?php

use App\Models\Paciente;
use App\Models\Signo;

$mPac = new Paciente;
$mSig = new Signo;

$id = $_GET['id'] ?? $_POST['id'] ?? null;
$idS = null;
if ($id) $idS = md5($id);
$mPac->setID($idS);
$mPac->detF();
$dPac = $mPac->det;
$dPacF = $mPac->detF;
if ($dPac) {
	$idp = $dPac['pac_cod'];
	$regBP = regBusPac($id);
	$acc = md5("UPDp");
	$dPacSig = $mSig->getLastSignPac($idS);

	$IMC = calcIMC($dPacSig['imc'] ?? null, $dPacSig['peso'] ?? null, $dPacSig['talla'] ?? null);
	$btnAcc = "<button type='button' class='btn btn-success' id='vAcc'>{$cfg['b']['upd']}</button>";
} else {
	$acc = md5("INSp");
	$btnAcc = "<button type='button' class='btn btn-info' id='vAcc'>{$cfg['b']['ins']}</button>";
}
$btnNew = "<a href='{$urlc}' class='btn btn-default'>{$cfg['b']['new']}</a>";
$btnClose = "<a href='index.php' class='btn btn-default'>{$cfg['b']['close']}</a>";
?>
<form enctype="multipart/form-data" method="post" action="_fncts.php" name="form_grabar" id="form_grabar" role="form">
	<fieldset>
		<input name="acc" type="hidden" value="<?php echo $acc; ?>" />
		<input name="mod" type="hidden" value="<?php echo $dM['mod_ref'] ?>" />
		<input name="id" type="hidden" value="<?php echo $id; ?>" />
		<input name="url" type="hidden" value="<?php echo $urlc ?>">
	</fieldset>
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><?php echo $dM['mod_nom'] ?>
				<span class="label label-primary"><?php echo $dPac['pac_cod'] ?? null ?></span></a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse-2">
			<ul class="nav navbar-nav">

				<li class="active"><a href="#"><?php echo $dPacF['dPac_fullname'] ?? null ?></a></li>
			</ul>
			<div class="navbar-right btn-group navbar-btn">
				<?php echo $btnAcc ?>
				<?php if ($id) { ?>
					<a href="<?php echo $RAIZc ?>com_consultas/form.php?idp=<?php echo $id ?>" class="btn btn-info"><i class="fa fa-eye"></i> VER CONSULTA</a>
				<?php } ?>
				<?php echo $btnNew ?>
				<?php echo $btnClose ?>
			</div>
		</div><!-- /.navbar-collapse -->
	</nav>
	<div class="row">
		<div class="col-md-5">
			<fieldset class="well well-sm">
				<div class="row">
					<div class="col-md-6"><input name="pac_ape" type="text" required class="form-control input-lg" id="pac_ape" value="<?php echo $dPac['pac_ape'] ?? null ?>" placeholder="Apellidos Completos" /></div>
					<div class="col-md-6"><input name="pac_nom" type="text" required class="form-control input-lg" id="pac_nom" value="<?php echo $dPac['pac_nom'] ?? null ?>" placeholder="Nombres Completos" /></div>
				</div>
			</fieldset>
			<div class="well well-sm">
				<div class="row">
					<div class="col-md-3 text-center">
						<?php if ($dPac) { ?>
							<a href="<?php echo $dPacF['dPac_img']['n'] ?>" class="fancybox"><img class="img-thumbnail img-responsive" src="<?php echo $dPacF['dPac_img']['t'] ?>"></a><br>
							<a href="pacImg/pacImg.php?idp=<?php echo $id ?>" class="btn btn-default btn-xs btn-block fancybox fancybox.iframe fancyreload"><i class="fa fa-camera fa-lg"></i> Cargar</a>
						<?php } else { ?>
							<a class="btn btn-default disabled"><i class="fa fa-picture-o fa-3x"></i><br>Foto</a>
						<?php } ?>
					</div>
					<div class="col-md-9">
						<fieldset class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-3 control-label">Registrado</label>
								<div class="col-sm-9"><input name="pac_reg" type="text" class="form-control input-sm" value="<?php echo $dPac['pac_reg'] ?? null ?>" disabled></div>
							</div>
							<div class="form-group">
								<label for="pac_ced" class="col-sm-3 control-label">Identificacion</label>
								<div class="col-sm-9"><input name="pac_ced" type="text" class="form-control" id="pac_ced" value="<?php echo $dPac['pac_ced'] ?? null ?>" placeholder="Cedula / RUC / Pasaporte"></div>
							</div>
							<div class="form-group">
								<label for="pac_fec" class="col-sm-3 control-label">Nacimiento</label>
								<div class="col-sm-6"><input name="pac_fec" id="pac_fec" value="<?php echo $dPac['pac_fec']; ?>" type="date" class="form-control" placeholder="Fecha" onKeyUp="setDB(this.name,this.value,<?php echo $id ?>,'pac')" onChange="getDataVal(null,this.value,'FechaToEdad','viewEdad')" /></div>
								<div class="col-sm-3"><span class="small" id="viewEdad"><?php echo edadC($dPac['pac_fec'] ?? null); ?></span></div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
			<fieldset class="form-horizontal well well-sm">

				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_tipsan">Tipo Sangre</label>
					<div class="col-md-8">
						<?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPSAN'), 'pac_tipsan', $dPac['pac_tipsan'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$idS'") ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_estciv">Estado Civil</label>
					<div class="col-md-8">
						<?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'ESTCIV'), 'pac_estciv', $dPac['pac_estciv'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$idS'") ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_sexo">Género</label>
					<div class="col-md-8">
						<?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'SEXO'), 'pac_sexo', $dPac['pac_sexo'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$idS'") ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="pac_sexo">Raza</label>
					<div class="col-md-8">
						<?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'RAZA'), 'pac_raza', $dPac['pac_raza'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$idS'") ?>
					</div>
				</div>
			</fieldset>
			<div class="well well-sm">
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 col-md-3 control-label" for="">Signos</label>
						<div class="col-md-10">
							<div class="row">
								<div class="col-xs-3"><input placeholder="PESO kg" name="" type="text" value="<?php echo $dPacSig['peso'] ?? null ?>" class="form-control" disabled />
									<col-md- class="help-block">Peso en KG.</col-md->
								</div>
								<div class="col-xs-3"><input placeholder="TALLA cm" type="text" value="<?php echo $dPacSig['talla'] ?? null ?>" class="form-control" disabled />
									<col-md- class="help-block">Talla cm.</col-md->
								</div>
								<div class="col-xs-3"><input placeholder="IMC" type="text" value="<?php echo $IMC['val'] ?? null ?>" class="form-control" disabled />
									<col-md- class="help-block">IMC.</col-md->
								</div>
								<div class="col-xs-3"><input placeholder="Presion Arterial" type="text" value="<?php echo ($dPacSig['paS'] ?? null) ?? null . '/' . ($dPacSig['paD'] ?? null) ?>" class="form-control" disabled />
									<col-md- class="help-block">Presion Arterial</col-md->
								</div>
							</div>

						</div>
					</div>
				</fieldset>
				<div><?php if ($dPac) { ?>
						<a href="<?php echo $RAIZc ?>com_signos/gestSig.php?ids=<?php echo md5($id) ?>" class="btn btn-success btn-block fancybox fancybox.iframe fancyreload">
							<i class="fa fa-bars fa-lg"></i> Registrar</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-sm-7">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#datos" role="tab" data-toggle="tab">Datos</a></li>
				<?php if ($dPac) { ?>
					<li><a href="#historial" role="tab" data-toggle="tab">Historia Clinica</a></li>
					<li><a href="#ginecologia" role="tab" data-toggle="tab">Registro Ginecologico</a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="datos">
					<?php include('_formDatos.php') ?>
				</div>
				<div class="tab-pane fade" id="historial">
					<?php include(RAIZc . 'com_hc/historia_det.php') ?>
				</div>
				<div class="tab-pane fade" id="ginecologia">
					<?php include(RAIZc . 'com_hc/ginecologia_det.php') ?>
				</div>
			</div>
		</div>
	</div>
</form>