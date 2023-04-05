<?php
$ids = null; //pac_cod
$idh = null;
$idp = null;
$acc = null;
$dPac_edad = null;
if (isset($_REQUEST['ids'])) $ids = $_REQUEST['ids'];
if (isset($_REQUEST['idh'])) $idh = $_REQUEST['idh'];
if (isset($_REQUEST['acc'])) $acc = $_REQUEST['acc'];
$dPac = detRow('db_pacientes', 'md5(pac_cod)', $ids);
if ($dPac) {
	$idp = $dPac['pac_cod'];
	$ids = md5($dPac['pac_cod']);
}
if (isset($dPac['pac_fec'])) $dPac_edad = edad($dPac['pac_fec']) . 'Años';
include(root['f'] . 'head.php'); ?>
<?php
$cont = '<span class="label label-default">' . $dPac['pac_nom'] . ' ' . $dPac['pac_ape'] . '</span>
<span class="label label-default">' . $idp . '</span>
<span class="label label-default"></span>';
?>
<div class="container-fluid">
	<?php echo genHeader($dM, 'page-header', $cont); ?>
	<?php include('_gestSigForm.php') ?>
	<?php if ($dPac) {
		$qry = sprintf(
			'SELECT * FROM db_signos WHERE md5(pac_cod)=%s ORDER BY id DESC',
			SSQL($ids, 'text')
		);
		$RSh = mysqli_query(conn, $qry);
		$dRSh = mysqli_fetch_assoc($RSh);
		$tRSh = mysqli_num_rows($RSh);
	?>
		<?php if ($tRSh > 0) { ?>
			<table class="table table-striped table-sm table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Fecha</th>
						<th>Peso <a href="grafico.php?idp=<?php echo $ids ?>&field=peso" class="btn btn-xs btn-default fancybox fancybox.iframe fancyreload" data-type="iframe"><i class="fa fa-chart-bar"></i></a></th>
						<th>Talla <a href="grafico.php?idp=<?php echo $ids ?>&field=talla" class="btn btn-xs btn-default fancybox fancybox.iframe fancyreload" data-type="iframe"><i class="fa fa-chart-bar"></i></a></th>
						<th>IMC <a href="grafico.php?idp=<?php echo $ids ?>&field=imc" class="btn btn-xs btn-default fancybox fancybox.iframe fancyreload" data-type="iframe"><i class="fa fa-chart-bar"></i></a></th>
						<th>PA <a href="grafico.php?idp=<?php echo $ids ?>&field=pa&type=bar" class="btn btn-xs btn-default fancybox fancybox.iframe fancyreload" data-type="iframe"><i class="fa fa-chart-bar"></i></a></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php do { ?>
						<?php
						$valSig['peso'] = convSig($dRSh['peso'], 'peso');
						$valSig['talla'] = convSig($dRSh['talla'], 'talla');
						$IMC = calcIMC($dRSh['imc'], $dRSh['peso'], $dRSh['talla']);
						?>
						<tr>
							<td><?php echo $dRSh['id'] ?></td>
							<td><?php echo $dRSh['fecha'] ?></td>
							<td><?php echo $valSig['peso']['peso-kg'] ?> <span class="label label-default"><?php echo $valSig['peso']['peso-lb'] ?></span></td>
							<td><?php echo $valSig['talla']['talla-cm'] ?> <span class="label label-default"><?php echo $valSig['talla']['talla-pl'] ?></span></td>
							<td><?php echo $IMC['val'] . ' ' . $IMC['inf']; ?></td>
							<td><?php echo $dRSh['paS'] . '/' . $dRSh['paD'] ?></td>
							<td>
								<a href="<?php echo $urlc; ?>?ids=<?php echo $ids ?>&idh=<?php echo $dRSh['id'] ?>" class="btn btn-info btn-xs">
									<?php echo $cfg['btn']['editI'] . ' ' . $cfg['btn']['editT'] ?>
								</a>
								<a href="_acc.php?idp=<?php echo $idp ?>&idh=<?php echo $dRSh['id'] ?>&acc=<?php echo md5('delS') ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
									<?php echo $cfg['btn']['delI'] . ' ' . $cfg['btn']['delT'] ?>
								</a>
							</td>
						</tr>
					<?php } while ($dRSh = mysqli_fetch_assoc($RSh));
					$rows = mysqli_num_rows($RSh);
					if ($rows > 0) {
						mysqli_data_seek($RSh, 0);
						$dRSh = mysqli_fetch_assoc($RSh);
					} ?>
				</tbody>
			</table>
		<?php } else { ?>
			<div class="alert alert-info">
				<h4>No Existen Registros</h4>
			</div>
		<?php } ?>
	<?php mysqli_free_result($RSh);
	} else { ?>
		<div class="alert alert-warning">
			<h4>Paciente No Existe</h4>
		</div>
	<?php } ?>
</div>