<?php include('../../init.php');
$dM = $Auth->vLogin('MENUITEM');
$brdItems = array(
  array("nom" => $cfg['i']['config']),
  array("nom" => "Menus Contenedores", "link" => "{route['c']}com_menus")
);
$mTpl = new App\Core\TemplateGen(null, null, "sw", ['mod_menu/menuMain.php'], null);
$mTpl->renderHead();
?>
<div class="container">
  <?php $mTpl->renderTop(); ?>
  <?php include('_indexItems.php'); ?>
</div>
<?php $mTpl->renderFoot() ?>