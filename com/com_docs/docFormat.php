<?php include('../../init.php');
$dM=$Auth->vLogin('DOCF');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php'); ?>
<?php sLOG('t')?>
<div class="container">
    <div><?php include('_docFormat.php'); ?></div>
</div>
<?php include(RAIZf.'footer.php')?>