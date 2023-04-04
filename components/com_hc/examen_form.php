<?php require('../../init.php');
$_SESSION['tab']['con']='cEXA';
$idp=$_GET['idp'] ?? $_POST['idp'] ?? null;
$idc=$_GET['idc'] ?? $_POST['idc'] ?? null;
$ide=$_GET['ide'] ?? $_POST['ide'] ?? null;
$action=$_GET['action'] ?? $_POST['action'] ?? null;
$detexam=detRow('db_examenes','id_exa',$ide);//fnc_dataexam($ide);
if($ide) {$idp=$detexam['pac_cod']; $idc=$detexam['con_num'];}
if($action=='DELEF'){
	header(sprintf("Location: %s", '_fncts.php?ide='.$ide.'&action=DELEF'));
}
$detpac=dataPac($idp);
$detpac_nom=$detpac['pac_nom'].' '.$detpac['pac_ape'];

if($detexam){
	$action='UPD';
	$dateexam=$detexam['fechae'];
	$btnform='<button type="submit" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR</button>';
}else{
	$dateexam=date('Y-m-d');
	$action='INS';
	$btnform='<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> CREAR</button>';
}
include(RAIZf.'head.php');
?>
<body class="cero">
<form action="_fncts.php" method="post" id="formexam" enctype="multipart/form-data" style="margin-bottom:0px;">
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
        <li><a><?php echo $detpac_nom?></a></li>
        <li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
        <li><a><?php echo $detexam['fecha'] ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <?php echo $btnform ?>
      <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
      </div>
	</div>
</div>
</nav>
<div class="container-fluid">
<?php sLOG('g'); ?>
<fieldset>
			<input name="ide" type="hidden" id="ide" value="<?php echo $ide ?>">
            <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
			<input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
			<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
			<input name="form" type="hidden" id="form" value="fexamen">
			</fieldset>
<div class="row">
	<div class="col-sm-6">
    <fieldset class="form-horizontal well well-sm">
		<div class="form-group">
        	<label class="control-label col-sm-3" for="resultado">Fecha</label>
			<div class="col-sm-9">
            <input name="fechae" type="date" id="fechae" value="<?php echo $dateexam; ?>" class="form-control">
			</div>
		</div>
		<div class="form-group">
        	<label class="control-label col-sm-3" for="resultado">Descripcion</label>
			<div class="col-sm-9">
              <input name="descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripcion" value="<?php echo $detexam['descripcion'] ?>" autofocus>
			</div>
		</div>
		<div class="form-group">
        	<label class="control-label col-sm-3" for="resultado">Resultados</label>
			<div class="col-sm-9">
			<textarea name="resultado" rows="8" class="form-control" id="resultado" placeholder="Resultados"><?php echo $detexam['resultado'] ?></textarea>
			</div>
		</div>
    </fieldset>
	</div>
	<div class="col-sm-6">
    
    <div class="well well-sm">
<?php if($detexam){
	$qryfc=sprintf('SELECT * FROM db_examenes_media WHERE id_exa=%s ORDER BY id DESC',
	SSQL($ide,'int'));
	$RSfc=mysqli_query(conn,$qryfc);
	$row_RSfc=mysqli_fetch_assoc($RSfc);
	$tr_RSfc=mysqli_num_rows($RSfc);
?>
<div class="well well-sm" style="background:#FFF">
	
    <textarea name="dfile" rows="2" class="form-control" id="dfile" placeholder="Descripcion de la Imagen"></textarea>
	<input name="efile" id="efile" type="file" onChange="uploadImage();" class="form-control"/>
</div>
<?php	if($tr_RSfc>0){ ?>



<div class="row">
	<?php do{ ?>
            <?php $detMedia=detRow('db_media','id_med',$row_RSfc['id_med']);
			$detMedia_file=$RAIZmdb.'exam/'.$detMedia['file'];
			?>
           
  <div class="col-sm-6">
    <div class="thumbnail">
      <img src="<?php echo $detMedia_file ?>" alt="<?php echo $detMedia['des'] ?>">
      <div class="caption">
        <h3><?php echo $detMedia['des'] ?></h3>
        <p>
        <a href="<?php echo $detMedia_file ?>" class="btn btn-primary btn-xs fancybox" role="button">
        <i class="fa fa-eye"></i> Ver</a> 
        <a href="_fncts.php?ide=<?php echo $ide ?>&id=<?php echo $row_RSfc['id'] ?>&action=delEimg" class="btn btn-danger btn-xs" role="button">
        <i class="fa-solid fa-trash"></i> Eliminar</a>
        </p>
      </div>
    </div>
  </div>
  
	<?php }while ($row_RSfc = mysqli_fetch_assoc($RSfc)); ?>
</div>

<?php }else echo '<div class="alert alert-warning">No han guardado archivos de este Examen</div>'; ?>

<?php }else echo '<div class="alert alert-warning"><h4>No se puede cargar archivos</h4>Aun No Se ha Guardado el Examen</div>';?>
</div>
    
	</div>
</div>
</div>
</form>
<script type="text/javascript">
$('#descripcion').focus();
function uploadImage() { formexam.submit(); }
</script>
</body>
</html>