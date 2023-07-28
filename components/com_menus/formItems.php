<?php include('../../init.php');
$dM = $Auth->vLogin('MENUITEM');
$brdItems = [
  [$cfg['i']['config']],
  ["Menus Contenedores", route['c'] . "com_menus"],
  ["Menus Items", route['c'] . "com_menus/indexItems.php"],
  ["Formulario", null, true]
];
$mTpl = new App\Core\TemplateGen(null, null, "sw", ['mod_menu/menuMain.php'], null, [$brdItems]);
$mTpl->renderHead() ?>
<div class="container">
  <?php $mTpl->renderTop() ?>
  <?php include('_formItems.php') ?>
</div>
<?php $mTpl->renderFoot() ?>