<?php include('../../init.php');
$dM = $Auth->vLogin('EXAFORMAT');
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php'); ?>
<?php sLOG('g') ?>
<div class="container">
    <div><?php include('_examenFormat.php'); ?></div>
</div>

<?php include(root['f'] . 'footer.php') ?>