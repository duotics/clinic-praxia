<?php include('../../init.php');
fnc_accesslev("1,2,3");
$_SESSION['MODSEL']="PAG";
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div class="container">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/pacientes_find.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientes_list.php'); ?></div>
</div>
<?php include(RAIZf.'fraBot.php');
include(RAIZm.'taskbar/_taskbar_pagos.php'); ?>
</body>
</html>