<?php include('../../init.php');
$Auth->vLogin();
$obj = new App\Core\genInterfaceTitle(null,'header',"INICIO");
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php');
sLOG("sw") ?>
<div class="container-fluid">
  <?php $obj->showInterface() ?>
  <?php include('_index.php') ?>
</div>
<?php include(root['f'] . "foot.php") ?>