<?php include('../../init.php');
vLOGIN();
$detU=detRow('tbl_usuario','usr_id',$_SESSION['dU']['ID']);
$detE=dataEmp($detU['emp_cod']);
$detE_fullname=$detE['emp_nom'].' '.$detE['emp_ape'];
$_SESSION['MODSEL']="PERF";
include(root['f']."head.php");?>
<?php sLOG('g') ?>
<?php include(root['m'].'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
    <?php if($detU){ ?>
	<form action="actions.php" method="post" role="form">
    <input type="hidden" name="form" value="formPerfil">
    <div class="row">
    	<div class="col-sm-6">
        	<div class="panel panel-default">
            	<div class="panel-heading"><i class="fa fa-info-circle fa-lg"></i> Información del Empleado</div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="col-sm-3 control-label">Tipo</label>
                     <div class="col-sm-9">
                     <?php genSelect('typ_cod',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPEMP'),$detE['typ_cod'],'form-control','required'); ?>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Cedula</label>
                     <div class="col-sm-9">
                     <input type="text" name="emp_ced" value="<?php echo $detE['emp_ced'] ?>" class="form-control" placeholder="Documento Identidad">
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Nombres</label>
                     <div class="col-sm-9">
                        <div class="row">
                        <div class="col-sm-6">
                        	<input name="emp_nom" type="text" class="form-control" placeholder="Nombres" value="<?php echo $detE['emp_nom'] ?>">
                        </div>
                        <div class="col-sm-6">
                        	<input name="emp_ape" type="text" class="form-control" placeholder="Apellidos" value="<?php echo $detE['emp_ape'] ?>">
                        </div>
                        </div>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Dirección</label>
                     <div class="col-sm-9">
                     <input type="text" name="emp_dir" value="<?php echo $detE['emp_dir'] ?>" class="form-control" placeholder="Dirección">
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Telefonos</label>
                     <div class="col-sm-9">
                        <div class="row">
                        <div class="col-sm-6">
                        	<input name="emp_tel" type="text" class="form-control" placeholder="Fijo" value="<?php echo $detE['emp_tel'] ?>">
                        </div>
                        <div class="col-sm-6">
                        	<input name="emp_cel" type="text" class="form-control" placeholder="Celular" value="<?php echo $detE['emp_cel'] ?>">
                        </div>
                        </div>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Email</label>
                     <div class="col-sm-9">
                     <input type="email" name="emp_mail" value="<?php echo $detE['emp_mail'] ?>" class="form-control" placeholder="Email">
                     </div>
                </div>
                </fieldset>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="panel panel-primary">
            	<div class="panel-heading"><i class="fa fa-sign-in fa-lg"></i> Datos de Usuario</div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="col-sm-3 control-label">Usuario</label>
                     <div class="col-sm-9">
                     <input type="text" name="usr_nombre" value="<?php echo $detU['usr_nombre'] ?>" class="form-control" placeholder="Nombre de usuario" required>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Contraseña</label>
                     <div class="col-sm-9">
                     <a href="<?php echo route['c']?>com_usersystem/changePass.php" class="btn btn-warning fancybox fancybox.iframe"><i class="fa fa-key"></i> Cambiar Contraseña</a>
                     </div>
                </div>
                
                <div class="form-group">
                	<label class="col-sm-3 control-label">Tema</label>
                   	<div class="col-sm-9">
                        <input list="themes" name="user_theme" value="<?php echo $detU['usr_theme'] ?>" class="form-control">
                        <datalist id="themes">
                        <option value="yeti">bootstrap-yeti.min.css</option>
                        <option value="darkly">bootstrap-darkly.min.css</option>
                        <option value="cerulean">bootstrap-cerulean.min.css</option>
                        <option value="flatly">bootstrap-flatly.min.css</option>
                        <option value="cosmo">bootstrap-cosmo.min.css</option>
                        <option value="united">bootstrap-united.min.css</option>
                        <option value="superHero">bootstrap-superhero.min.css</option>
                        <option value="readable">bootstrap-readable.min.css</option>
                        <option value="lumen">bootstrap-lumen.min.css</option>
                        <option value="journal">bootstrap-journal.min.css</option>
                        <option value="simplex">bootstrap-simplex.min.css</option>
                    	</datalist>
                     </div>
                </div>
                </fieldset>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>
	</form>
	<?php }else{ ?>
		<div class="alert alert-danger"><h4>No se ha seleccionado un Usuario</h4></div>	
	<?php } ?>
</div>
<?php include(root['f'].'footer.php')?>