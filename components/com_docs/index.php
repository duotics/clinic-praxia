<?php include('../../init.php');
$dM=$Auth->vLogin();
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');?>
<?php sLOG("g"); ?>
<div class="container-fluid">
	<?php echo genHeader($dM) ?>
	<div class="well well-sm"><?php //include(RAIZc.'com_pacientes/fra_pacFind.php'); ?></div>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>