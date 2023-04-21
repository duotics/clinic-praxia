<?php require('../../init.php');
$dM = $Auth->vLogin('LABS');

$brdItems = [
  ["Gestión de Tratamientos", route["c"] . "com_tratamientos/"],
  ["Laboratorio", null, true]
];
$mTpl = new App\Core\TemplateGen(null, null, "sw", ['mod_menu/menuMain.php'], null, [$brdItems]);
$mTpl->renderHead() ?>
<div class="container">
  <?php $mTpl->renderTop() ?>
  <?php include('_index.php') ?>
</div>
<?php $mTpl->renderFoot() ?>