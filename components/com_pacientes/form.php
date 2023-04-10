<?php include('../../init.php');
$dM = $Auth->vLogin('PAC');
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, null, [$dM, 'header']);
$mTpl->renderHead()
?>
<div class="container-fluid">
	<?php include('_form.php') ?>
</div>
<?php
$mTpl->renderFoot() ?>