<?php include_once('../../init.php');

use App\Models\Diagnostico;

$mDiag = new Diagnostico;
?>
<?php if ($dCon) { ?>
	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<button class="nav-link active" id="nav-cdet-tab" data-bs-toggle="tab" data-bs-target="#nav-cdet" type="button" role="tab" aria-controls="nav-cdet" aria-selected="true">
				Datos de consulta
			</button>
			<button class="nav-link" id="nav-cexa-tab" data-bs-toggle="tab" data-bs-target="#nav-cexa" type="button" role="tab" aria-controls="nav-cexa" aria-selected="false">
				<i class="fa fa-stethoscope fa-lg"></i> Examen físico
			</button>
		</div>
	</nav>

	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active pt-3" id="nav-cdet" role="tabpanel" aria-labelledby="nav-cexa-tab" tabindex="0">
			<?php include('consultaDetMot.php') ?>
			<?php include('consultaDetDiag.php') ?>
		</div>
		<div class="tab-pane fade pt-3" id="nav-cexa" role="tabpanel" aria-labelledby="nav-cexa-tab" tabindex="0">
			<?php include('consultaDetExamFis.php') ?>
		</div>
	</div>
<?php } else { ?>
	<div class="alert alert-warning">
		<h4>Primero Guarde la Consulta</h4><?php echo $btn_action_form ?? null ?>
	</div>
<?php } ?>