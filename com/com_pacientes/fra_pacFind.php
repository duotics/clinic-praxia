<?php require_once('../../init.php') ?>
<script type="text/javascript" src="<?php echo $RAIZa ?>js/js_carga_pac.js"></script>
<div class="row">
	<div class="col-md-6">
		<form id="fs01">
			<input type="hidden" id="locUrl" value="<?php echo $dM['mod_ref'] ?? null ?>">
			<input id="tags" class="form-control" placeholder="Busqueda" name="sBr" autofocus autocomplete="off">
		</form>
	</div>
	<div class="col-md-6">
		<div id="cont_cli"></div>
	</div>
</div>