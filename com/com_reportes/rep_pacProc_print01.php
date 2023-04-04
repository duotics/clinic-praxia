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

$qryPRs=sprintf('SELECT db_types.typ_cod,db_types.typ_val,db_types.typ_icon,COUNT(db_pacientes.pac_cod) AS cant FROM db_pacientes
INNER JOIN db_types
ON db_pacientes.publi=db_types.typ_cod
WHERE db_pacientes.pac_fecr>=%s AND db_pacientes.pac_fecr<=%s
GROUP BY typ_val',
SSQL($dFI,'date'),
SSQL($dFF,'date'));

$RSprs = mysqli_query(conn,$qryPRs) or die(mysqli_error(conn));
$row_RSprs = mysqli_fetch_assoc($RSprs);
$tr_RSprs = mysqli_num_rows($RSprs);

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
    	<div class="panel-heading">Resumen Procedencias</div>
        <div class="panel-body">
        <table style="width:100%;" border="1" bordercolor="#ccc" cellspacing="0" cellpadding="4">
	<tr>
        <th style="width:75%; background:#666; color:#fff; padding-left:10px;">Origen</th>
        <th style="width:25%; background:#666; color:#fff; text-align:center;">Cantidad</th>
	</tr>
	<?php
    	$dataG;
		$contDataG=0;
		$sumVals=0;
		do{
		$det_typcod=$row_RSprs['typ_cod'];
		$det_typval=$row_RSprs['typ_val'];
		$det_typicon='<i class="'.$row_RSprs['typ_icon'].' fa-2x"></i>';
		$det_typcant=$row_RSprs['cant'];
		if(!$det_typcod){ 
			$det_typval='No Determinado';
			$det_typicon='<i class="fa fa-question fa-2x"></i>';
		}
		$dataG[$contDataG]=array($det_typval, $det_typcant);
		$contDataG++;
		$sumVals+=$det_typcant;
		
	?>
    <tr>
        <td style="padding-left:20px;"><?php echo $det_typval ?></td>
        <td style="text-align:center"><?php echo $det_typcant ?></td>
    </tr>
    <?php } while ($row_RSprs = mysqli_fetch_assoc($RSprs)); ?>
    <tr>
        <td style="padding-left:20px; color:#999; background:#ddd;">No Determinado</td>
        <td style="text-align:center; color:#999; background:#ddd;"><?php echo $tr_RSpr-$sumVals ?></td>
    </tr>
    <tr>
        <th style="width:75%; background:#999; color:#eee; padding-left:10px;">TOTAL Pacientes</th>
        <th style="width:25%; background:#999; color:#eee; text-align:center;"><?php echo $tr_RSpr ?></th>
	</tr>
    <tr>
        <th style="width:75%; background:#666; color:#fff; padding-left:10px;">TOTAL Pacientes Nuevos</th>
        <th style="width:25%; background:#666; color:#fff; text-align:center;"><?php echo $sumVals ?></th>
	</tr>
</table>
        </div>
    </div>

	<div class="panel panel-info">
    	<div class="panel-heading">GRAFICO ESTADISTICO</div>
        <div class="panel-body">
        <?php include('rep_pacProc_graph.php'); ?>
	<div style="text-align:center; padding:10px;">
        <img src="<?php echo $graph_SetOutputFile ?>">
    </div>
        </div>
    </div>
    
    <div class="panel panel-default">
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