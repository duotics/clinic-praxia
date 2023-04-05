<?php include('../../init.php');
//$dM=$Auth->vLogin('REP-RESD');
include(root['f'] . "head.php");
include(root['m'] . 'mod_menu/menuMain.php');
sLOG("g", $_REQUEST['LOG'] ?? null) ?>
<div class="container">
    <?php echo genHeader($dM ?? null, 'page-header') ?>
    <?php include('_rep_resd.php') ?>
</div>
<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<?php include(root['f'] . "footer.php") ?>