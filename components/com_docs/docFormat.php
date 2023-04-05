<?php include('../../init.php');
$dM=$Auth->vLogin('DOCF');
include(root['f']."head.php");
include(root['m'].'mod_menu/menuMain.php'); ?>
<?php sLOG('t')?>
<div class="container">
    <div><?php include('_docFormat.php'); ?></div>
</div>
<?php include(root['f'].'footer.php')?>