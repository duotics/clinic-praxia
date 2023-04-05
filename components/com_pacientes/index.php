<?php include('../../init.php');
$dM = $Auth->vLogin('PACIENTE');
$objHead = new App\Core\genInterfaceHeader($dM, 'header');
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php $objHead->showInterface() ?>
	<div class="well well-sm"><?php include('fra_pacFind.php'); ?></div>
	<div><?php include('pacientes_list.php'); ?></div>
</div>
<?php include(root['m'] . 'mod_taskbar/taskb_pacientes.php'); ?>
<?php include(root['f'] . 'footer.php'); ?>