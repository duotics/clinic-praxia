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
LEFT JOIN db_types
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
?>
<div class="well well-sm">
    <ul class="pagination" style="margin:2px;">
            <span class="label label-default">Total Resultados</span> <span class="label label-primary"><?php echo $tr_RSpr ?></span></ul>
    <div class="btn-group pull-right" role="group">
  <a class="btn btn-info btn-sm fancybox fancybox.iframe" href="rep_pacProc_pdf.php?selr=1&FI=<?php echo $dFI ?>&FF=<?php echo $dFF ?>"><i class="fa fa-print fa-lg"></i> Imprimir Reporte</a>
  <a class="btn btn-info btn-sm fancybox fancybox.iframe" href="rep_pacProc_pdf.php?selr=2&FI=<?php echo $dFI ?>&FF=<?php echo $dFF ?>"><i class="fa fa-print fa-lg"></i> Imprimir Listado</a>
</div>
</div>


<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Origenes</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Listado Pacientes</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
    
    <table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
		<th></th>
        <th></th>
        <th>Origen</th>
        <th>Cantidad</th>
	</tr>
</thead>
<tbody> 
	<?php
    	$dataG;
		$contDataG=0;
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
		
	?>
    <tr>
        <td><?php echo $det_typcod ?></td>
        <th><?php echo $det_typicon ?></th>
        <th><?php echo $det_typval ?></th>
        <td><?php echo $det_typcant ?></td>
    </tr>
    <?php } while ($row_RSprs = mysqli_fetch_assoc($RSprs)); ?>
</tbody>
</table>
	<?php include('rep_pacProc_graph.php'); ?>
	<div class="panel panel-info">
	<div class="panel-heading">Grafico</div>
    <div class="panel-body text-center">
        <img src="<?php echo $graph_SetOutputFile ?>" class="">
    </div>
</div>

	</div>
    <div role="tabpanel" class="tab-pane" id="profile"><table id="mytable_cli" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
		<th><abbr title="Historia Clinica">H.C.</abbr></th>
        <th>Fecha Registro</th>
    	<th>Nombres</th>
        <th>Apellidos</th>
		<th>Edad</th>
        <th>Detalle</th>
        <th>Origen Referido</th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$cod_pac=$row_RSpr['pac_cod'];
	$detPac=detRow('db_pacientes','pac_cod',$row_RSpr['pac_cod']);//dPac($row_RSpr['cod_pac']);
	$typ_tsan=dTyp($detPac['pac_tipsan']);$typ_tsan=$typ_tsan['typ_val'];
	$typ_eciv=dTyp($detPac['pac_estciv']);$typ_eciv=$typ_eciv['typ_val'];
	$typ_sexo=dTyp($detPac['pac_sexo']);$typ_sexo=$typ_sexo['typ_val'];
	if($typ_sexo=='Masculino') $classsexo=' label-info';
	if($typ_sexo=='Femenino') $classsexo=' label-women';
	$detRef=detRow('db_types','typ_cod',$row_RSpr['publi']);
	?>
    <tr>
		<td><?php echo $cod_pac ?></td>
        <td><?php echo $detPac['pac_fecr'] ?></td>
		<td><?php echo strtoupper($detPac['pac_nom'])?></td>
		<td><?php echo strtoupper($detPac['pac_ape'])?></td>
        
		<td><?php echo edad($detPac['pac_fec']); ?></td>
        <td>
        <?php //echo "***".$typ_sexo ?>
        <small>
		<?php
		if ($typ_sexo) echo '<span class="label '.$classsexo.'">'.$typ_sexo.'</span> ';
		if ($typ_eciv) echo '<span class="badge">'.$typ_eciv.'</span> ';
		if ($typ_tsan) echo '<span class="badge">'.$typ_tsan.'</span> ';
		?>
		</small></td>
        <td><?php echo $detRef['typ_val'] ?></td>
    </tr>
    <?php } while ($row_RSpr = mysqli_fetch_assoc($RSpr)); ?>
</tbody>
</table></div>
  </div>
</div>
<?php mysqli_free_result($RSpr);?>
<?php }else{
	echo '<div class="alert alert-info"><h4>'.$logSR.'</h4></div>';
} ?>