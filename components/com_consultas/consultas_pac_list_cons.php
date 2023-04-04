<?php include('../../init.php');
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$query_RSlcp = sprintf(
	"SELECT * FROM db_consultas WHERE pac_cod= %s ORDER BY con_num DESC",
	SSQL($idp, "int")
);
$RSlcp = mysqli_query(conn, $query_RSlcp) or die(mysqli_error(conn));
$row_RSlcp = mysqli_fetch_assoc($RSlcp);
$totalRows_RSlcp = mysqli_num_rows($RSlcp);
if ($totalRows_RSlcp > 0) { ?>
	<table class="table table-bordered table-condensed cero">
		<thead>
			<tr>
				<th>Historial</th>
				<th>Visita</th>
				<th>Cons</th>
				<th>Fecha</th>
				<th>Diagnostico</th>
			</tr>
		</thead>
		<tbody>
			<?php $contVis = $totalRows_RSlcp; ?>
			<?php do { ?>
				<?php
				//$detDiagCH=detRow('db_diagnosticos','id_diag',$row_RSlcp['con_diagd']);

				$qLD = sprintf(
					'SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
					SSQL($row_RSlcp['con_num'], 'int')
				);
				$RSld = mysqli_query(conn, $qLD);
				$dRSld = mysqli_fetch_assoc($RSld);
				$tRSld = mysqli_num_rows($RSld);
				$resDiag = NULL;
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
						$resDiag .= ' <span class="label label-default">' . $dDiag_cod . $dDiag_nom . '</span> ';
					} while ($dRSld = mysqli_fetch_assoc($RSld));
				}
				?>
				<tr>
					<td><a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $row_RSlcp['con_num']; ?>&nvis=<?php echo $contVis ?>" class="btn btn-default btn-xs btn-block">
							<i class="fa fa-eye fa-lg"></i> Ver
						</a></td>
					<td class="text-center"><?php echo $contVis; ?></td>
					<td><?php echo $row_RSlcp['con_num']; ?></td>
					<td><?php echo $row_RSlcp['con_fec']; ?></td>
					<td><?php echo $resDiag ?></td>
				</tr>
				<?php $contVis--; ?>
			<?php } while ($row_RSlcp = mysqli_fetch_assoc($RSlcp)); ?>
		</tbody>
	</table>
<?php } else {
	echo '<div class="alert alert-warning mcero"><h4>Paciente sin Antecedentes</h4></div>';
} ?>
<?php
mysqli_free_result($RSlcp);
?>