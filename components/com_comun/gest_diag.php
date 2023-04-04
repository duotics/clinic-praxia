<?php require('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$detDiag = detRow('db_diagnosticos', 'id_diag', $id);
if ($detDiag) {
	$id = $detDiag['id_diag'];
	$action = 'UPD';
	$btn_action = '<button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-floppy-save"></span> Modificar Diagnostico</button>';
	$btn_new = '<a href="' . $urlc . '" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Nuevo Diagnostico</a>';
} else {
	$action = 'INS';
	$btn_action = '<button type="submit" class="btn btn-primary btn-large"><span class="glyphicon glyphicon-floppy-save"></span> Grabar Diagnostico</button>';
}

$qry = 'SELECT * FROM db_diagnosticos ORDER BY id_diag DESC';
$RSd = mysqli_query(conn, $qry);
$row_RSd = mysqli_fetch_assoc($RSd);
$tr_RSd = mysqli_num_rows($RSd);
$css['body'] = 'cero';
include(RAIZf . 'head.php');
?>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Diagnosticos</a>
		</div>
	</div><!-- /.container-fluid -->
</nav>
<div class="container">
	<?php sLOG('g'); ?>
	<div class="well well-sm">
		<form method="post" action="_fncts.php" class="form-inline" role="form">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="ID" value="<?php echo $detDiag['id_diag'] ?? null ?>" disabled>
				<input name="codigo" type="text" autofocus class="form-control" id="codigo" placeholder="Codigo Internacional" value="<?php echo $detDiag['codigo'] ?? null ?>" maxlength="10">
			</div>
			<div class="form-group">
				<input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre Diagnostico" value="<?php echo $detDiag['nombre'] ?? null ?>" maxlength="100" required>
			</div>
			<div class="form-group">
				<input name="form" type="hidden" id="form" value="fdiag">
				<input name="id" type="hidden" id="id" value="<?php echo $id ?>">
				<input name="action" type="hidden" id="action" value="<?php echo $action ?>">
				<?php echo $btn_action ?? null ?>
				<?php echo $btn_new ?? null ?>
			</div>
		</form>
	</div>
	<?php if ($tr_RSd > 0) { ?>
		<table class="table table-striped table-bordered table-condensed">
			<thead>
				<tr>
					<th>ID</th>
					<th>Codigo</th>
					<th>Nombre</th>
					<th><abbr title="Consultas relacionadas">Consultas</abbr></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php do { ?>
					<tr>
						<td><?php echo $row_RSd['id_diag'] ?></td>
						<td><?php echo $row_RSd['codigo'] ?></td>
						<td><?php echo $row_RSd['nombre'] ?></td>
						<td><?php echo totRowsTab('db_consultas_diagostico', 'id_diag', $row_RSd['id_diag']) ?></td>
						<td>
							<div class="btn-group">
								<a href="<?php echo $_SESSION['urlc'] ?>?id=<?php echo $row_RSd['id_diag'] ?>" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-edit"></i> Modificar</a>
								<a href="_fncts.php?id=<?php echo $row_RSd['id_diag'] ?>&action=DEL" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Eliminar</a>
							</div>
						</td>
					</tr>
				<?php } while ($row_RSd = mysqli_fetch_assoc($RSd)); ?>
			</tbody>
		</table>
	<?php } else { ?>
		<div class="alert alert-danger">
			<h4>No Existen Diagnosticos Generados</h4>
		</div>
	<?php } ?>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#con_diagd').chosen({});
	});
</script>

<?php include(RAIZf . 'foot.php') ?>