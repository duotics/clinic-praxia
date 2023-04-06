<?php require_once('../../init.php') ?>
<script type="text/javascript" src="<?php echo route['a'] ?>js/js_carga_pac.js"></script>
<?php //dep($dM)

$dataUrlRoute=cfgBus[$dM['ref']]['route'] ?? null;
$dataUrl=route[$dataUrlRoute].cfgBus[$dM['ref']]['url'];
$dataParam=cfgBus[$dM['ref']]['param'];
?>
<div class="row">
	<div class="col-md-6">
		<form id="fs01">
			<input type="hidden" id="locUrl" data-url="<?php echo $dataUrl ?>" data-param="<?php echo $dataParam ?>">
			<input id="tags" class="form-control" placeholder="Busqueda" name="sBr" autofocus autocomplete="off">
		</form>
	</div>
	<div class="col-md-6">
		<div id="cont_cli"></div>
	</div>
</div>