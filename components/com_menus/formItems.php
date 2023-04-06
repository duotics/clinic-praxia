<?php include('../../init.php');
$dM = $Auth->vLogin('MENU ITEMS');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
$itemsBrd = array(
  array("nom" => $cfg['i']['config']),
  array("nom" => "Menus Contenedores", "link" => "{route['c']}com_menus/"),
  array("nom" => "Menus Items", "link" => "{route['c']}com_menus/indexItems.php")
);
genBreadcrumb($itemsBrd, TRUE, "Formulario");
?>
<div class="container">
  <?php sLOG('t') ?>
  <?php include('_formItems.php') ?>
</div>
<?php include(root['f'] . 'foot.php'); ?>