<?php require('../../init.php');
$dM=$Auth->vLogin('DIAGNOSTICO');
include(RAIZm.'mod_menu/menuMain.php');
include(RAIZf.'head.php');?>
<?php sLOG('g'); ?>
<div class="container">
	<?php include('_gest_diag.php') ?>
</div>
<?php include(RAIZf.'footer.php') ?>