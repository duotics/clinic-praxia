<?php
$mExam = new \App\Models\Examen;
$lExam = $mExam->getAllExamCon($idc, $idp);
$lExamCont = count($lExam);
$lExamFormat = $mExam->getAllExamFormatActive();
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<i class="fa fa-list-alt fa-lg"></i> EXAMENES
		<!-- Single button -->
		<div class="btn-group">
			<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				NUEVO <i class="fa fa-plus-circle fa-lg"></i> <span class="caret"></span>
			</button>
			<?php if ($lExamFormat) { ?>
				<ul class="dropdown-menu">
					<?php foreach ($lExamFormat as $dRSlef) { ?>
						<li>
							<a href="<?php echo "{$RAIZc}com_examen/_fncts.php?idp=$idp&idc=$idc&idef={$dRSlef["id"]}&acc=" . md5("NEWe") ?>" class="fancybox.iframe fancyreload" style="padding:10px">
								<?php echo $dRSlef["nom"] ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</div>
	</div>
	<div class="panel-body">
		<?php if ($lExam) { ?>
			<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>ID</th>
						<th>Fecha</th>
						<th>Formato</th>
						<th>Ver</th>
						<th>Imagenes</th>
						<th></th>
						<th></th>
						<th>Consulta</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$contCG = 0;
					$id_ant = null;
					?>
					<?php foreach ($lExam as $dRSe) { ?>
						<?php
						$tEFD = $db->totRowsTab('db_examenes_det', 'ide', $dRSe['id_exa']);
						//Total de Examenes con esta consulta
						$tECG = $db->totRowsTab('db_examenes', 'con_num', $dRSe['con_num']);
						$ExaResGen = NULL;
						$btnPEC = NULL;
						$vPEC = FALSE;
						if ($tEFD > 0) {
							$lExamDet = $mExam->getAllExamDet(md5($dRSe['id_exa']));
						} else {
							$ExaResGen = '<input type="text" class="form-control input-sm setDB" name="resultado" data-id="' . md5($dRSe['id_exa']) . '" data-rel="exa" value="' . $dRSe['resultado'] . '"/>';
						}
						$dEF = detRow('db_examenes_format', 'id', $dRSe['id_ef']);
						$btnView = NULL;
						if ($dRSe['des']) $btnView = '<a href="' . $RAIZc . 'com_examen/examenPreview.php?id=' . $dRSe['id_exa'] . '" class="btn btn-default btn-xs fancybox.iframe fancyreload"><i class="fa fa-eye"></i></a>';
						$classtr = NULL;
						if ($idc == $dRSe['con_num']) $classtr = 'class="warning"';
						$idc_act = $dRSe['con_num'];
						if ($idc_act == $id_ant) {
							$contCG++;
						} else {
							$contCG = 0;
							$id_ant = $idc_act;
							$vPEC = TRUE;
							$btnPEC = "<td style='vertical-align:middle; text-align: center' rowspan='$tECG'>
							<a class='printerButton btn btn-default btn-sm' data-id='{$dRSe['con_num']}' data-rel='{$RAIZc}com_examen/examenGPrintJS.php'>
							<i class='fa fa-print fa-lg'></i> Imprimir Grupo Examenes</a>
							</td>
							<td style='vertical-align:middle; text-align: center' rowspan='$tECG'>{$dRSe['con_num']}</td>";
						}
						?>
						<tr <?php echo $classtr ?>>
							<td><?php echo $dRSe['id_exa'] ?></td>
							<td><?php echo $dRSe['fecha'] ?></td>
							<td>
								<fielset class="form-horizontal">
									<?php if (!$tEFD) { ?>
										<div class="form-group">
											<label class="control-label col-sm-6"><?php echo $dEF['nom'] ?></label>
											<div class="col-sm-6">
												<?php echo $ExaResGen ?>
											</div>
										</div>
									<?php } ?>
									<?php if ($tEFD > 0) { ?>
										<?php foreach ($lExamDet as $dRSltef) { ?>
											<?php $detEFN = detRow('db_examenes_format_det', 'id', $dRSltef["idefd"]); ?>
											<div class="form-group">
												<label class="control-label col-sm-6"><?php echo $detEFN["nom"] ?></label>
												<div class="col-sm-6">
													<input type="text" class="form-control input-sm setDB" name="res" data-id="<?php echo md5($dRSltef['id']) ?>" data-rel="exadet" value="<?php echo $dRSltef['res'] ?>" />
												</div>
											</div>
										<?php } ?>
									<?php } ?>
								</fielset>
							</td>
							<td><?php echo $btnView ?></td>
							<td><?php echo $db->totRowsTab('db_examenes_media', 'id_exa', $dRSe['id_exa']) ?></td>
							<td>
								<div class="btn-group">
									<a href="<?php echo "{$RAIZc}com_examen/examenForm.php?ide={$dRSe['id_exa']}" ?>" class="btn btn-primary fancybox fancybox.iframe fancyreload">
										<?php echo $cfg['b']['edit'] ?>
									</a>
									<a class="printerButton btn btn-default" data-id="<?php echo $dRSe['id_exa'] ?>" data-rel="<?php echo route['c'] ?>com_examen/examenPrintJS.php">
										<?php echo $cfg['i']['print'] ?>
									</a>
									<a href="<?php echo "{$RAIZc}com_examen/examenForm.php?ide={$dRSe['id_exa']}&acc=" . md5('DELe') ?>" class="btn btn-default btn-danger fancybox.iframe fancyclose">
										<?php echo $cfg['i']['del'] ?>
									</a>
								</div>
							</td>
							<?php if ($vPEC) {
								echo $btnPEC;
								$vPEC = FALSE;
							} ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>'; ?>
	</div>
	<div class="panel-footer">Resultados. <?php echo $lExamCont ?></div>
</div>
<script type="text/javascript"></script>