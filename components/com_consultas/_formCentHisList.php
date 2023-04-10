<?php include('../../init.php');
$idsPac = $_REQUEST['kp'] ?? null;

$mCon = new App\Models\ConsultaInterfaz;
$mPac = new App\Models\Paciente;

$mCon->setIDp($idsPac);
$lConPac = $mCon->getAllConsultasPaciente();
$mPac->setID($idsPac);
$mPac->det();
$dPac = $mPac->getDet();
?>

<?php if ($dPac) { ?>
	<div class="mb-2">
		<p class="lead fw-light"><?php echo $dPac['pac_nom'] . ' ' . $dPac['pac_ape'] ?></p>
	</div>
	<?php if ($lConPac) : ?>
		<?php foreach ($lConPac as $dLC) : ?>
			<?php $LD = $db->detRowL("db_consultas_diagostico", "md5(con_num)", $dLC['con_num'], 2, "id", "ASC");
			$idsRow = md5($dLC['con_num']);
			$btnAcc = "<a href=form.php?kc={$idsRow} class='btn btn-light btn-sm btn-block'>
			<i class='fa fa-eye fa-lg'></i> Ver 
			{$dLC['con_num']} 
			{$dLC['date']}
			</a>";
			?>
			<div class="card mb-4">
				<div class="card-body">
					<?php echo $btnAcc ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="alert alert-info">
			<h5>Sin registros de visita</h5>
		</div>
	<?php endif; ?>

<?php } else { ?>
	<div class="alert alert-warning">
		Paciente no existente <?php echo $idsPac ?>
	</div>
<?php } ?>





<!--
<?php if ($tRSlcp > 0) { ?>
<table class="table table-sm m-0">
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
<?php $contVis = $tRSlcp; ?>
<?php do { ?>
<?php
		//$detDiagCH=detRow('db_diagnosticos','id_diag',$dRSlcp['con_diagd']);

		$qLD = sprintf(
			'SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 2',
			SSQL($dRSlcp['con_num'], 'int')
		);
		$RSld = mysqli_query($conn, $qLD);
		$dRSld = mysqli_fetch_assoc($RSld);
		$tRSld = mysqli_num_rows($RSld);
		$resDiag = NULL;
		if ($tRSld > 0) {
			do {
				if ($dRSld['id_diag'] > 1) {
					$dDiag = detRow('db_diagnosticos', 'id_diag', $dRSld['id_diag']);
					$dDiag_cod = $dDiag['codigo'] . '-';
					$dDiag_nom = $dDiag['nombre'];
				} else {
					$dDiag_cod = NULL;
					$dDiag_nom = $dRSld['obs'];
				}
				$resDiag .= ' <span class="badge badge-light">' . $dDiag_cod . $dDiag_nom . '</span> ';
			} while ($dRSld = mysqli_fetch_assoc($RSld));
		}
?>
	<tr>
  		<td><a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $dRSlcp['con_num']; ?>" class="btn btn-light btn-sm btn-block">
        <i class="fa fa-eye fa-lg"></i> Ver
        </a></td>
		<td class="text-center"><?php echo $contVis; ?></td>
        <td><?php echo $dRSlcp['con_num']; ?></td>
		<td><?php echo $dRSlcp['con_fec']; ?></td>
		<td><?php echo $resDiag ?></td>
	</tr>
<?php $contVis--; ?>
<?php } while ($dRSlcp = mysqli_fetch_assoc($RSlcp)); ?>
</tbody>
</table>
<?php } else { ?>
	<div class="alert alert-warning mcero">
		<h4>Paciente sin Antecedentes</h4>
	</div>
<?php } ?>
<?php mysqli_free_result($RSlcp) ?>
-->