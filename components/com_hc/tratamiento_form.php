<?php require('../../init.php');
$_SESSION['tab']['con']='cTRA';
$idc=$_GET['idc'] ?? $_POST['idc'] ?? null;
$idt=$_GET['idt'] ?? $_POST['idt'] ?? null;
$action=$_GET['action'] ?? $_POST['action'] ?? null;
//Eliminar Tratamiento
if($action=='DELTF'){ header(sprintf("Location: %s", '_fncts.php?idt='.$idt.'&action=DELTF')); }
//FORM
$detTrat=detRow('db_tratamientos','tid',$idt);
if($detTrat){
	$action='UPD';
	$btntrat='<button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> ACTUALIZAR</button>';
	$idc=$detTrat['con_num'];
	$detCon=detRow('db_consultas','con_num',$idc);
	$detDiag_nom=$detTrat['diagnostico'];
	//LISTADO DE MEDICAMENTOS
	$query_RS_datos = sprintf('SELECT id_form AS sID, CONCAT(generico," ( ",comercial," ) "," : ",presentacion) as sVAL FROM db_medicamentos WHERE estado=1 OR generico IS NULL OR comercial IS NULL OR presentacion IS NULL');
	$RS_datos = mysqli_query(conn,$query_RS_datos) or die(mysqli_error(conn));

	$idtd=$_GET['idtd'] ?? $_POST['idtd'] ?? null;
	$detTD=detRow('db_tratamientos_detalle','id',$idtd);
	if($detTD){//Detalle Tratamiento
		$accTD='UPDD';
		$btnAccTD='<button class="btn btn-success btn-block" type="submit"><i class="fa fa-floppy-o"></i> Actualizar Medicamento</button>';
	}else{
		$accTD='INSD';
		$btnAccTD='<button class="btn btn-primary btn-block" type="submit"><i class="fa fa-floppy-o"></i> Agregar Medicamento</button>';
	}

}else{
	$action='INS';
	$btntrat='<button type="submit" class="btn btn-large btn-info"><i class="fa fa-floppy-o"></i> GUARDAR</button>';
	$detCon=detRow('db_consultas','con_num',$idc);
	$detDiag=detRow('db_diagnosticos','id_diag',$detCon['con_diagd']);
	$detDiag_nom=$detDiag['nombre'];
}
$detCon=detRow('db_consultas','con_num',$idc);
$idp=$detCon['pac_cod'];
$detPac=detRow('db_pacientes','pac_cod',$idp);//dataPac($idp);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
include(root['f'].'head.php'); ?>
<body class="cero">
<?php sLOG('g'); ?>
<form method="post" action="_fncts.php">
<fieldset>
    <input name="idt" type="hidden" id="idt" value="<?php echo $idt ?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
    <input name="action" type="hidden" id="action" value="<?php echo $action?>">
    <input name="form" type="hidden" id="form" value="tratdet">
</fieldset>
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-columns fa-lg"></i> TRATAMIENTO 
      <span class="label label-info"><?php echo $idt ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
	<ul class="nav navbar-nav">
		<li class="active"><a><?php echo $detPac_nom ?></a></li>
        <li><a>Consulta <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detTrat['fecha'] ?></a></li>
	</ul>
	<div class="navbar-right btn-group navbar-btn">
		<?php echo $btntrat?>
		<?php echo $btnaction ?>
        <?php if($idt){ ?>
		<a href="<?php echo route['c']; ?>com_hc/receta_print.php?idt=<?php echo $idt ?>" class="btn btn-info"><i class="fa fa-print"></i> Imprimir</a>
        <?php } ?>
		<a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>&action=NEW" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
		</li>
	</div>
	</div><!-- /.navbar-collapse -->
</nav>
<div class="container">
<div class="well well-sm">
	<fieldset class="form-inline">
	<label class="control-label">Fecha Receta</label>
	<input name="fecha" type="date" required class="form-control input-sm" id="fecha" value="<?php echo date('Y-m-d') ?>" autofocus>
    <label class="control-label">Diagnostico</label>
	<input name="diagnostico" type="text" class="form-control input-sm" id="diagnostico" placeholder="Diagnostico" value="<?php echo $detDiag_nom?>">
    <label class="control-label">Proxima Cita</label>
	<input name="fechap" type="date" class="form-control input-sm" id="fechap" value="<?php echo $detTrat['fechap'] ?>">
    <input name="obs" type="text" class="form-control input-sm" id="obs" value="<?php echo $detTrat['obs'] ?>">
    
    </fieldset>
</div>
</div>
</form>

<?php if($detTrat){?>


<div class="container">
<div class="row">
	<div class="col-sm-5">
    <fieldset class="well well-sm">
    <h4><i class="fa fa-plus-square"></i> Medicamentos Disponibles</h4>
    <?php generarselect('listMed',$RS_datos,$detCon['con_typ'],'form-control input-sm',''); ?>
    </fieldset>
    <form method="post" action="_fncts.php">
    <fieldset>
    <input name="trat_id" type="hidden" id="trat_id" value="<?php echo $idt ?>">
    <input name="idtd" type="hidden" id="idtd" value="<?php echo $idtd ?>">
	<input name="action" type="hidden" id="action" value="<?php echo $accTD ?>">
	<input name="form" type="hidden" id="form" value="tratdet">
	</fieldset>
    <fieldset class="well well-sm form-horizontal">
	<div class="form-group">
    	<label for="generico" class="col-sm-2 control-label">Medicamento</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-6"><input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detTD['generico'] ?>"></div>
			<div class="col-sm-6"><input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detTD['comercial'] ?>"></div>
		</div>
	</div>
	</div>
	<div class="form-group">
    	<label for="presentacion" class="col-sm-2 control-label">Información</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-8"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detTD['presentacion'] ?>"></div>
			<div class="col-sm-4"><input name="cantidad" type="number" class="form-control" id="cantidad" placeholder="Cantidad" value="<?php echo $detTD['cantidad'] ?>"></div>
		</div>
    </div>
	</div>
    <div class="form-group">
    	<label for="descripcion" class="col-sm-2 control-label">Prescripción</label>
    	<div class="col-sm-10">
    	<textarea name="descripcion" rows="4" class="form-control" id="descripcion"><?php echo $detTD['descripcion'] ?></textarea>
    	</div>
	</div>
    <div class="form-group">
    	<label for="" class="col-sm-2 control-label"></label>
    	<div class="col-sm-10">
    	<?php echo $btnAccTD; ?>
    	</div>
	</div>
	</fieldset>
    </form>
    </div>
	<div class="col-sm-7">
    <div class="well well-sm">
<?php
		$qrytl='SELECT * FROM db_tratamientos_detalle WHERE tid='.$idt.' ORDER BY id DESC';
		$RStl=mysqli_query(conn,$qrytl);
		$row_RStl=mysqli_fetch_assoc($RStl);
		$tr_RStl=mysqli_num_rows($RStl);
if($tr_RStl>0){
?>
<h4><i class="fa fa-columns fa-lg"></i> Receta Medica</h4>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<thead><tr>
	<th>Generico</th>
    <th>Comercial</th>
	<th>Pres</th>
    <th>Cantidad</th>
	<th>Prescripción</th>
    <th></th>
</tr></thead>
<tbody>
<?php do{ ?>
<tr>
	<td><?php echo $row_RStl['generico'] ?></td>
    <td><?php echo $row_RStl['comercial'] ?></td>
    <td><?php echo $row_RStl['presentacion'] ?></td>
    <td><?php echo $row_RStl['cantidad'] ?></td>
    <td><?php echo $row_RStl['descripcion'] ?></td>
    <td>
    <a href="tratamiento_form.php?idt=<?php echo $idt ?>&idtd=<?php echo $row_RStl['id'] ?>" class="btn btn-primary btn-xs">
    <i class="fa fa-edit"></i> Editar</a>
    <a href="_fncts.php?idt=<?php echo $idt ?>&idtd=<?php echo $row_RStl['id'] ?>&action=DELTD" class="btn btn-danger btn-xs">
    <i class="fa-solid fa-trash"></i> Quitar</a>
    </td>
</tr>
<?php }while ($row_RStl = mysqli_fetch_assoc($RStl));?>
</tbody>
</table>
</div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Medicamentos Registrados</h4></div>'; ?>
</div>
    
	</div>
</div>
</div>

<?php }?>

<?php if($detTrat){

?>
<script type="text/javascript">
$('#medicamento').focus();
$(document).ready(function(){
	$('#listMed').chosen();
	$('#listMed').on('change', function(evt, params) {
    doGetMedicamento(evt, params);
  });
});	
function doGetMedicamento(evt, params){
	var id=params.selected;	
	$.getJSON( "medicamento.php?term="+id, function( data ) {
		$.each( data, function( key, val ) {
			$("#id_form").val(val.id);
			$("#generico").val(val.generico);
			$("#comercial").val(val.comercial);
			$("#presentacion").val(val.presentacion);
			$("#cantidad").val(val.cantidad);
			$("#descripcion").val(val.descripcion);
  		});
	});
}
</script>
<?php }else{?>
<script type="text/javascript">$('#diagnostico').focus();</script>
<?php } ?>
</body>
</html>