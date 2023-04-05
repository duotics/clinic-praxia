<?php include('../../init.php');
$dM = $Auth->vLogin('PACIENTE');
include(root['f'] . 'head.php'); ?>
<script type="text/javascript" src="js.js"></script>
<?php include(root['m'] . 'mod_menu/menuMain.php') ?>
<?php sLOG('g'); ?>
<div class="container-fluid">
	<?php include('_form.php') ?>
</div>
<?php include(root['f'] . 'footer.php') ?>