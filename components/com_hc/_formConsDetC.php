<div class="">
	<div class="row g-3 mb-3">
		<div class="col-md-6">
			<label for="dcon_mot" class="form-label">Motivos de la Consulta</label>
			<textarea name="dcon_mot" id="dcon_mot" class="form-control input-sm setDB" data-id="<?php echo $idc ?>" data-rel="con" rows="4">
				<?php echo $detCon['dcon_mot'] ?>
			</textarea>
		</div>
		<div class="col-md-6">
			<label for="dcon_obs" class="form-label">Conclusion</label>
			<textarea name="dcon_obs" id="dcon_obs" class="form-control input-sm setDB" data-id="<?php echo $idc ?>" data-rel="con" rows="4">
				<?php echo $detCon['dcon_obs'] ?>
			</textarea>
		</div>
	</div>
	
	<div>
		<?php include('_formConsDetDG.php') ?>
	</div>
</div>