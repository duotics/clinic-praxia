<?php include('../../init.php');
$Auth->vLogin();
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, null, [null, 'header',"INICIO"]);
$mTpl->renderHead();
?>
<div class="container-fluid">
  <?php $mTpl->renderTop(); ?>
  <?php include('_index.php') ?>
</div>
<?php $mTpl->renderFoot() ?>