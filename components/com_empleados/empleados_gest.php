<?php include('../../init.php');
fnc_accesslev("1");
$_SESSION['MODSEL']="EMP";
$_SESSION['DIRSEL']="empleados_gest.php";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div class="container">
	<div class="page-header">
    	<h1><img src="<?php echo $RAIZi ?>db/mod/<?php echo $rowMod['mod_img']; ?>" class="module-image"> <?php echo $rowMod['mod_nom']; ?>
        <small><?php echo $rowMod['mod_des']; ?></small></h1>
	</div>
	<div><?php include('empleados_list.php'); ?></div>
    <?php include(RAIZm.'taskbar/_taskbar_empleado.php'); ?>
    <div id="bottomcont"><?php include(RAIZf.'fraBot.php'); ?></div>
</div>
</body>
</html>