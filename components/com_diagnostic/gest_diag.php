<?php require('../../init.php');
$dM=$Auth->vLogin('DIAGNOSTICO');
include(root['m'].'mod_menu/menuMain.php');
include(root['f'].'head.php');?>
<?php sLOG('g'); ?>
<div class="container">
	<?php include('_gest_diag.php') ?>
</div>
<?php include(root['f'].'footer.php') ?>