<?php include('../../init.php');
fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="PAG";
include(root['f']."head.php");
include(root['f'].'fraTop.php'); ?>
<div class="container">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/pacientes_find.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientesList.php'); ?></div>
</div>
<?php include(root['f'].'fraBot.php');
include(root['m'].'taskbar/_taskbar_pagos.php'); ?>
</body>
</html>