<?php require('../../init.php');
$Auth->vLogin();
$mTpl = new App\Core\TemplateGen(["css" => "cero"], null, null);
$mTpl->renderHead();
?>
<div class="container-fluid">
	<?php include("_tratamientoForm.php") ?>
</div>
<?php $mTpl->renderFoot() ?>