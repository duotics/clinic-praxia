<?php include('../../init.php');
$dM=$Auth->vLogin('CONSULTA');
$query_RScl = "SELECT * FROM db_consultas";
$RScl = mysqli_query(conn,$query_RScl) or die(mysqli_error(conn));
$row_RScl = mysqli_fetch_assoc($RScl);
$totalRows_RScl = mysqli_num_rows($RScl);
mysqli_free_result($RScl);

if ($totalRows_RScl>0){
	$pages = new Paginator;
	$pages->items_total = $totalRows_RScl;
	$pages->mid_range = 8;
	$pages->paginate();
	$query_RScl = "SELECT * FROM db_consultas ORDER BY con_num DESC";
	$RScl = mysqli_query(conn,$query_RScl.' '.$pages->limit) or die(mysqli_error(conn));
	$row_RScl = mysqli_fetch_assoc($RScl);
	$totalRows_RScl = mysqli_num_rows($RScl);
}
include(RAIZf.'head.php');
include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
<div class="page-header"><h1>LISTA CONSULTAS <small>Pacientes</small></h1></div>
<?php if($totalRows_RScl>0){ ?>
<table id="myt_listcons" class="table table-bordered table-striped table-condensed">
<thead>
    <tr>
    	<th></th>
        <th>Consulta</th>
        <th><abbr title="Historia Clinica">H. C.</abbr></th>
        <th>Paciente</th>
        <th>Diagnostico</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>
</thead>
<tbody>
	<?php
	do {
	$detpac=detRow('db_pacientes','pac_cod',$row_RScl['pac_cod']);
	$diagd=detRow('db_diagnosticos','id_diag',$row_RScl['con_diagd']);
	$stat=estCon($row_RScl['con_stat']);
	?>
	  <tr>
	    <td><a href="form.php?idc=<?php echo $row_RScl['con_num'] ?>" class="btn btn-primary btn-xs">
        <i class="fa fa-eye fa-lg"></i> Ver</a>
        </td>
	    <td align="center"><?php echo $row_RScl['con_num']; ?></td>
        <td align="center"><?php echo $row_RScl['pac_cod']; ?></td>
	    <td><small><?php echo $detpac['pac_nom'].' '.$detpac['pac_ape']; ?></small></td>
        <td><?php echo $diagd['nombre'] ?></td>
	    <td><?php echo $row_RScl['con_fec']; ?></td>
	    <td><?php echo $stat['txt'] ?></td>
      </tr>
	  <?php } while ($row_RScl = mysqli_fetch_assoc($RScl)); ?>
</tbody>
</table>
<div class="well well-sm">
<div class="row">
    	<div class="col-sm-8">
        	<div><ul class="pagination" style="margin:2px;"><?php echo $pages->display_pages(); ?></ul></div>
    	</div>
        <div class="col-sm-4"><?php echo '<div>'.$pages->display_items_per_page()."</div>"; ?></div>
    </div>
</div>
<?php
mysqli_free_result($RScl);
}else{
	echo '<div class="alert"><strong>No Existen Registro de Consultas</strong></div>';
} ?>
</div>
</body>
</html>