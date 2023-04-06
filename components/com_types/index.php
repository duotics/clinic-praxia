<?php include('../../init.php');
$dM = $Auth->vLogin('TYPES');
include(root['f'] . "head.php"); ?>
<?php include(root['m'] . 'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genHeader($dM, 'page-header') ?>
	<div><?php include('_index.php'); ?></div>
</div>
<?php include(root['f'] . 'foot.php') ?>