<?php
require_once('../../init.php');
include_once(RAIZf.'headPrint.php') ?>
<div>
    <?php
$dFI=vParam('FI', $_GET['FI'], $_POST['FI'],FALSE);
$dFF=vParam('FF', $_GET['FF'], $_POST['FF'],FALSE);
$qryPR=sprintf('SELECT * FROM db_pacientes WHERE pac_fecr>=%s AND pac_fecr<=%s',
SSQL($dFI,'date'),
SSQL($dFF,'date'));

$RSpr = mysqli_query(conn,$qryPR) or die(mysqli_error(conn));
$row_RSpr = mysqli_fetch_assoc($RSpr);
$tr_RSpr = mysqli_num_rows($RSpr);

$banSR=TRUE;

if(!$dFI||!$dFF){
	$banSR=FALSE;
	$logSR='Debe Seleccionar la FECHA INICIAL y la FECHA FINAL';
}else{
	if($dFI>$dFF){
		$banSR=FALSE;
		$logSR='FECHA INICIAL no puede ser Mayor a la FECHA FINAL';
	}else{
		if($tr_RSpr<=0){
			$banSR=FALSE;
			$logSR='Sin Resultados para Mostrar, seleccione otro rango de fechas';
		}
	}
}


if($banSR==TRUE){
	$GraphGen_name='graph-'.date('Ymd-His').'.jpg';
	$setTitle="REPORTE PROCEDENCIA PACIENTES";
	include_once(RAIZf.'fra_print_header_gen.php')
?>

<div style="margin-top:10px;">
    
    <div class="panel panel-default">
    	<div class="panel-heading" style="text-align:center">Del <?php echo $dFI.' al '.$dFF ?></div>        
    </div>
    
    <div class="panel panel-info">
    	<div class="panel-heading">Listado Pacientes</div>
    </div>

<table style="width:100%;" cellpadding="0" cellspacing="0" border="1" bordercolor="#ddd">
	<tr>
		<th>H.C.</th>
        <th>Fecha Registro</th>
    	<th>Nombres</th>
        <th>Apellidos</th>
		<th>Edad</th>
        <th>Origen Referido</th>
	</tr>
	<?php do{
	$cod_pac=$row_RSpr['pac_cod'];
	$detRef=detRow('db_types','typ_cod',$row_RSpr['publi']);
	?>
    <tr>
		<td style="width:5%"><?php echo $row_RSpr['pac_cod'] ?></td>
        <td style="width:15%"><?php echo $row_RSpr['pac_fecr'] ?></td>
		<td style="width:25%"><?php echo strtoupper($row_RSpr['pac_nom'])?></td>
		<td style="width:25%"><?php echo strtoupper($row_RSpr['pac_ape'])?></td>
		<td style="width:10%"><?php echo edad($row_RSpr['pac_fec']); ?></td>
        <td style="width:20%"><?php echo $detRef['typ_val'] ?></td>
    </tr>
    <?php } while ($row_RSpr = mysqli_fetch_assoc($RSpr)); ?>
</table>
    
    <div class="panel panel-default" style="margin-top:10px;">
    	<div class="panel-heading">Comentarios</div>
        <div class="panel-body" style="padding:15px;">
        	<table style="width:100%">
            	<tr>
                <th style="width:50%">Fecha Generación</th>
                <td><?php echo $sdatet ?></td>
                </tr>
                <tr>
                <th style="width:50%">Responsable</th>
                <td><?php echo $detEmp_fullname//DetEMP movido del mod_navbar al INIT ?></td>
                </tr>
            </table>
        </div>
    </div>
    
</div>

<?php mysqli_free_result($RSpr);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>'.$logSR.'</h4></div>';
} ?>
    
    
</div>