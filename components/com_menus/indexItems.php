<?php include('../../init.php');
$dM = $Auth->vLogin('MENU ITEMS');
include(root['f'] . 'head.php');
include(root['m'] . 'mod_menu/menuMain.php');
$brdItems = array(
  array("nom" => $cfg['i']['config']),
  array("nom" => "Menus Contenedores", "link" => "{route['c']}com_menus")
);
genBreadcrumb($brdItems, TRUE, "Menus Items");
?>
<div class="container">
  <?php sLOG('t') ?>
  <?php include('_indexItems.php'); ?>
</div>
<?php include(root['f'] . 'foot.php') ?>