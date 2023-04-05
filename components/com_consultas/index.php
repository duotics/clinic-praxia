<?php include('../../init.php');
$dM=$Auth->vLogin('CONSULTA');
include(root['f']."head.php");
include(root['m'].'mod_menu/menuMain.php');?>
<div class="container">
	<?php echo genHeader($dM)?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/pacientesFind.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientesList.php'); ?></div>
</div>
<?php include(root['m'].'mod_taskbar/taskb_consultas.php'); ?>
<?php include(root['f'].'footer.php')?>