<?php include('../../init.php');
$dM = $Auth->vLogin('SIGVIT');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php') ?>
<ol class="breadcrumb" style="margin:0">
  <li><a href="<?php echo route['c'] . 'com_index/' ?>">Inicio</a></li>
  <li><a href="<?php echo route['c'] . 'com_signos/' ?>">Signos Vitales</a></li>
  <li class="active">Paciente</li>
</ol>
<div class="container-fluid">
  <?php include('gestSig.php'); ?>
</div>
<?php include(root['f'] . 'footer.php') ?>