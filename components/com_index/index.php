<?php include('../../init.php');
$Auth->vLogin();
$mTpl = new App\Core\TemplateGen(null, null, "sw", ['mod_menu/menuMain.php'], null, null, [null, 'header', 'INICIO', null, null, null, null, 'h1']);
$mTpl->renderHead();
?>
<div class="container-fluid">
  <?php $mTpl->renderTop(); ?>
  <?php include('_index.php') ?>
</div>
<?php $mTpl->renderFoot() ?>