<?php include('../../init.php');
$dM = $Auth->vLogin('TYPES');
include(RAIZf . "head.php"); ?>
<?php include(RAIZm . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genHeader($dM, 'page-header') ?>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(RAIZf . 'footer.php') ?>