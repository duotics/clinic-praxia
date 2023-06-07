<?php include('../../init.php');
$dM = $Auth->vLogin('CON');
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], ['mod_taskbar/taskb_consultas.php'], null, [$dM, 'header']);
$mTpl->renderHead();
?>
<div class="container">
	<?php $mTpl->renderTop() ?>
	<?php include(root['c'] . 'com_pacientes/pacientesDataset.php'); ?>
</div>
<?php $mTpl->renderFoot() ?>