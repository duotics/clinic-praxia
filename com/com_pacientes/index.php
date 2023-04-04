<?php include('../../init.php');
$dM = $Auth->vLogin('PACIENTE');
include(RAIZf . "head.php");
include(RAIZm . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genHeader($dM) ?>
	<div class="well well-sm"><?php include('fra_pacFind.php'); ?></div>
	<div><?php include('pacientes_list.php'); ?></div>
</div>
<?php include(RAIZm . 'mod_taskbar/taskb_pacientes.php'); ?>
<?php include(RAIZf . 'footer.php'); ?>