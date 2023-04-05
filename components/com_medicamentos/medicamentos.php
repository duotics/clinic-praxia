<?php require('../../init.php');
$dM = $Auth->vLogin('DRUGS');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc ?>com_index/">Inicio</a></li>
  <li><a href="<?php echo $RAIZc ?>com_medicamentos/">Gestion Tratamientos</a></li>
  <li class="active">Medicamentos</li>
</ol>
<?php sLOG('g') ?>
<div class="container-fluid">
  <?php include('_medicamentos.php') ?>
</div>
<?php include(root['f'] . 'footer.php') ?>