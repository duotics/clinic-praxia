<?php include('../../init.php');
$dM = $Auth->vLogin('MENUITEM');
$css['body'] = 'cero';
include(RAIZf . 'head.php'); ?>
<div class="container">
	<?php sLOG('g'); ?>
	<?php include('_formItems.php') ?>
</div>
<?php include(RAIZf . 'footer.php'); ?>