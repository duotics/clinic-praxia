<?php require_once('../../init.php');
$id_pag = "-1";
if (isset($_GET['id_pag'])) { $id_pag = $_GET['id_pag']; }

$query_RS_det_pag = sprintf("SELECT * FROM tbl_pagopac_cab INNER JOIN tbl_pagopac_det ON tbl_pagopac_cab.pag_num=tbl_pagopac_det.pag_num WHERE tbl_pagopac_cab.pag_num=%s", SSQL($id_pag, "int"));
$RS_det_pag = mysqli_query(conn,$query_RS_det_pag) or die(mysqli_error(conn));
$row_RS_det_pag = mysqli_fetch_assoc($RS_det_pag);
$totalRows_RS_det_pag = mysqli_num_rows($RS_det_pag);
$detpac=dataPac($row_RS_det_pag['pac_cod']);
$detpac_nom=$detpac['pac_nom'].' '.$detpac['pac_ape'];
$detemp=dataEmp($row_RS_det_pag['emp_cod']);
$detemp_nom=$detemp['emp_nom'].' '.$detemp['emp_ape'];
include(root['f']."head.php");
?>
<body>
<div class="page-header">
  <h2>Detalle Pago <small>Numero. <strong><?php echo $row_RS_det_pag['pag_num']; ?></strong></small></h2>
</div>
<div class="row-fluid">
	<table class="table table-condensed">
		<tr><td><strong>Paciente</strong></td><td><?php echo $detpac_nom; ?></td></tr>
        <tr><td><strong>Fecha Pago</strong></td><td><?php echo $row_RS_det_pag['pag_fech']; ?></td></tr>
        <tr><td><strong>Valor</strong></td><td>$ <?php echo $row_RS_det_pag['pag_val']; ?></td></tr>
        <tr><td><strong>Responsable</strong></td><td><?php echo $detemp_nom; ?></td></tr>
    </table>
</div>

<table id="mytable" class="table table-striped table-bordered table-condensed">
<thead>
	<tr>
    	<th>Consulta</th>
        <th># Cuenta</th>
        <th>Detalle</th>
        <th>Abono</th>
        <th>ID</th>
    </tr>
</thead>
<tbody>
   	<?php do { ?>
   	  <tr>
   	    <td align="center"><?php echo $row_RS_det_pag['con_num']; ?></td>
   	    <td align="center"><?php echo $row_RS_det_pag['num_cta']; ?></td>
   	    <td><?php echo $row_RS_det_pag['detalle']; ?></td>
   	    <td><?php echo $row_RS_det_pag['abono']; ?></td>
   	    <td><?php echo $row_RS_det_pag['sec_pag']; ?></td>
 	    </tr>
   	  <?php } while ($row_RS_det_pag = mysqli_fetch_assoc($RS_det_pag)); ?>
</tbody>
</table>


<div class="alert"><?php echo $LOG; ?></div>
</body>
</html>
<?php
mysqli_free_result($RS_det_pag);
?>
