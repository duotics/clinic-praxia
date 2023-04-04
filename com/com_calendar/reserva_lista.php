<?php include('../../init.php');
$query_RSr = "SELECT * FROM db_fullcalendar WHERE est=1 ORDER BY id DESC";
$RSr = mysqli_query(conn,$query_RSr) or die(mysqli_error(conn));
$row_RSr = mysqli_fetch_assoc($RSr);
$totalRows_RSr = mysqli_num_rows($RSr);
include(RAIZf.'head.php');
?>
<title>Lista Reserva Consultas</title>
<body class="cero">
<div class="container">
<div class="page-header">
	<h1>Reservas Consultas <small>Consultas Pendientes</small></h1>
</div>
<?php if ($totalRows_RSr>0){?>
<table id="mytable" class="table table-bordered table-striped table-condensed">
<thead>
	<tr>
    	<th></th>
		<th>Codigo</th>
    	<th>Fecha Hora Reserva</th>
      	<th>Paciente</th>
		<th>Auditoria</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <?php
	$detPac_cod=$row_RSr['pac_cod'];
    $detPac=detRow('db_pacientes','pac_cod',$detPac_cod);
	$detAud_inf=infAud($row_RSr['id_aud']);
	$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
	$btnAcc=NULL;
	if($detPac){
		$btnAcc='<a class="btn btn-default btn-xs" target="_parent" href="'.$RAIZc.'com_consultas/form.php?idp='.$detPac_cod.'">
		Tratar Consulta <i class="fa fa-chevron-right"></i></a>';
	}
	
	?>
    <tr>
    	<td><?php echo $btnAcc ?></td>
		<td><?php echo $row_RSr['id']; ?></td>
		<td><?php echo $row_RSr['fechai']?> <span class="badge"><?php echo $row_RSr['horai'] ?></span></td>
		<td><?php echo $detPac_nom ?></td>
		<td><?php echo $detAud_inf ?></td>
    </tr>
    <?php } while ($row_RSr = mysqli_fetch_assoc($RSr)); ?>    
</tbody>
</table>
<?php
} else {
	echo '<div class="alert alert-block">
	<h4>No hay reservas pendientes!</h4>
	</div>';
} ?>
</div>
</body>
</html>
<?php mysqli_free_result($RSr); ?>