<div class="row mb-3">
	<div class="col-sm-6">
		<label>Motivos de la Consulta</label>
		<textarea name="dcon_mot" rows="4" class="form-control input-sm setDB" id="dcon_mot" data-id="" data-rel="con"><?php echo $dCon['dcon_mot'] ?></textarea>
	</div>
	<div class="col-sm-6">
		<label>Conclusion</label>
		<textarea name="dcon_obs" rows="4" class="form-control input-sm setDB" id="dcon_obs" data-id="<?php echo $idsCon ?>" data-rel="con"><?php echo $dCon['dcon_obs'] ?></textarea>
	</div>
</div>