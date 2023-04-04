<?php
$lConDiag = $mCon->getAllDiag();
?>
<?php if ($lConDiag) { ?>
	<table class="table">
		<tr>
			<th>Codigo</th>
			<th>Diagnostico</th>
			<th></th>
		</tr>
		<?php foreach ($lConDiag as $dRScd) { ?>
			<?php $dDCd = detRow('db_diagnosticos', 'id_diag', $dRScd["id_diag"]);
			if ($dDCd["id_diag"] == 1) {
				$nom = $dRScd["obs"];
			} else {
				$nom = $dDCd["nombre"];
			}
			?>
			<tr>
				<td><?php echo $dDCd["codigo"] ?></td>
				<td><?php echo $nom ?></td>
				<td><button class="delConDiag btn btn-danger btn-xs" type="button" data-id="<?php echo $dRScd["id_diag"] ?>" data-rel="delConDiag">
						<i class="fa fa-trash"></i></button></td>
			</tr>
		<?php } ?>
	</table>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.delConDiag').on('click', function() {
				var campo = $(this).attr("name");
				var valor = $(this).val();
				var cod = $(this).attr("data-id");
				var tbl = $(this).attr("data-rel");
				setDB('des', cod, '<?php echo $idc ?>', 'condiag');
				loadConDiag(<?php echo $idc ?>);
			});
		});
	</script>
<?php } else { ?>
	<div class="alert alert-info">Sin Diagnosticos seleccionados</div>
<?php } ?>