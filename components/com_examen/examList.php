<?php

use App\Models\Examen;

$mExam = new Examen();

$lExam=$mExam->getAllDet();

$idTyp = $_GET['typ'] ?? $_POST['typ'] ?? NULL;
if ($idTyp) $param = ' WHERE typ_cod=' . $idTyp;
else $param = null;

?>
<div class="well well-sm">
	<fieldset class="form-inline">
		<span class="label label-primary">Resultados <?php echo $totalRows_RSt ?></span>
		<span class="label label-default">Filtros</span>
		<div class="form-group">
			<label for="typ_cod">Tipo Examen</label>
			<?php genSelect('typ_cod', detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPEXAM'), $idTyp, ' form-control input-sm', NULL, NULL, 'Todos'); ?>
		</div>
	</fieldset>
</div>
<?php if ($lExam) { ?>
	<table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Formato</th>
				<th><abbr title="Fecha Registro">Fecha R.</abbr></th>
				<th><abbr title="Fecha Examen">Fecha E.</abbr></th>
				<th><abbr title="Historia Clinica">H.C.</abbr></th>
				<th>Paciente</th>
				<th>Descripcion</th>
				<th style="width:30%">Resultado</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lExam as $row_RSd) { ?>
					<td><?php echo $row_RSd['id']; ?></td>
					<td><?php echo $row_RSd['format'] ?></td>
					<td><?php echo $row_RSd['fecr'] ?></td>
					<td><?php echo $row_RSd['fece'] ?></td>
					<td><?php echo $row_RSd['idp'] ?></td>
					<td><?php echo strtoupper($row_RSd['pac']) ?></td>
					<td><?php echo $row_RSd['res']; ?></td>
					<td>
						<div class="readmore"><?php echo $row_RSd['res']; ?></div>
					</td>
					<td class="text-center">
						<a class="btn btn-info btn-xs fancyreload fancybox.iframe" href="<?php echo route['c'] ?>com_examen/examenForm.php?ide=<?php echo $row_RSd['id']; ?>">
							<i class="fa fa-heart fa-lg"></i> Editar</a>

						<a class="btn btn-default btn-xs" href="gest.php?id=<?php echo $row_RSd['idp']; ?>">
							<i class="fa fa-history"></i> Historial</a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else { ?>
	<div class="alert alert-warning">
		<h4>Sin Coincidencias de Busqueda</h4>
	</div>
<?php } ?>
<script type="text/javascript">
	$("#typ_cod").change(function() {
		window.location.href = "?typ=" + $("#typ_cod").val();
		//alert("The text has been changed.");
	});
</script>