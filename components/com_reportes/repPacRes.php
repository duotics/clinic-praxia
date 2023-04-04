<?php include('../../init.php');
//$dM=$Auth->vLogin('REP-RESP');
include(RAIZf."head.php");
include(RAIZm.'mod_menu/menuMain.php');
sLOG("g",$_REQUEST['LOG']) ?>
<div class="container">
    <?php echo genPageHead($dM['mod_cod'])?>
	<?php include('_repPacRes.php') ?>
</div>
<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<?php include(RAIZf."footer.php") ?>