<?php require_once('../../init.php');
if($_SESSION['refresh']=='ok'){
	$_SESSION['refresh']=null;
	$insertGoTo = 'pagos_pendientes.php';//REDIRECCION A LA MISMA PAGINA
	header(sprintf("Location: %s", $insertGoTo));
}

$query_RS_cta_pend = "SELECT DISTINCT  db_pacientes.pac_cod, db_pacientes.pac_nom, db_pacientes.pac_ape, (SELECT  SUM(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=db_pacientes.pac_cod) AS Deuda FROM db_pacientes WHERE (SELECT  SUM(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono)  FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=db_pacientes.pac_cod)>0";
$RS_cta_pend = mysqli_query(conn,$query_RS_cta_pend) or die(mysqli_error(conn));
$row_RS_cta_pend = mysqli_fetch_assoc($RS_cta_pend);
$totalRows_RS_cta_pend = mysqli_num_rows($RS_cta_pend);
include(root['f'].'head.php');
?>
<body class="cero">

<div class="container">

<div class="page-header"><h1>PAGOS PENDIENTES</h1></div>

<?php if($totalRows_RS_cta_pend>0){ ?>
<table id="mytable" class="table table-condensed table-bordered">
<thead>
	<tr>
    	<th></th>
    	<th>ID</th>
        <th>Apellidos</th>
        <th>Nombres</th>
		<th>Deuda</th>
	</tr>
</thead>
<tbody> 
	<?php do { ?>
    <tr>
    	<td align="center">
        <a href="pagos_form.php?id_pac=<?php echo $row_RS_cta_pend['pac_cod']; ?>"><i class="icon-th"></i></a>           </td>
		<td><?php echo $row_RS_cta_pend['pac_cod']; ?></td>
        <td><?php echo $row_RS_cta_pend['pac_ape']; ?></td>
		<td><?php echo $row_RS_cta_pend['pac_nom']; ?></td>
		<td><strong><?php echo $row_RS_cta_pend['Deuda']; ?></strong></td>
    </tr>
    <?php } while ($row_RS_cta_pend = mysqli_fetch_assoc($RS_cta_pend)); ?>    
</tbody>
</table>
<?php }else{ ?>
<div class="alert">No Se Encontraron Pagos Pendientes !!!</div>
<?php } ?>

</div>

</body>


<?php mysqli_free_result($RS_cta_pend) ?>