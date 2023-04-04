<?php require('../../init.php');
$_SESSION['tab']['con']='cGIN';
$idp=$_GET['idp'] ?? $_POST['idp'] ?? null;
$ido=$_GET['ido'] ?? $_POST['ido'] ?? null;
$action=$_GET['action'] ?? $_POST['action'] ?? null;
$detObs=fnc_dataObs($ido);
//Eliminar Seguimiento
if($action=='DELOF'){
	header(sprintf("Location: %s", '_fncts.php?ido='.$ido.'&action=DELOF'));
}
if($detObs){
	$action='UPD';
	$btntrat='<button type="submit" class="btn btn-large btn-success"><i class="fa fa-refresh"></i> ACTUALIZAR</button>';
	$FS=$detObs['obs_fec'];
	$FSf=$detObs['obs_fecf'];
	if($FSf){
		$datSeg=$FSf;
		$SEG_est='<a class="btn btn-primary btn-xs">Finalizada</a>';
		$Sem_Vid=fnc_obst_semges($FSf,$sdate);
	}else{
		$datSeg=$sdate;
		$SEG_est='<a class="btn btn-default btn-xs">Pendiente</a>';
		$Sem_Vid='No nacido';
	}
	$FUM=$detObs['obs_fec_um'];
	$idp=$detObs['pac_cod'];
	$FPP=fnc_obst_fpp($FUM);
	$SEG=fnc_obst_semges($FUM,$datSeg);
}else{
	$action='INS';
	$FS=$sdate;
	$btntrat='<button type="submit" class="btn btn-large btn-info"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}
$detpac=dataPac($idp);
$detpacNom=$detpac['pac_nom'].' '.$detpac['pac_ape'];
include(RAIZf.'head.php');
?>
<body class="cero">
<div class="container-fluid">
<form method="post" action="_fncts.php" style="margin-bottom:0px;">
<fieldset>
	<input name="ido" type="hidden" id="ido" value="<?php echo $ido ?>">
	<input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
	<input name="action" type="hidden" id="action" value="<?php echo $action?>">
	<input name="form" type="hidden" id="form" value="obsdet">
</fieldset>
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><i class="fa fa-female fa-lg"></i> SEGUIMIENTO OBSTETRICO 
      <span class="label label-info"><?php echo $ido ?></span></a>
    </div>
	<div class="collapse navbar-collapse" id="navbar-collapse-2">
	<ul class="nav navbar-nav">
		<li class="active"><a href="#"><?php echo $detpacNom ?></a></li>
        <li><a><?php echo $detObs['obs_fec'] ?></a></li>
	</ul>
	<div class="navbar-right btn-group navbar-btn">
		<?php echo $btntrat?>
		<?php echo $btnaction ?>
		<a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
		</li>
	</div>
	</div><!-- /.navbar-collapse -->
</nav>
<?php sLOG('g'); ?>
	<div class="row">
    	<div class="col-md-6">
        	<div class="well well-sm">
            	<div class="row">
                	<div class="col-md-4">
    <label>Inicio de Seguimiento</label>
	<input name="obs_fec" type="date" class="form-control input-sm" id="obs_fec" value="<?php echo $FS ?>" autofocus>
    </div>
    				<div class="col-md-4">
                    <label>Ultima Menstruación</label>
    <input name="obs_fec_um" type="date" class="form-control input-sm" id="obs_fec_um" value="<?php echo $detObs['obs_fec_um'] ?>">
    </div>
					<div class="col-md-4">
    <label>Fin Seguimiento</label>
	<input name="obs_fecf" type="date" class="form-control input-sm" id="obs_fecf" value="<?php echo $FSf ?>">
    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="well well-sm">
            	<div class="row">
        	<div class="col-md-4">
            	<label>Fecha Posible de Parto</label>
    		<a class="btn btn-primary btn-xs btn-block  disabled"><?php echo $FPP ?></a>
            </div>
            <div class="col-md-4">
            	<label>Semanas Gestación</label>
    			<div class="btn-group">
                <?php echo $SEG_est ?>
                <a class="btn btn-primary btn-xs disabled"><?php echo $SEG ?></a>
                </div>
        	</div>
            <div class="col-md-4">
            	<label>Semanas Vida</label>
                <a class="btn btn-success btn-xs btn-block disabled"><?php echo $Sem_Vid ?></a>
                </div>
                
        	</div>
            
        </div>
			</div>
        </div>
</form>
<?php if($detObs){?>
<form method="post" action="_fncts.php" style="margin-bottom:0px;">
<div class="well well-sm">
	<fieldset>
	<input type="hidden" name="ido" id="ido" value="<?php echo $ido ?>">
	<input name="action" type="hidden" id="action" value="INSD">
	<input name="form" type="hidden" id="form" value="obsdet">

<div class="row">
  <div class="col-md-3">
    <input name="obs_fec" type="date" class="form-control" id="obs_fec" value="<?php echo $sdate ?>" required autofocus>
  </div>
  <div class="col-md-6">
    <textarea name="obs_det" class="form-control" id="obs_det" placeholder="Detalles del Seguimiento / Visita" rows="2" required></textarea>
  </div>
  <div class="col-xs-3">
    <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-floppy-o fa-lg"></i> AGREGAR VISITA</button>
  </div>
</div>

    
	
	
    </fieldset>
</div>
</form>
<div class="well well-sm" style="background:#FFF;">
<?php
		$qrytl='SELECT * FROM db_obstetrico_detalle WHERE obs_id='.$ido.' ORDER BY id DESC';
		$RSol=mysqli_query(conn,$qrytl);
		$row_RSol=mysqli_fetch_assoc($RSol);
		$tr_RSol=mysqli_num_rows($RSol);
if($tr_RSol>0){
?>
<table class="table table-bordered table-condensed table-striped">
<thead><tr>
	<th>Fecha</th>
	<th>Detalle</th>
    <th>Tiempo</th>
    <th></th>
</tr></thead>
<tbody>
<?php do{ ?>
<tr>
	<td><?php echo $row_RSol['obs_fec'] ?></td>
    <td><?php echo $row_RSol['obs_det'] ?></td>
    <td></td>
    <td><a href="_fncts.php?ido=<?php echo $ido ?>&idod=<?php echo $row_RSol['id'] ?>&action=DELOD" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></td>
</tr>
<?php }while ($row_RSol = mysqli_fetch_assoc($RSol));?>
</tbody>
</table>

<?php }else echo '<div class="alert alert-info"><h4>No se han registrado Visitas</h4></div>'; ?>
</div>
<?php }?>
</div>
<?php if($dettrat){?>
<script type="text/javascript">//$('#medicamento').focus();</script>
<?php }else{?>
<script type="text/javascript">//$('#diagnostico').focus();</script>
<?php } ?>
</body>
</html>