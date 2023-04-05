<?php include('../../init.php');
$dM = $Auth->vLogin('COMPONENTE');

use App\Models\Componente;

$mCom = new Componente;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$mCom->setID($ids);
$mCom->det();
$det = $mCom->det;
if ($det) {
	$id = $det['mod_cod'];
	$acc = md5("UPD");
	$btnAcc = '<button type="submit" class="btn btn-success" id="vAcc"><span class="fa fa-hdd"></span> ACTUALIZAR</button>';
} else {
	$acc = md5("INS");
	$btnAcc = '<button type="submit" class="btn btn-primary" id="vAcc"><span class="fa fa-hdd"></span> GUARDAR</button>';
}
$btnNew = '<a href="' . $urlc . '" class="btn btn-default"><span class="fa fa-plus"></span> NUEVO</a>';
$css['body'] = 'cero';
include(root['f'] . 'head.php'); ?>
<div class="container">
	<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
		<fieldset>
			<input name="acc" type="hidden" value="<?php echo $acc ?>">
			<input name="form" type="hidden" value="form_mod">
			<input name="ids" type="hidden" value="<?php echo $ids ?>" />
			<input name="url" type="hidden" value="<?php echo $urlc ?>" />
		</fieldset>

		<?php echo genHeader($dM, 'navbar');
		$cont = '<span class="label label-primary">' . ($det['mod_cod'] ?? null) . '</span> ' . ($det['mod_nom'] ?? null) . '</span>';
		echo genHeader(null, 'page-header', $cont, $btnAcc . $btnNew)  ?>

		<?php sLOG('g'); ?>
		<div class="row">
			<div class="col-sm-7">
				<div class="well well-sm">
					<fieldset class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-4" for="mod_ref">Referencia</label>
							<div class="col-sm-8">
								<input name="mod_ref" type="text" id="mod_ref" placeholder="Referencia del módulo" value="<?php echo $det['mod_ref'] ?? null ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="mod_ref">Nombre / Titulo</label>
							<div class="col-sm-8">
								<input name="mod_nom" type="text" id="mod_nom" placeholder="Nombre del módulo" value="<?php echo $det['mod_nom'] ?? null ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="mod_des">Descripcion</label>
							<div class="col-sm-8">
								<input name="mod_des" type="text" id="mod_des" placeholder="Descripcion del módulo" value="<?php echo $det['mod_des'] ?? null ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="txtIcon">Icono</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input name="mod_icon" type="text" id="txtIcon" placeholder="Icono" value="<?php echo $det['mod_icon'] ?? null ?>" class="form-control">
									<div class="input-group-addon"><i class="<?php echo $det['mod_icon'] ?? null ?>" id="iconRes"></i></div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="mod_des">Status</label>
							<div class="col-sm-8">
								<p>
									<label>
										<input name="mod_stat" type="radio" id="mod_stat_0" value="1" checked="checked">
										Activo</label>
									<br>
									<label>
										<input type="radio" name="mod_stat" value="0" id="mod_stat_1">
										Inactivo</label>
									<br>
								</p>
							</div>
						</div>

					</fieldset>
				</div>
			</div>
			<div class="col-sm-5">
				<div class="panel panel-default">
					<div class="panel-heading">Menus Items Relacionados</div>
					<div class="panel-body">menus</div>
				</div>
			</div>

		</div>
	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var txtIcon = $("#txtIcon");
		txtIcon.on('keypress keyup focusout', function(evt, params) {
			iconClass(txtIcon.val());
		});
	});

	function iconClass(clase) {
		$("#iconRes").removeClass();
		$("#iconRes").addClass(clase);
	}
</script>
<?php include(root['f'] . 'footer.php'); ?>