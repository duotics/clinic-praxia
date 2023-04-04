<?php include('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$detUsu=detRow('tbl_usuario','usr_id',$id);
if($detUsu){
	$acc='UPD';
	$detEmp=detRow('db_empleados','emp_cod',$detUsu['emp_cod']);
	$btnAcc='<button type="submit" class="btn btn-success navbar-btn navbar-right">GUARDAR CAMBIOS</button>';	
}

function verifyCheckUserMenu($idm,$idu){
	$qry=sprintf('SELECT * FROM tbl_menu_usuario WHERE men_id=%s AND usr_id=%s',
	SSQL($idm,'int'),
	SSQL($idu,'int'));
	$RS=mysqli_query(conn,$qry);
	$tRS=mysqli_num_rows($RS);
	if($tRS>0) return 'checked';
	else return NULL;
}

$css['body']='cero';
include(RAIZf.'head.php') ?>
<form method="post" action="menus_permiso_save.php" onSubmit="return verificarPassUser()">
<fieldset>
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <input type="hidden" name="form" value="formUsrPerm">
    <input type="hidden" name="acc" value="<?php echo $acc ?>">
    <input type="hidden" name="url" value="<?php echo $urlc ?>">
</fieldset>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#comUsuPer">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Permisos Usuarios 
      <small class="label label-default"><?php echo $id ?></small> 
      <small class="label label-primary"><?php echo $detUsu['usr_nombre'] ?></small> 
      <small class="label label-info"><?php echo $detEmp['emp_nom'].' '.$detEmp['emp_ape'] ?></small></a>
    </div>
    
    <div class="collapse navbar-collapse" id="comUsuPer">
      <?php echo $btnAcc ?>
    </div>
    
  </div><!-- /.container-fluid -->
</nav>
<?php sLOG('g'); ?>
<?php if($detUsu){ ?>
<?php
$qryMC=sprintf('SELECT * FROM tbl_menus');
$RSmc=mysqli_query(conn,$qryMC);
$dRSmc=mysqli_fetch_assoc($RSmc);
$tRSmc=mysqli_num_rows($RSmc);
?>

<?php if($tRSmc>0){ ?>
<div>
<ul class="nav nav-tabs" role="tablist">
<?php $fTl=TRUE; ?>
<?php do{ ?>
<?php $LMC[$dRSmc['id']]['id']=$dRSmc['id'];
$LMC[$dRSmc['id']]['ref']=$dRSmc['ref']; ?>
<li role="presentation" class="<?php if($fTl){ echo 'active'; $fTl=FALSE; } ?>">
	<a href="#<?php echo $dRSmc['ref'] ?>" aria-controls="<?php echo $dRSmc['ref'] ?>" role="tab" data-toggle="tab">
		<?php echo $dRSmc['nom'] ?>
    </a>
</li>
<?php }while($dRSmc=mysqli_fetch_assoc($RSmc)); ?>
</ul>

<?php $fTc=TRUE; ?>
<div class="tab-content well">
<?php foreach($LMC as $val){ ?>
	<div role="tabpanel" class="tab-pane <?php if($fTc){ echo 'active'; $fTc=FALSE; } ?>" id="<?php echo $val['ref'] ?>">
    <?php //MENUS PADRES DEL MENU CONTENEDOR SELECCIONADO
	$qryMP=sprintf('SELECT * FROM tbl_menus_items WHERE men_idc=%s AND men_padre=%s AND men_stat=%s',
	SSQL($val['id'],'int'),
	SSQL(0,'int'),
	SSQL(1,'int'));
	$RSmp=mysqli_query(conn,$qryMP);
	$dRSmp=mysqli_fetch_assoc($RSmp);
	$tRSmp=mysqli_num_rows($RSmp)
	?>
    <?php if($tRSmp>0){ ?>
    	<fieldset>
        <div class="row">
		<?php do{ ?>
        <?php $estCheckMp=verifyCheckUserMenu($dRSmp['men_id'],$id) ?>
        	<div class="col-sm-2">
            	<div class="well well-sm well-white">
                    <div class="checkbox">
                    <label>
                    <input name="CMP[]" type="checkbox" value="<?php echo $dRSmp['men_id'] ?>" <?php echo $estCheckMp ?>>
                    <span class="label label-primary"><?php echo $dRSmp['men_id'] ?></span> 
					<span data-toggle="tooltip" data-placement="right" title="<?php echo $dRSmp['men_tit'] ?>"><?php echo $dRSmp['men_nombre'] ?></span>
                    </label>
                    </div>

					<?php //MENUS PADRES DEL MENU CONTENEDOR SELECCIONADO
                        $qryMI=sprintf('SELECT * FROM tbl_menus_items WHERE men_padre=%s AND men_stat=%s',
                        SSQL($dRSmp['men_id'],'int'),
                        SSQL(1,'int'));
                        $RSmi=mysqli_query(conn,$qryMI);
                        $dRSmi=mysqli_fetch_assoc($RSmi);
                        $tRSmi=mysqli_num_rows($RSmi)
                        ?>
                        <?php if($tRSmi>0){ ?>
                            <?php do{ ?>
                            <?php $estCheckMi=verifyCheckUserMenu($dRSmi['men_id'],$id) ?>
                            <div class="checkbox">
                            <label>
                            <input name="CMP[]" type="checkbox" value="<?php echo $dRSmi['men_id'] ?>" <?php echo $estCheckMi ?>>
                            <span class="label label-default"><?php echo $dRSmi['men_id'] ?></span> 
                            <span data-toggle="tooltip" data-placement="right" title="<?php echo $dRSmi['men_tit'] ?>"><?php echo $dRSmi['men_nombre'] ?></span>
                            </label>
                            </div>
                            
                            
							<?php }while($dRSmi=mysqli_fetch_assoc($RSmi)); ?>
                        <?php } ?>

                </div>
            </div>
        <?php }while($dRSmp=mysqli_fetch_assoc($RSmp)); ?>
        </div>
        </fieldset>
	<?php }else{ ?>
    	<div class="alert alert-info"><h4>No Existen "Items Padres" en Este "Menu Contenedor" </h4></div>
    <?php } ?>
    </div>
<?php } ?>
</div>

</div>
<?php }else{ ?>
<div class="alert alert-info"><h4>No Existen Menus Contenedores</h4></div>
<?php }//End if tRSmc  ?>
<?php }else{ ?>
<div class="alert alert-danger"><h4>Usuario no Existe</h4></div>
<?php } //End if detUsu ?>
</form>
<?php include(RAIZf.'footer.php'); ?>