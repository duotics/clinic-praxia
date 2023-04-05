<?php require('../../init.php');
$dM = $Auth->vLogin('DRUGS');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php'); ?>
<ol class="breadcrumb">
  <li><a href="<?php echo route['c'] ?>com_index/">Inicio</a></li>
  <li><a href="<?php echo route['c'] ?>com_medicamentos/">Gestion Tratamientos</a></li>
  <li><a href="<?php echo route['c'] ?>com_medicamentos/medicamentos.php">Medicamentos</a></li>
  <li class="active">Formulario</li>
</ol>
<?php sLOG('g') ?>
<div class="container-fluid">
  <?php require('_medicamentosForm.php'); ?>
</div>
<?php include(root['f'] . 'footer.php') ?>