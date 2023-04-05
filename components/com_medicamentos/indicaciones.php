<?php require('../../init.php');
$dM = $Auth->vLogin('INDICA');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
  <li><a href="<?php echo route['c'] ?>com_index/">Inicio</a></li>
  <li><a href="<?php echo route['c'] ?>com_medicamentos/">Gestion Tratamientos</a></li>
  <li class="active">Indicaciones</li>
</ol>
<div class="container-fluid">
  <?php sLOG('g') ?>
  <?php include('_indicaciones.php') ?>
</div>
<?php include(root['f'] . 'footer.php') ?>