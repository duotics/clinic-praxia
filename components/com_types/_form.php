<?php 
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$ref=$_GET['ref'] ?? $_POST['ref'] ?? null;
$det=detRow('db_types','typ_cod',$id);
if($det){
	$acc=md5("UPDt");
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc"><span class="fa fa-floppy-o fa-lg"></span> ACTUALIZAR</button>';
	$detRef=$det['typ_ref'];
	$btnNewR='<a href="'.$urlc.'?ref='.$detRef.'" class="btn btn-default"><span class="fa fa-plus"></span> NUEVO SIMILAR</a>';
}else{
	$acc=md5("INSt");
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc"><span class="fa fa-floppy-o fa-lg"></span> GUARDAR</button>';
	$detRef=$ref;
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default"><span class="fa fa-plus"></span> NUEVO</a>';
?>
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="<?php echo md5('formType') ?>">
<input name="id" type="hidden" value="<?php echo $id ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>

<div class="page-header"><span class="label label-default pull-left">TIPOS DEL SISTEMA</span>
    <h1><span class="label label-info"><?php echo $id ?></span> 
	<?php echo $dNom ?? null ?>
    <div class="btn-group pull-right">
		<?php echo $btnAcc ?>
        <?php echo $btnNew ?>
        <?php echo $btnNewR ?? null ?>
	</div>
    </h1></div>
<?php sLOG('g'); ?>
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="col-sm-4 control-label" for="iMod">Módulo</label>
			<div class="col-sm-8">
		  <input name="iMod" type="text" id="iMod" placeholder="Módulo" value="<?php echo $det['mod_ref'] ?? null ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="iNom">Nombre</label>
			<div class="col-sm-8">
		  <input name="iNom" type="text" id="iNom" placeholder="Nombre del tipo" value="<?php echo $det['typ_nom'] ?? null ?>" class="form-control" required></div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="iRef">Referencia</label>
			<div class="col-sm-8">
		  <input name="iRef" type="text" id="iRef" placeholder="Referencia del módulo" value="<?php echo $detRef ?? null ?>" class="form-control input-lg" required></div>
		</div>
        <div class="form-group">
			<label class="col-sm-4 control-label" for="iVal">Valor</label>
			<div class="col-sm-8">
		  <input name="iVal" type="text" id="iVal" placeholder="Valor del tipo" value="<?php echo $det['typ_val'] ?? null ?>" class="form-control input-lg" required></div>
		</div>
       	<div class="form-group">
			<label class="col-sm-4 control-label" for="iVal">Auxiliar</label>
			<div class="col-sm-8">
		  <input name="iAux" type="text" id="iAux" placeholder="Valor auxiliar" value="<?php echo $det['typ_aux'] ?? null ?>" class="form-control input-lg"></div>
		</div>
        <div class="form-group">
			<label class="col-sm-4 control-label" for="iIcon">Icono</label>
			<div class="col-sm-8">
		  <input name="iIcon" type="text" id="iIcon" placeholder="Icono" value="<?php echo $det['typ_icon'] ?? null ?>" class="form-control" ></div>
		</div>
                          
	</fieldset>
</div>
</form>