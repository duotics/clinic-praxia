<?php require('../../init.php');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb">
  <li><a href="<?php echo route['c'] ?>com_index/">Inicio</a></li>
  <li class="active">Gestion Tratamientos</li>
</ol>
<?php sLOG('g') ?>
<div class="container-fluid">
  <?php include('_index.php') ?>
</div>
<?php include(root['f'] . 'footer.php') ?>