<?php include('../../init.php');
$dM=$Auth->vLogin('MENU CONTENT');
$css['body']='cero';
include(root['f'].'head.php'); ?>
<div class="container">
	<?php sLog('g'); ?>
	<?php include('_form.php') ?>
</div>
<?php include(root['f'].'footer.php'); ?>