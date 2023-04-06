<?php include('../../init.php');
$dM = $Auth->vLogin('PAC');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
sLOG('g') ?>
<div class="container-fluid">
	<?php include('_form.php') ?>
</div>
<?php include(root['f'] . 'foot.php') ?>