<form action="_acc.php" method="post">
	<fieldset>
		<input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>" />
		<input name="idp" type="hidden" id="idp" value="<?php echo $idsPac ?>" />
		<input name="idc" type="hidden" id="idc" value="<?php echo $idsCon ?>" />
		<input name="idr" type="hidden" id="idr" value="<?php echo $idsRes ?>" />
		<input name="cons_stat" type="hidden" id="cons_stat" value="<?php echo $dCon['status']  ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo md5('consForm') ?>" />
	</fieldset>
	<div class="container-fluid">
		<?php include('_formCentTop.php') ?>
		<?php include('_formCentHis.php') ?>
		<?php include('_formCentPac.php') ?>
		<div><?php include('_formCentTabsContent.php') ?></div>

	</div>
</form>

<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
<!-- END INTERFACE CONSULTA -->