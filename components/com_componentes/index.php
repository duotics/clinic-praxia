<?php include('../../init.php');
$dM = $Auth->vLogin('COMP');
$brdItems = array(array("nom" => "Sistema"));
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, [$brdItems]);
$mTpl->renderHead();
?>
<div class="container">
  <?php $mTpl->renderTop() ?>
  <?php include('_index.php'); ?>
</div>
<?php $mTpl->renderFoot() ?>