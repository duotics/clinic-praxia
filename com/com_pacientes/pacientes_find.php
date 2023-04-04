<script type='text/javascript' src='<?php echo $RAIZ ?>js/js_carga_pac.js'></script>
<script type="text/javascript">
$().ready(function() {
	var id_tip = $(".list_tip").attr("value");//VALUE del List Seleccionado
	$("#sBr").autocomplete(RAIZ+"com/com_pacientes/search_cli.php?idsearch="+id_tip,{ width: 300, selectFirst: false });
	var sel_change = $("#list_tip");//Elemento list_tip asignado a una variable sel_change
	sel_change.change(function(){ id_tip = sel_change.attr("value");
	$("#sBr").autocomplete(RAIZ+"com/com_pacientes/search_cli.php?idsearch="+id_tip,{ width: 300, selectFirst: false }); });
	$("#sBr").result(function(event, data, formatted) { if (data) $("#id").val(data[1]); });	
});
</script>
<div class="row-fluid">
	<div class="span7">
		<div>
			<form autocomplete="off" action="<?php echo $urlcurrent ?>" method="get" class="form-inline" style="margin:0;">
			<select name="list_tip" id="list_tip" class="list_tip input-large">
				<option value="find_ape" selected="selected">Apellido Paciente</option>
				<option value="find_nom">Nombre Paciente</option>
				<option value="find_ciu">Ciudad</option>
			</select>
			<input type="text" name="sBr" id="sBr" class="input-xlarge" autofocus/>
			<input type="button" value="Buscar" class="btn_cons_cli btn btn-primary"/>
			<input type="hidden" name="id" disabled="disabled" class="id_find_cli" id="id" size="3" border="0"/>
			<span><img src="<?php echo $RAIZ ?>/images/struct/loader.gif" id="loading" /></span>
			</form>
		</div>
	</div>
    <div id="cont_cli" class="span5"></div>
</div>