<?php

use App\Models\Paciente;

$mPac = new Paciente;
$sbr = $_GET['sBr'] ?? $_POST['sBr'] ?? null;
$mPac->setTerm($sbr);
$mPac->getPacList();
$lPac = $mPac->getDetAll();
$objPaginator = new App\Core\genInterfacePaginator($mPac->TR, $mPac->pages->display_pages(), $mPac->pages->display_items_per_page());
?>
<?php if ($sbr) { ?>
	<div class="alert alert-warning alert-dismissible fade show" role="alert">
		Mostrando Su Busqueda: <strong>"<?php echo $sbr ?>"</strong>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php } ?>
<?php if ($lPac) { ?>
	<?php $objPaginator->render() ?>
	<table id="mytable_cli" class="table table-sm table-bordered table-striped table-list">
		<thead>
			<tr>
				<th></th>
				<th><abbr title="Historia Clinica">H.C.</abbr></th>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>Edad</th>
				<th>Detalle</th>
				<th>Contacto</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lPac as $dRSp) { ?>
				<?php
				$btnAcc = null;
				$ids = $dRSp['code'];
				$idp = $dRSp['pac_cod'];
				$typ_tsan = null; //dTyp($dRSp['pac_tipsan']);
				$typ_tsan = null; //$typ_tsan['typ_val'] ?? null;
				$typ_eciv = null; //dTyp($dRSp['pac_estciv']);
				$typ_eciv = null; //$typ_eciv['typ_val'] ?? null;
				$typ_sexo = null; //dTyp($dRSp['pac_sexo']);
				$typ_sexo = null; //$typ_sexo['typ_val'] ?? null;
				if ($typ_sexo == 'Masculino') $classsexo = ' label-info';
				if ($typ_sexo == 'Femenino') $classsexo = ' label-women';
				if ($dataBus['data-url']) {
					$btnAcc = "<a href='{$dataBus['data-url']}?{$dataBus['data-param']}={$ids}' class='btn btn-sm btn-{$dataBus['btn-css']}'>
					<i class='{$dM['iconM']}'></i> {$dataBus['btn-text']}
					</a>";
				} else {
					$btnAcc = "no action";
				}
				?>
				<tr>
					<td><?php echo $btnAcc ?></td>
					<td><?php echo $idp ?></td>
					<td><?php echo strtoupper($dRSp['pac_nom']) ?></td>
					<td><?php echo strtoupper($dRSp['pac_ape']) ?></td>

					<td><?php //echo edad($dRSp['pac_fec']) 
						?></td>
					<td>
						<?php //echo "***".$typ_sexo 
						?>
						<small>
							<?php
							if ($typ_sexo) echo '<span class="label ' . $classsexo . '">' . $typ_sexo . '</span> ';
							if ($typ_eciv) echo '<span class="badge">' . $typ_eciv . '</span> ';
							if ($typ_tsan) echo '<span class="badge">' . $typ_tsan . '</span> ';
							?>
						</small>
					</td>
					<td><?php
						if ($dRSp['pac_lugr']) echo '<abbr title="' . $dRSp['pac_lugr'] . '"><i class="fa fa-globe"></i></abbr> ';
						if ($dRSp['pac_tel1']) echo '<abbr title="' . $dRSp['pac_tel1'] . '"><i class="fa fa-phone"></i></abbr> ';
						if ($dRSp['pac_tel2']) echo '<abbr title="' . $dRSp['pac_tel2'] . '"><i class="fa fa-phone"></i></abbr> ';
						if ($dRSp['pac_email']) echo '<abbr title="' . $dRSp['pac_email'] . '"><i class="fa fa-envelope"></i></abbr> ';
						?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php $objPaginator->render() ?>
<?php } ?>