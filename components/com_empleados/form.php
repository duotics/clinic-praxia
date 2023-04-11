<?php include('../../init.php');
$dM=$Auth->vLogin('EMPLEADO');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$detE=detRow('db_empleados','emp_cod',$id);
if($detE){
	$acc=md5('UPD');
	$btnAcc='<button type="submit" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
	$detU=detRow('tbl_usuario','emp_cod',$id);
}else{
	$acc=md5('INS');
	$btnAcc='<button type="submit" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}
$btnNew='<a class="btn btn-default" href="form.php"><i class="fa fa-plus fa-lg"></i> Nuevo</a>';
include(root['f']."head.php");
include(root['m'].'mod_menu/menuMain.php');
sLOG('g') ?>
<ul class="breadcrumb">
	<li><a href="<?php echo route['c'] ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo route['c'] ?>com_empleados">Empleados</a></li>
    <li class="active">Formulario</li>
</ul>
<div class="container">
    <?php echo genPageNavbar($dM['mod_cod']) ?>
<form action="acc.php" method="post" role="form">
<input type="hidden" name="id" value="<?php echo $id ?>">
<input type="hidden" name="form" value="formEmp">
<input type="hidden" name="acc" value="<?php echo $acc ?>">
<div class="btn-group pull-right">
	<?php echo $btnAcc ?>
    <?php echo $btnNew ?>
</div>
<?php echo genPageHead(NULL,$detE['emp_nom'].' '.$detE['emp_ape'],'h2', $id,NULL) ?>
    
    
    
    <div class="row">
    	<div class="col-sm-6">
        	<div class="panel panel-primary">
            	<div class="panel-heading"><i class="fa fa-info-circle fa-lg"></i> Información del Empleado</div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="col-sm-3 control-label">Tipo</label>
                     <div class="col-sm-9">
                     <?php genSelectA('typ_cod',detRowGSel('db_types','typ_cod','typ_val','typ_ref','TIPEMP'),$detE['typ_cod'],'form-control','required'); ?>
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
        	<div class="panel panel-default">
            	<div class="panel-heading"><i class="fa fa-sign-in fa-lg"></i> Datos de Usuario</div>
                <div class="panel-body">
                <?php if($acc==md5('UPD')){ ?>
				<?php if($detU){ ?>
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="col-sm-3 control-label">ID</label>
                     <div class="col-sm-9">
                     <input class="form-control" type="text" placeholder="nombre de usuario" value="<?php echo $detU['ID'] ?>" readonly>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Nombre Usuario</label>
                     <div class="col-sm-9">
                     <input class="form-control" type="text" placeholder="nombre de usuario" value="<?php echo $detU['usr_nombre'] ?>" readonly>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Tema</label>
                     <div class="col-sm-9">
                     <input class="form-control" type="text" placeholder="tema visual para el usuario" value="<?php echo $detU['usr_theme'] ?>" readonly>
                     </div>
                </div> 
                <div class="text-center">
                <a class="btn btn-info" href="<?php echo route['c'] ?>com_usersystem/form.php?id=<?php echo $detU['usr_id'] ?>">
                <i class="fa fa-edit fa-lg"></i> Editar usuario</a> 			
                </div>
                </fieldset>
                <?php }else{ ?>
                <div class="text-center">
                <p class="lead">No Existe Usuario Relacionado</p>
                <a href="<?php echo route['c'] ?>com_usersystem/user_form.php" class="btn btn-primary">Crear Credenciales de Usuario</a>
                </div>
				<?php }?>
                <?php }else{ ?>
                <p class="lead">Primero debe <strong>GUARDAR</strong> el Empleado</p>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
	</form>
</div>
<?php include(root['f'].'footer.php')?>