<?php include('../../init.php');
$dM=$Auth->vLogin('MENUITEM');
//var_dump($dM);
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
		<?php include('_indexItems.php'); ?>
</div>
<?php include(RAIZf.'footer.php')?>