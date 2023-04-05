<?php include('../../init.php');
$_SESSION['MODSEL']="FAC";
$_SESSION['b']=NULL; //echo $_SESSION['b'].'B';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(root['f']."head.php");
include(root['f'].'fraTop.php'); ?>
<div class="container">
	<div class="page-header">
    	<h1><img src="<?php echo $RAIZi ?>db/mod/<?php echo $rowMod['mod_img']; ?>"> <?php echo $rowMod['mod_nom']; ?>
        <small><?php echo $rowMod['mod_des']; ?></small></h1>
	</div>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/pacientes_find.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientesList.php'); ?></div>
<div id="bottomcont"><?php include(root['f'].'fraBot.php'); ?></div>
</div>
<?php include(RAIZ.'modulos/taskbar/_taskbar_pacientes.php'); ?>
</body>
</html>