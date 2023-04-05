<?php include('../../init.php');
$dM=$Auth->vLogin('MENUITEM');
//var_dump($dM);
include(root['f'].'head.php');
include(root['m'].'mod_menu/menuMain.php'); ?>
<div class="container">
		<?php include('_indexItems.php'); ?>
</div>
<?php include(root['f'].'footer.php')?>