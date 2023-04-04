<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-user-md fa-lg"></i> Motivo de la Consulta</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<label>Motivos de la Consulta</label>
				<textarea name="dcon_mot" rows="4" class="form-control input-sm setDB" id="dcon_mot" data-id="<?php echo md5($idc) ?>" data-rel="con"><?php echo $detCon['dcon_mot'] ?></textarea>
			</div>
			<div class="col-sm-6">
				<label>Conclusion</label>
				<textarea name="dcon_obs" rows="4" class="form-control input-sm setDB" id="dcon_obs" data-id="<?php echo md5($idc) ?>" data-rel="con"><?php echo $detCon['dcon_obs'] ?></textarea>
			</div>
		</div>
	</div>
</div>
