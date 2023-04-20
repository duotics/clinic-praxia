<div class="row">
	<div class="col-sm-12 col-lg-9">
		<div class="card mb-3">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-6">
						<h4 class="border-bottom pb-3 mb-3">
							<i class="fa fa-user-md fa-lg"></i> Diagnosticos
							<a href="<?php echo route['c'] ?>com_comun/gest_diag.php" class="btn btn-info btn-sm float-end" data-fancybox="reload" data-type="iframe">
								<i class="fa-solid fa-folder-open"></i> Gestionar
							</a>
							<div class="clearfix"></div>
						</h4>

						<fieldset>
							<div class="mb-3">
								<select class="selDiag" data-val="<?php echo $idsCon ?>" style="width: 100%;">
								</select>
							</div>
							<div class="mb-3">
								<input type="text" class="form-control" name="diagD" id="diagD" placeholder="Otros Diagnósticos">
							</div>
							<div class="mb-3">
								<button type="button" class="setConDiagOtro btn btn-info btn-xs" data-val="<?php echo $idsCon ?>">AGREGAR</button>
							</div>
						</fieldset>
					</div>
					<div class="col-sm-12 col-md-6">
						<div id="consDiagDet">
							<?php include('consultaDetDiagSel.php') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12 col-lg-3">
		<?php
		$lConDiagHist = $objCon->ConsultaInterfaz_ListDiagHist(); ?>
		<div class="card">
			<div class="card-header">Historial Diagnósticos</div>
			<?php echo $lConDiagHist ?>
		</div>
	</div>
</div>