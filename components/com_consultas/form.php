<?php require('../../init.php');
$dM = $Auth->vLogin('CON');
$mTpl = new App\Core\TemplateGen(null, null, null, ['mod_menu/menuMain.php'], null);
$mTpl->renderHead();
require('_form.php');
$mTpl->renderFoot();
