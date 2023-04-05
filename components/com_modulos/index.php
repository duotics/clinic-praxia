<?php include('../../init.php');
$dM = $Auth->vLogin('COMPONENTE');
include(root['f'] . 'head.php'); ?>
<?php include(root['m'] . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php include('_index.php'); ?>
</div>
<?php include(root['f'] . 'footer.php') ?>