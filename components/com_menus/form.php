<?php include('../../init.php');
$dM = $Auth->vLogin('MENUCONT');
$brdItems = [
  [$cfg['i']['config']],
  ["Menus Contenedores", route['c'] . "com_menus"],
  ["Formulario", null, true]
];
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, [$brdItems]);
$mTpl->renderHead();
?>
<div class="container">
  <?php $mTpl->renderTop(); ?>
  <?php include('_form.php') ?>
</div>
<?php $mTpl->renderFoot() ?>