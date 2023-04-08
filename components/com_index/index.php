<?php include('../../init.php');
$Auth->vLogin();
$mTpl = new App\Core\TemplateGen(null, null, "sw", ['mod_menu/menuMain.php'], null);
$mTpl->renderHead();
?>
<div class="container-fluid">
  <?php include('_index.php') ?>
</div>
<?php $mTpl->renderFoot() ?>