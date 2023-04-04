<?php include('../../init.php');
$dM = $Auth->vLogin('REPDIAG');
include(RAIZf . "head.php");
include(RAIZm . 'mod_menu/menuMain.php');
sLOG("g", $_REQUEST['LOG'] ?? null) ?>
<div class="container">
    <?php echo genHeader($dM, 'page-header') ?>
    <?php include('_rep_diag.php') ?>
</div>
<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<?php include(RAIZf . "footer.php") ?>