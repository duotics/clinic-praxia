<?php include('../../init.php');
$dM = $Auth->vLogin('MENUCONT');
$brdItems = [[$cfg['i']['config']]];
$mTpl = new App\Core\TemplateGen(null, null, "sw", ['mod_menu/menuMain.php'], null, [$brdItems]);
$mTpl->renderHead();
?>
<div class="container">
  <?php $mTpl->renderTop() ?>
  <?php include('_index.php'); ?>
</div>
<?php $mTpl->renderFoot() ?>