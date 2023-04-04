<?php
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['action'] ?? $_POST['action'] ?? null;
$det=detRow('tbl_menus','id',$id);
if ($det){ 
	$acc="UPD";
	$btnAcc='<button type="submit" class="btn btn-success" id="vAcc">'.$cfg['btn']['updI'].$cfg['btn']['updT'].'</button>';
}else {
	$acc="INS";
	$btnAcc='<button type="submit" class="btn btn-primary" id="vAcc">'.$cfg['btn']['insI'].$cfg['btn']['insT'].'</button>';
}
$btnNew='<a href="'.$urlc.'" class="btn btn-default">'.$cfg['btn']['newI'].$cfg['btn']['newT'].'</a>';
?>

<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="form_men">
<input name="id" type="hidden" value="<?php echo $id ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>

<?php echo genHeader($dM,'navbar');
$dH=array('id'=>$id,'mod_nom'=>$det['nom'],'icon'=>null);
echo genHeader($dH,'page-header',null,$btnAcc.$btnNew,null,null,'h2'); ?>

<div class="row">
<div class="col-sm-6">
<div class="well">
	<fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="control-label col-sm-4" for="iNom">Nombre</label>
			<div class="col-sm-8">
		  <input name="iNom" type="text" id="iNom" placeholder="Nombre del Menú" value="<?php echo $det['nom']; ?>" class="form-control"></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4" for="iRef">Referencia</label>
			<div class="col-sm-8">
		  <input name="iRef" type="text" id="iRef" placeholder="Referencia del menú" value="<?php echo $det['ref']; ?>" class="form-control"></div>
		</div>
	</fieldset>
</div>
</div>
<div class="col-sm-6">
	<div class="panel panel-default">
    	<div class="panel-heading">Menus en este contenedor</div>
        <div class="panel-body">Coding</div>
    </div>
</div>
</div>
</form>