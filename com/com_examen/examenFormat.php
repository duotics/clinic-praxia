<?php include('../../init.php');
$dM = $Auth->vLogin('EXAFORMAT');
include(RAIZf . "head.php");
include(RAIZm . 'mod_menu/menuMain.php'); ?>
<?php sLOG('g') ?>
<div class="container">
    <div><?php include('_examenFormat.php'); ?></div>
</div>

<?php include(RAIZf . 'footer.php') ?>