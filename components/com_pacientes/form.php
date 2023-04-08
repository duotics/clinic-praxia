<?php include('../../init.php');
$dM = $Auth->vLogin('PAC');
$mHead->showInterface();
include(root['m'] . 'mod_menu/menuMain.php');
sLOG('g') ?>
<div class="container-fluid">
	<?php include('_form.php') ?>
</div>
<?php
$mFoot->showInterface() ?>