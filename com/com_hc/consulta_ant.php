<fieldset>
	<div class="well well-sm">
		<h4><i class="fa fa-history fa-lg"></i> Historial Anterior de Consultas (Sistema Antiguo)</h4>
		<div class="form-group">
			<textarea name="hc_ant" rows="15" class="form-control" id="hc_ant" onChange="setDB(this.name,this.value,<?php echo $id_hc ?>,'hc')"><?php echo $row_RShc['hc_ant'] ?? null ?></textarea>
		</div>
	</div>
</fieldset>