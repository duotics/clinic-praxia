<div class="row">
	<div class="col-sm-9">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					<i class="fa fa-user-md fa-lg"></i> Diagnosticos
					<a href="<?php echo $RAIZc ?>com_comun/gest_diag.php" class="btn btn-info btn-xs fancybox fancybox.iframe fancyreload pull-right" onClick="ansclose=false;"><i class="fa fa-plus-square-o"></i> Gestionar Diagnosticos</a>
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
		$resDiag = null;
		$qrlLCA = sprintf(
			'SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<>%s ORDER BY con_num DESC LIMIT 5',
			SSQL($idp, 'int'),
			SSQL($idc, 'int')
		);
		$RSlca = mysqli_query(conn, $qrlLCA);
		$dRSlca = mysqli_fetch_assoc($RSlca);
		$tRSlca = mysqli_num_rows($RSlca);
		if ($tRSlca > 0) {
			$resDiag .= '<table class="table">';
			do {
				$resDiag .= '<tr>';
				$resDiag .= '<td>' . date("Y-m-d", strtotime($dRSlca["con_fec"])) . '</td>';
				$resDiag .= '<td>';
				$qLD = sprintf(
					'SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
					SSQL($dRSlca['con_num'], 'int')
				);
				$RSld = mysqli_query(conn, $qLD);
				$dRSld = mysqli_fetch_assoc($RSld);
				$tRSld = mysqli_num_rows($RSld);
				if ($tRSld > 0) {
					do {
						if ($dRSld["id_diag"] > 1) {
							$dDiag = detRow('db_diagnosticos', 'id_diag', $dRSld["id_diag"]);
							$dDiag_cod = $dDiag["codigo"] . '-';
							$dDiag_nom = $dDiag["nombre"];
						} else {
							$dDiag_cod = NULL;
							$dDiag_nom = $dRSld["obs"];
						}
						$resDiag .= ' <span class="btn btn-default btn-xs">' . $dDiag_cod . $dDiag_nom . '</span> ';
					} while ($dRSld = mysqli_fetch_assoc($RSld));
				}
				$resDiag .= '</td></tr>';
			} while ($dRSlca = mysqli_fetch_assoc($RSlca));
			$resDiag .= '</table>';
		} else $resDiag = '<div class="panel-body">Sin resultados anteriores</div>';
		?>
		<div class="panel panel-default">
			<div class="panel-heading">Historial Diagnósticos anteriores</div>
			<?php echo $resDiag ?>
		</div>
	</div>
</div>