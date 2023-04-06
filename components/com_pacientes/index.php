<?php include('../../init.php');
$dM = $Auth->vLogin('PAC');
$objHead = new App\Core\genInterfaceHeader($dM, 'header');
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php $objHead->showInterface() ?>
	<?php $dataBus = genInterfaceBusqueda($dM['ref'] ?? null); ?>
	<div class="card mb-3">
		<div class="card-body p-2">
			<?php include('pacientesFind.php') ?>
		</div>
	</div>
	<div><?php include('pacientesList.php') ?></div>
</div>
<?php include(root['m'] . 'mod_taskbar/taskb_pacientes.php'); ?>
<?php include(root['f'] . 'footer.php'); ?>