<?php include('../../init.php');
$dM = $Auth->vLogin('MENUCONTENT');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
$brdItems = array(
  array("nom" => $cfg['i']['config']),
  array("nom" => "Menus Contenedores", "link" => "{route['c']}com_menus"),
  array("nom" => "Formulario", "css" => "active")
);
genBreadcrumb($brdItems) ?>
<div class="container">
  <?php sLOG('t') ?>
  <?php include('_form.php') ?>
</div>
<?php include(root['f'] . 'foot.php'); ?>