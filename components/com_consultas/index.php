<?php include('../../init.php');
$dM=$Auth->vLogin('CONSULTA');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');?>
<div class="container">
	<?php echo genHeader($dM)?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientes_list.php'); ?></div>
</div>
<?php include(RAIZm.'mod_taskbar/taskb_consultas.php'); ?>
<?php include(RAIZf.'footer.php')?>