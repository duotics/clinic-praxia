<?php include('../../init.php');
$dM = $Auth->vLogin('TYPES');
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, null, [$dM, "head"]);
$mTpl->renderHead() ?>
<div class="container">
	<?php $mTpl->renderTop() ?>
	<div><?php include('_index.php'); ?></div>
</div>
<?php $mTpl->renderFoot(); ?>