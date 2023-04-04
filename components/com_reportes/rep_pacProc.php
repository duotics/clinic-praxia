<?php include('../../init.php');
$dM = $Auth->vLogin('REP_PAC_ORIGEN');
include(RAIZf . "head.php"); ?>

<body>
	<?php include(RAIZm . 'mod_menu/menuMain.php'); ?>
	<div class="container">
		<?php //echo gen_pageTit($_SESSION['MODSEL']) ?>
		<div class="well well-sm"><?php include('rep_pacProc_fra.php'); ?></div>
		<div><?php include('rep_pacProc_list.php'); ?></div>
	</div>
</body>
<?php include(RAIZf . 'footer.php'); ?>