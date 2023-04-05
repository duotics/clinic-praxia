<?php include('../../init.php');
$dM = $Auth->vLogin('MENUITEM');
$css['body'] = 'cero';
include(root['f'] . 'head.php'); ?>
<div class="container">
	<?php sLOG('g'); ?>
	<?php include('_formItems.php') ?>
</div>
<?php include(root['f'] . 'footer.php'); ?>