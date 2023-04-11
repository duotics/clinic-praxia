<?php include('../../init.php');
$dM = $Auth->vLogin('TYPES');
$mTpl = new App\Core\TemplateGen();
$mTpl->renderHead() ?>
<div class="container-fluid">
	<?php include('_form.php') ?>
</div>
<?php $mTpl->renderFoot() ?>