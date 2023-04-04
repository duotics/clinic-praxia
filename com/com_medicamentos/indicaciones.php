<?php require('../../init.php');
$dM = $Auth->vLogin('INDICA');
include(RAIZf . 'head.php');
include(RAIZm . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc ?>com_index/">Inicio</a></li>
  <li><a href="<?php echo $RAIZc ?>com_medicamentos/">Gestion Tratamientos</a></li>
  <li class="active">Indicaciones</li>
</ol>
<div class="container-fluid">
  <?php sLOG('g') ?>
  <?php include('_indicaciones.php') ?>
</div>
<?php include(RAIZf . 'footer.php') ?>