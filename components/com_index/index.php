<?php include('../../init.php');
$Auth->vLogin();
$dM = $db->detRow('db_componentes', null, 'mod_ref', 'HOME');
$obj = new App\Core\genInterfaceHeader($dM, 'page-header');
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php');
sLOG("g") ?>
<div class="container-fluid">
  <?php $obj->showInterface() ?>
  <?php include('_index.php') ?>
</div>
<?php include(root['f'] . "footer.php") ?>