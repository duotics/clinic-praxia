<?php include('../../init.php');
$dM = $Auth->vLogin('COMPONENTE');
include(RAIZf . 'head.php'); ?>
<?php include(RAIZm . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php include('_index.php'); ?>
</div>
<?php include(RAIZf . 'footer.php') ?>