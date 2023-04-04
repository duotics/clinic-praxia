<?php 
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$detDiag=detRow('db_diagnosticos','id_diag',$id);
$btn_new='<a href="'.$urlc.'?acc=NEW" class="btn btn-default"><span class="fa fa-plus"></span> Nuevo Diagnostico</a>';
if($acc=='NEW') $vPF=TRUE;
if($detDiag){
	$id=$detDiag['id_diag'];
	$acc='UPDd';
	$vPF=TRUE;
	$btnAcc='<button type="button" id="vAcc" class="btn btn-success btn-large"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Actualizar</button>';
}else{
	$acc='INSd';
	$btnAcc='<button type="button" id="vAcc" class="btn btn-primary btn-large"><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i> Grabar</button>';
}
$TR=totRowsTab('db_diagnosticos');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$qry = 'SELECT * FROM db_diagnosticos ORDER BY id_diag DESC '.$pages->limit;
	$RSd = mysqli_query(conn,$qry) or die(mysqli_error(conn));
	$dRSd = mysqli_fetch_assoc($RSd);
	$tr_RSd = mysqli_num_rows($RSd);
}
?>
<?php echo genHeader($dM,'navbar') ?>
<div>
	<?php echo $btn_new ?>
</div>
	<div class="well well-sm" id="panelForm">
	<form method="post" action="_fncts.php" class="" role="form">
		<fieldset>
			<input name="form" type="hidden" id="form" value="<?php echo md5(fdiag) ?>">
			<input name="id" type="hidden" id="id" value="<?php echo $id?>">
			<input name="acc" type="hidden" id="acc" value="<?php echo md5($acc)?>">
			<input name="url" type="hidden" id="url" value="<?php echo $urlc?>">
		</fieldset>
		<fielset class="form-horizontal">
		<div class="form-group">
			<label for="" class="control-label col-sm-4">ID</label>
			<div class="col-sm-8">
           	<input type="text" class="form-control" placeholder="ID" value="<?php echo $detDiag['id_diag']?>" disabled>
            </div>
		</div>
      	<div class="form-group">
			<label for="" class="control-label col-sm-4">CODIGO</label>
			<div class="col-sm-8">
            <input name="codigo" type="text" autofocus class="form-control" id="codigo" placeholder="Codigo Internacional" value="<?php echo $detDiag['codigo']?>" maxlength="100" required>
            </div>
		</div>
       
        <div class="form-group">
        	<label for="" class="control-label col-sm-4">NOMBRE</label>
		  	<div class="col-sm-8">
		  		<input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre Diagnostico" value="<?php echo $detDiag['nombre']?>" maxlength="255" required>
			</div>
		</div>
       <div class="form-group">
        	<label for="" class="control-label col-sm-4">INFORMACION ADICIONAL</label>
		  	<div class="col-sm-8">
		  		<input name="val" type="text" class="form-control" id="val" placeholder="otra informacion" value="<?php echo $detDiag['val']?>" maxlength="255" required>
			</div>
		</div>
       <div class="form-group">
        	<label for="" class="control-label col-sm-4">REFERENCIA</label>
		  	<div class="col-sm-8">
		  		<input name="ref" type="text" class="form-control" id="ref" placeholder="Referencia de bibliografia" value="<?php echo $detDiag['ref']?>" maxlength="255" required>
			</div>
		</div>
        <div class="form-group">
        	<div class="col-sm-8 col-md-offset-4">
			<?php echo $btnAcc ?>
            
            </div>
		</div>
		</fielset>
	</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<div class="well well-sm">
		<div class="row">
			<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
			<div class="col-md-7">
				<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
			</div>
			<div class="col-md-3"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
		</div>
	</div>
	<table class="table table-striped table-bordered table-condensed" id="mytable">
	<thead>
		<tr>
			<th>ID</th>
			<th>Codigo</th>
			<th>Nombre</th>
			<th>Inf</th>
			<th>Referencia</th>
			<th>Consultas</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
	<?php $TCD=totRowsTab('db_consultas_diagostico','id_diag',$dRSd['id_diag']); ?>
		<tr>
			<td><?php echo $dRSd['id_diag'] ?></td>
			<td><?php echo $dRSd['codigo'] ?></td>
			<td width="60%"><?php echo $dRSd['nombre']?></td>
			<td><?php echo $dRSd['val']?></td>
			<td><?php echo $dRSd['ref']?></td>
			<td><?php echo $TCD ?></td>
			<td><div class="btn-group">
				<a href="<?php $urlc ?>?id=<?php echo $dRSd['id_diag'] ?>" class="btn btn-success btn-xs">
				<i class="fa fa-edit fa-lg"></i> Editar</a>
				<?php if($TCD<=0){ ?>
				<a href="_fncts.php?id=<?php echo $dRSd['id_diag'] ?>&acc=<?php echo md5('DELd') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
				<i class="fa fa-trash fa-lg"></i> Eliminar</a>
				<?php } ?>
			</div></td>
		</tr>
	<?php } while ($dRSd = mysqli_fetch_assoc($RSd));?>
	</tbody>
	</table>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Diagnosticos Generados</h4></div>'; }?>

<script type="text/javascript">
$(document).ready(function(){
<?php if($vPF){ ?>
	$("#panelForm").show();
<?php }else{ ?>
	$("#panelForm").hide();
<?php }	?>
});
</script>