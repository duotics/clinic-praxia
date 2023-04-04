<?php require('../../init.php');

use App\Models\Examen;
use App\Models\Paciente;
use App\Models\Signo;

$mExam = new Examen();
$mPac = new Paciente();
$mSig = new Signo();

$id = $_GET['id'] ?? $_POST['id'] ?? null;

$mExam->setId(md5($id));
$mExam->det();
$dExam = $mExam->det;

if ($dExam) {
	$mPac->setId(md5($dExam['pac_cod']));
	$mPac->det();
	$dPac = $mPac->det;

	$mSig->detParam('pac_cod', $dExam['pac_cod']);
	$dSig = $mSig->det;
}

$css['body'] = 'cero';
include(RAIZf . 'head.php'); ?>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				Vista Previa de Examen <span class="badge"><?php echo $id ?></span>
				<small><?php echo "{$dPac['pac_nom']} {$dPac['pac_ape']}" ?></small>
			</h3>
		</div>
		<div class="panel-body">
			<?php if ($dExam) { ?>
				<table class="table">
					<tr>
						<td width="10%"></td>
						<td width="40%">
							<table class="table cero">
								<tr>
									<td><?php echo $dExam['fecha'] ?></td>
									<td>Ficha. <?php echo $dExam["pac_cod"] ?></td>
								</tr>
								<tr>
									<td colspan="2"><?php echo "{$dPac['pac_nom']} {$dPac['pac_ape']}" ?></td>
								</tr>
							</table>
						</td>
						<td width="15%"></td>
						<td width="35%">
							<table class="table cero">
								<tr>
									<td><?php echo $dPac['pac_fec'] ?></td>
								</tr>
								<tr>
									<td><?php echo "Peso. {$dSig['peso']} / Talla. {$dSig['talla']}" ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php echo $dExam['des'] ?>
			<?php } ?>
		</div>
	</div>
</div>
<?php include(RAIZf . 'footerC.php') ?>