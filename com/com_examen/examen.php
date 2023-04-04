<?php include_once('../../init.php');
$dExa=detRow('db_examenes','id_exa',$id);//fnc_datatrat($idt);
$detCon=detRow('db_consultas','con_num',$dExa['con_num']);//fnc_datatrat($idt);
//$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dPac($dExa['pac_cod']);
$dPac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);
$dExa_fecha=date_ame2euro($dExa['fechae']);
if($dExa){
	$qLD=sprintf('SELECT * FROM db_consultas_diagostico WHERE con_num=%s',
				SSQL($dExa['con_num'],'int'));
	//echo $qLD.'<br>';
	$RSld=mysqli_query(conn,$qLD);
	$dRSld=mysqli_fetch_assoc($RSld);
	$tRSld=mysqli_num_rows($RSld);
	
	$qlED=sprintf('SELECT db_examenes_det.res as eRes, db_examenes_format_det.nom as eNom
	FROM db_examenes_det 
	INNER JOIN db_examenes_format_det ON db_examenes_det.idefd=db_examenes_format_det.id
	WHERE db_examenes_det.ide=%s',
				SSQL($id,'int'));
	//echo $qlED.'<br>';
	$RSled=mysqli_query(conn,$qlED);
	$dRSled=mysqli_fetch_assoc($RSled);
	$tRSled=mysqli_num_rows($RSled);
	
	//echo $qlED.'-'.$tRSled;
	
	$dPac_edad=edad($dPac['pac_fec']);
	
	$dPacSig=detSigLast($detCon[pac_cod]);
}
?>

<style type="text/css">
table{ width:  100%; border: solid 1px #5544DD; border-collapse: collapse;}
table.tabMin{ font-size: 11px; }
table.tabHead{ margin-top: 120px; border: 0px none; border-collapse: collapse;}
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

<page class="examen">
	<!-- ENCABEZADO -->
	<table class="tabMin tabHead tabClear">
		<col style="width: 10%" class="col1">
    	<col style="width: 40%">
    	<col style="width: 14%">
    	<col style="width: 36%">
		<tr>
			<td></td>
			<td><?php echo $dExa_fecha ?> <strong>Ficha. <?php echo $detCon['pac_cod'] ?></strong></td>
			<td></td>
			<td><strong>F.Nac. <?php echo $dPac['pac_fec'] ?></strong> - <?php echo $dPac_edad ?> años</td>
		</tr>
		<tr>
			<td></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
			<td></td>
			<td>
				<span title="Peso" class="badge tooltips"><?php echo $dPacSig['peso'] ?> Kg.</span> 
				<span title="Estatura"  class="badge tooltips"><?php echo $dPacSig['talla'] ?> cm.</span> 
			</td>
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
	<!-- EXAMENES -->
	
	<div class="divider"></div>    
	<!-- SUBTIPOS EXAMEN -->
	<?php if($tRSled>0){ ?>
	<?php do{ ?>
	<?php
		$resED.='<tr>';
		$resED.='<td></td>';
		$resED.='<td style="text-align:center">'.$dRSled['eNom'].'</td>';
		$resED.='<td></td>';
		$resED.='</tr>';
	
	}while($dRSled=mysqli_fetch_assoc($RSled));
	?>
	<table class="tabMinA tabDiag tabClear">
		<col style="width: 15%" class="col1">
    	<col style="width: 70%">
    	<col style="width: 15%">
		<?php echo $resED ?>
	</table>
	<?php } ?>
	
	<?php if($dExa[des]){ ?>
	<div style="padding: 20px;">
		<?php echo $dExa[des] ?>
	</div>
	<?php } ?>
	
</page>