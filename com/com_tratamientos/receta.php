<?php include_once('../../init.php');
$dettrat=detRow('db_tratamientos','tid',$idt);//fnc_datatrat($idt);
$detCon=detRow('db_consultas','con_num',$dettrat['con_num']);//fnc_datatrat($idt);
//$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dPac($dettrat['pac_cod']);
$dPac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);
$dettrat_fecha=date_ame2euro($dettrat['fecha']);
if($dettrat){
	$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s',
				SSQL($dettrat['con_num'],'int'));
	$RSld=mysqli_query(conn,$qLD);
	$dRSld=mysqli_fetch_assoc($RSld);
	$tRSld=mysqli_num_rows($RSld);
}
?>

<style type="text/css">
table{ width:  100%; border: solid 1px #5544DD; border-collapse: collapse;}
table.tabMin{ font-size: 11px; }
table.tabHead{ margin-top: 125px; border: 0px none; border-collapse: collapse;}
table.tabHead tr th{background: #fff; border: 0px none; border-color: #fff; padding: 0;}
table.tabHead tr td{background: #fff; border: 0px none; border-color: #fff; padding: 0;}

table.tabClear{ border: 0px none; border-collapse: collapse;}
table.tabClear tr th{background: #fff; border: 0px none; border-color: #fff;}
table.tabClear tr td{background: #fff; border: 0px none; border-color: #fff;}

table.tabDiag{margin-top: 10px;}
	
table.tabCont{}
table.tabCont tr th{background: #D6CEF1; font-size: 15px;}
table.tabCont tr td{padding: 4px 8px;}
th, td{ border: 1px solid #ccc; padding: 3px 4px; min-height: 15px;}
tr.trMini{ font-size: 9px;}
td.tdMini, th.tdMini{font-size: 10px;}
td.tdMiniA, th.tdMiniA{font-size: 9px;}
td.tdMiniB, th.tdMiniB{font-size: 8px;}
td.tdMiniC, th.tdMiniC{font-size: 7px;}
tr.trAux{background: #E4E9F7; vertical-align: middle;}
.receta{ background:#FFF; font-size: 11px;}
	
	.text-center{text-align: center}
	.text-right{text-align: right}
	.divider{border: 1px solid #eee;}
</style>

<page class="receta">
	<!-- ENCABEZADO -->
	<table class="tabMin tabHead tabClear">
		<col style="width: 10%" class="col1">
    	<col style="width: 40%">
    	<col style="width: 14%">
    	<col style="width: 36%">
		<tr>
			<td></td>
			<td><?php echo $dettrat_fecha ?> <strong>Ficha. <?php echo $detCon['pac_cod'] ?></strong></td>
			<td></td>
			<td><?php echo $dettrat_fecha ?> <strong>Ficha. <?php echo $detCon['pac_cod'] ?></strong></td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
			<td></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
		</tr>
		<tr>
			<td></td>
			<td>Documento Identidad. <?php echo $dPac['pac_ced'] ?></td>
			<td></td>
			<td>Documento Identidad. <?php echo $dPac['pac_ced'] ?></td>
		</tr>
	</table>
	<!-- DIAGNOSTICOS -->
	<?php if($tRSld>0){ ?>
	<?php do{
		if($dRSld[id_diag]>1){
			$dDiag=detRow('db_diagnosticos','id_diag',$dRSld[id_diag]);
			$dDiag_cod=$dDiag[codigo];
			$dDiag_nom=$dDiag[nombre];
		}else{
			$dDiag_cod=NULL;
			$dDiag_nom=$dRSld[obs];
		}
		
		$resDiag.='<tr>';
		$resDiag.='<td>'.$dDiag_cod.'</td>';
		$resDiag.='<td>'.$dDiag_nom.'</td>';
		$resDiag.='<td></td>';
		$resDiag.='<td>'.$dDiag_cod.'</td>';
		$resDiag.='<td>'.$dDiag_nom.'</td>';
		$resDiag.='</tr>';
	
	}while($dRSld=mysqli_fetch_assoc($RSld));
	?>
	<table class="tabMinA tabDiag tabClear">
		<col style="width: 5%" class="col1">
    	<col style="width: 43%">
    	<col style="width: 4%">
    	<col style="width: 5%">
    	<col style="width: 43%">
		<?php echo $resDiag ?>
	</table>
	<?php } ?>
	<!-- MEDICAMENTOS -->
	
	<div class="divider"></div>
	
    <?php
    //$qrytl=sprintf('SELECT * FROM db_tratamientos_detalle WHERE tid=%s AND tip="M" ORDER BY id ASC',
	//SSQL($idt,'int'));
	$qrytl=sprintf('SELECT * FROM db_tratamientos_detalle WHERE tid=%s ORDER BY tip DESC',
	SSQL($idt,'int'));
	$RStl=mysqli_query(conn,$qrytl);
	$dRStl=mysqli_fetch_assoc($RStl);
	$tRStl=mysqli_num_rows($RStl);
	$contmed=1;
	$contind=1;
	if($tRStl>0){
		do{
			if($dRStl[tip]=='M'){
				$resReceta.='<tr>';
				$resReceta.='<td>•</td>';
				$resReceta.='<td><strong>'.$dRStl[generico].' ('.$dRStl[comercial].') '.$dRStl[presentacion].' - # '.$dRStl[numero].'</strong></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td>•</td>';
				$resReceta.='<td><strong>'.$dRStl[generico].' ('.$dRStl[comercial].') '.$dRStl[presentacion].' - # '.$dRStl[numero].'</strong><br>'.$dRStl[descripcion].'</td>';
				$resReceta.='</tr>';
			}
			if($dRStl[tip]=='I'){
				if($contind==1){
					$resReceta.='<tr>';
					$resReceta.='<td></td>';
					$resReceta.='<td></td>';
					$resReceta.='<td></td>';
					$resReceta.='<td colspan="2"><div class="divider"></div><strong>INDICACIONES</strong></td>';
					$resReceta.='</tr>';
				}
				$resReceta.='<tr>';
				$resReceta.='<td></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td></td>';
				$resReceta.='<td>'.$dRStl[indicacion].'</td>';
				$resReceta.='</tr>';
				$contind++;
			}
			$contmed++;
		}while ($dRStl = mysqli_fetch_assoc($RStl));
	}
	?>
	<?php
	if($detCon[con_diapc]){
		$nuevafecha = strtotime('+'.intval($detCon[con_diapc]).' day',strtotime($sdate));
		$verifPrx=date('w',$nuevafecha);
		if($verifPrx==6) $addDayS=$addDayS+2;
		else if($verifPrx==0) $addDayS++;
		if($addDayS){
			$fechaProcesa=date('Y-m-j' ,$nuevafecha );
			$nuevafecha = strtotime('+'.intval($addDayS).' day',strtotime($fechaProcesa));
		}
		setlocale(LC_ALL,"es_ES");
		$nuevafecha = date ( 'Y-m-d', $nuevafecha );
		$nuevafecha = strftime("%A %d de %B del %Y", strtotime($nuevafecha));
		//$finalfecha=strftime("%A %d de %B del %Y",strtotime($nuevafecha));
		
	}
	$proxima.='<strong>PROXIMA VISITA. '.$nuevafecha.'</strong>';
	if($detCon[con_typvisP]){
		$detTyp=detRow('db_types','typ_cod',$detCon[con_typvisP]);
		$proxima.='<br>Tipo Visita. <strong>'.$detTyp['typ_val'].'</strong>';
	}
	?>
	<div style="height: 450px; display: block">
	<table class="tabMinB tabDet tabClear">
		<col style="width: 5%" class="col1">
    	<col style="width: 43%">
    	<col style="width: 4%">
    	<col style="width: 4%">
    	<col style="width: 44%">
		<?php echo $resReceta ?>
	</table>
	</div>
	<table class="tabMinA tabClear">
		<col style="width: 5%" class="col1">
    	<col style="width: 43%">
    	<col style="width: 4%">
    	<col style="width: 5%">
    	<col style="width: 43%">
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><?php echo $proxima ?></td>
		</tr>
	</table>
</page>