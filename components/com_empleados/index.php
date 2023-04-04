<?php include('../../init.php');
$dM=$Auth->vLogin('EMPLEADO');
include(RAIZf."head.php")?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<ul class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li> 
	<li><a href="<?php echo $RAIZc ?>com_empleados">Empleados</a></li> 
</ul>
<div class="container">
	<div class="btn-group pull-right">
    	<a class="btn btn-default" href="form.php"><i class="fa fa-plus fa-lg"></i> Nuevo</a>
    </div>
	<?php echo genPageHead($dM['mod_cod']);
    sLOG('g'); ?>
	<div><?php include('empList.php'); ?></div>
    <?php include(RAIZm.'mod_taskbar/_taskbar_empleado.php'); ?>
	</div>
<?php include(RAIZf."footer.php") ?>