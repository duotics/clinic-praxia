<?php include('../../init.php');
$Auth->vLogin();
$obj = new App\Core\genInterfaceHeader(null,'page-header',"INICIO");
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php');
sLOG("g") ?>
<div class="container-fluid">
  <?php $obj->showInterface() ?>
  <?php include('_index.php') ?>
</div>
<?php include(root['f'] . "foot.php") ?>