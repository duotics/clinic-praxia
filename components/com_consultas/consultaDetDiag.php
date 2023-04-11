<div class="row">
	<div class="col-sm-9">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i class="fa fa-user-md fa-lg"></i> Diagnosticos
					<a href="<?php echo route['c'] ?>com_comun/gest_diag.php" class="btn btn-info btn-xs fancybox fancybox.iframe fancyreload pull-right" onClick="ansclose=false;"><i class="fa fa-plus-square-o"></i> Gestionar Diagnosticos</a>
				</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<fieldset>
							<div class="form-group">
								<select class="selDiag" data-val="<?php echo md5($idc) ?>" style="width: 100%;">
								</select>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="diagD" id="diagD" placeholder="Otros Diagnósticos">
							</div>
							<div class="form-group">
								<button type="button" class="setConDiagOtro btn btn-info btn-xs" data-val="<?php echo md5($idc) ?>">AGREGAR</button>
							</div>
						</fieldset>
					</div>
					<div class="col-sm-6">
						<div id="consDiagDet">
							<?php include('consultaDetDiagSelNew.php') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		<?php
		$lConDiagHist = $objCon->ConsultaInterfaz_ListDiagHist(); ?>
		<div class="card">
			<div class="card-header">Historial Diagnósticos anteriores</div>
			<?php echo $lConDiagHist ?>
		</div>
	</div>
</div>