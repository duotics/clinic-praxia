<?php include('../../init.php');
$dM=$Auth->vLogin('EXAM');
include(root['f']."head.php");?>
<?php include(root['m'].'mod_menu/menuMain.php'); ?>
<div class="container">
<?php echo genHeader($dM) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
	<div><?php include('examList.php'); ?></div>
</div>
<?php include(root['f'].'footer.php');?>