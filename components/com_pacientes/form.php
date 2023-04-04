<?php include('../../init.php');
$dM = $Auth->vLogin('PACIENTE');
include(RAIZf . 'head.php'); ?>
<script type="text/javascript" src="js.js"></script>
<?php include(RAIZm . 'mod_menu/menuMain.php') ?>
<?php sLOG('g'); ?>
<div class="container-fluid">
	<?php include('_form.php') ?>
</div>
<?php include(RAIZf . 'footer.php') ?>