<?php require('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$detMed=detRow('db_medicamentos','id_form',$id);
if($acc=='NEW') $vPF=TRUE;
if($detMed){
	$id=$detMed['id_form'];
	$acc=md5('UPDm');
	$vPF=TRUE;
	$btn_action='<button type="submit" class="btn btn-success btn-large"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}else{
	$acc=md5('INSm');
	$btn_action='<button type="submit" class="btn btn-primary btn-large"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}
$TR=totRowsTab('db_medicamentos');
if($TR>0){
	$pages = new Paginator;
	$pages->items_total = $TR;
	$pages->mid_range = 8;
	$pages->items = 50;
	$pages->paginate();
	$qry='SELECT * FROM db_medicamentos ORDER BY id_form DESC '.$pages->limit;
	$RSd=mysqli_query(conn,$qry);
	$row_RSd=mysqli_fetch_assoc($RSd);
	$tr_RSd=mysqli_num_rows($RSd);
}
include(root['f'].'head.php');
?>
<body class="cero">
<?php include(root['m'].'mod_menu/menuMain.php'); ?>
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
      <a class="navbar-brand" href="#">Medicamentos</a>
    </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  	<form class="navbar-form navbar-right">
        <a href="<?php echo $urlc ?>?acc=NEW" class="btn btn-default"><i class="fa fa-plus fa-lg"></i> NUEVO</a>
      </form>
	  </div>
  </div><!-- /.container-fluid -->
</nav>


<div class="container-fluid">
	<?php sLOG('g'); ?>
	<div class="well well-sm" id="panelForm">
	<form method="post" action="actions.php" role="form">
    <fieldset>
        <input name="form" type="hidden" id="form" value="fmed">
        <input name="id" type="hidden" id="id" value="<?php echo $id?>">
        <input name="acc" type="hidden" id="acc" value="<?php echo $acc?>">
        <input name="url" type="hidden" id="acc" value="<?php echo urlc?>">
    </fieldset>
    <div class="row">
    <div class="col-sm-6"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="generico" class="col-sm-2 control-label">Laboratorio</label>
    	<div class="col-sm-10">
    	<?php genSelectA('lab',detRowGSel('db_types','typ_cod','typ_val','typ_ref','LABORATORIO'),$detMed['lab'],' form-control input-sm', NULL,'tlab',NULL, TRUE ,NULL, 'Seleccione') ?>
    	</div>
	</div>
    <div class="form-group">
    	<label for="generico" class="col-sm-2 control-label">Medicamento</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-6">
            <input name="generico" type="text" class="form-control" id="generico" placeholder="Generico" value="<?php echo $detMed['generico'] ?>" required></div>
			<div class="col-sm-6">
            <input name="comercial" type="text" class="form-control" id="comercial" placeholder="Comercial" value="<?php echo $detMed['comercial'] ?>"></div>
		</div>
	</div>
	</div>
	<div class="form-group">
    	<label for="presentacion" class="col-sm-2 control-label">Información</label>
    	<div class="col-sm-10">
    	<div class="row">
			<div class="col-sm-8"><input name="presentacion" type="text" class="form-control" id="presentacion" placeholder="Presentación" value="<?php echo $detMed['presentacion'] ?>"></div>
			<div class="col-sm-4"><input name="cantidad" type="number" class="form-control" id="cantidad" placeholder="Cantidad" value="<?php echo $detMed['cantidad'] ?>"></div>
		</div>
    </div>
	</div>
    </fieldset></div>
    <div class="col-sm-3"><fieldset class="form-horizontal">
    
    <div class="form-group">
    	<label for="descripcion" class="col-sm-2 control-label">RP.</label>
    	<div class="col-sm-10">
    	<textarea name="descripcion" rows="3" class="form-control" id="descripcion"><?php echo $detMed['descripcion'] ?></textarea>
    	</div>
	</div>
    </fieldset></div>
    <div class="col-sm-3"><fieldset class="form-horizontal">
    <div class="form-group">
    	<label for="" class="col-sm-2 control-label"></label>
    	<div class="col-sm-10">
    	<?php echo $btn_action ?>
    	<a href="<?php echo $urlc ?>?acc=NEW" class="btn btn-default navbar-btn"><i class="fa fa-plus"></i> NUEVO</a>
    	</div>
	</div>
    </fieldset></div>
    </div>
            
	</form>
	</div>
<?php if ($tr_RSd>0){ ?>
	<div class="well well-sm">
		<fieldset class="form-inline">
			<span class="label label-default">Filtros</span>
			
		</fieldset>
	</div>
	<div class="well well-sm">
		<div class="row">
			<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
			<div class="col-md-6">
				<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
			</div>
			<div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
		</div>
	</div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Laboratorio</th>
			<th>Generico</th>
			<th>Comercial</th>
            <th>Presentacion</th>
            <th>Cantidad</th>
            <th style="width:35%">Prescripción</th>
            <th>Estado</th>
			<?php if($tr_RSd<=10){ ?><th><abbr title="Consultas relacionadas">Recetas</abbr></th><?php } ?>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php do{?>
	<?php $TMC=NULL;
			 if($tr_RSd<=10) $TMC=totRowsTab('db_tratamientos_detalle','idref',$row_RSd['id_form']);
			 $dLab=detRow('db_types','typ_cod',$row_RSd['lab']);
			 $btnStat=genStatus('actions.php',array('id'=>$row_RSd['id_form'], 'val'=>$row_RSd['estado'],'acc'=>md5(STm),"url"=>$urlc));
			 $detME=detRow('db_tratamientos_detalle','idref',$row_RSd['id_form']);
		?>
		<tr>
			<td><?php echo $row_RSd['id_form'] ?></td>
			<td><?php echo $dLab['typ_val'] ?></td>
			<td><?php echo $row_RSd['generico'] ?></td>
			<td><?php echo $row_RSd['comercial']?></td>
            <td><?php echo $row_RSd['presentacion']?></td>
            <td><?php echo $row_RSd['cantidad']?></td>
            <td><?php echo $row_RSd['descripcion']?></td>
            <td><?php echo $btnStat ?></td>
			<?php if($tr_RSd<=10){ ?> <td><?php echo $TMC ?></td><?php } ?>
			<td>
				<a href="<?php echo $urlc ?>?id=<?php echo $row_RSd['id_form'] ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Modificar</a>
				<?php if(!$detME){ ?>
				<a href="actions.php?id=<?php echo $row_RSd['id_form'] ?>&acc=<?php echo md5(DELm)?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Eliminar</a>
				<?php } ?>
			</td>
		</tr>
	<?php } while ($row_RSd = mysqli_fetch_assoc($RSd));?>
	</tbody>
	</table>
	<div class="well well-sm">
		<div class="row">
			<div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
			<div class="col-md-6">
				<ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
			</div>
			<div class="col-md-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
		</div>
	</div>
<?php }else{ echo '<div class="alert alert-danger"><h4>No Existen Medicamentos Generados</h4></div>'; }?>
</div>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
<?php if($vPF){ ?>
	$("#panelForm").show();
<?php }else{ ?>
	$("#panelForm").hide();
<?php }	?>
});
</script>