<?php require('../../init.php');
$dM = $Auth->vLogin('LABS');
$brcItems = [
	["Gestión Tratamientos", root['c'] . "com_tratamientos"],
	["Laboratorios", root['c'] . "com_laboratorios"],
	["Formulario", null, true]
];
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null, [$brcItems]);
$mTpl->renderHead() ?>
<div class="container">
	<?php $mTpl->renderTop() ?>
	<?php require('_form.php'); ?>
</div>
<?php $mTpl->renderFoot(); ?>