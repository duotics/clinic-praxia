<?php include('../../init.php');
$_SESSION['MODSEL']="SIG";
$rowMod=fnc_datamod($_SESSION['MODSEL']);
include(RAIZf.'head.php');?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
<hr>
<ol class="breadcrumb" style="margin:0">
  <li><a href="<?php echo $RAIZc.'com_index/'?>">Inicio</a></li>
  <li><a href="<?php echo $RAIZc.'com_signos/'?>">Signos Vitales</a></li>
  <li class="active">Paciente</li>
</ol>
<?php include('gest_sig.php'); ?>
</div>