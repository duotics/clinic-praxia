<?php require('../../init.php');
$dM = $Auth->vLogin('LABS');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc ?>com_index/">Inicio</a></li>
  <li><a href="<?php echo $RAIZc ?>com_medicamentos/">Gestion Laboratorios</a></li>
  <li class="active">Indicaciones</li>
</ol>
<div class="container-fluid">
  <?php sLOG('g') ?>
  <?php include('_laboratorio.php') ?>
</div>
<?php include(root['f'] . 'footer.php') ?>