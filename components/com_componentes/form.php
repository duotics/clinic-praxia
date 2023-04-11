<?php include('../../init.php');
$dM = $Auth->vLogin('COMP');
$brdItems = [["Sistema"], ["Componentes", route['c'] . "com_componentes/"]];
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, [$brdItems]);
$mTpl->renderHead() ?>
<div class="container">
  <?php $mTpl->renderTop();  ?>
  <?php include('_form.php') ?>
</div>
<?php $mTpl->renderFoot() ?>