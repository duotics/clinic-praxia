<?php require('../../init.php');
$dM = $Auth->vLogin('LABS');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
	<li><a href="<?php echo $RAIZc ?>com_index">Inicio</a></li>
	<li><a href="<?php echo $RAIZc ?>com_laboratorios/">Gestion Tratamientos</a></li>
	<li><a href="<?php echo $RAIZc ?>com_laboratorios/laboratorio.php">Laboratorio</a></li>
	<li class="active">Formulario</li>
</ol>
<?php sLOG('g') ?>
<div class="container">
	<?php require('_laboratorioForm.php'); ?>
</div>
<?php include(root['f'] . 'footer.php') ?>