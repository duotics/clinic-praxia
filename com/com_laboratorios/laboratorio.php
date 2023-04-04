<?php require('../../init.php');
$dM = $Auth->vLogin('LABS');
include(RAIZf . 'head.php');
include(RAIZm . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc ?>com_index/">Inicio</a></li>
  <li><a href="<?php echo $RAIZc ?>com_medicamentos/">Gestion Laboratorios</a></li>
  <li class="active">Indicaciones</li>
</ol>
<div class="container-fluid">
  <?php sLOG('g') ?>
  <?php include('_laboratorio.php') ?>
</div>
<?php include(RAIZf . 'footer.php') ?>