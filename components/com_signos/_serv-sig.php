<?php require('../../init.php');
$idp=null;
$field=null;
if(isset($_REQUEST['idp'])) $idp=$_REQUEST['idp'];
if(isset($_REQUEST['field'])) $field=$_REQUEST['field'];

$LOG.= 'inicio<br>';

$qS = sprintf("SELECT * FROM db_signos WHERE md5(pac_cod) = %s ORDER BY id ASC",
			 SSQL($idp,'text'));
$RS = mysqli_query(conn,$qS) or die(mysqli_error(conn));
$dRS = mysqli_fetch_assoc($RS);
$tRS = mysqli_num_rows($RS);
$LOG.= $qS.'<br>';
$LOG.= 'Rows. '.$tRS.'<br>'; 
$datos =array();
if($field){
    $LOG.= 'Field found<br>';
	$param['tit']='Historial '.$field;
	do{
        $LOG.= $dRS['fecha'].'-'.$dRS[$field].'<br>';
		//$datos[]=array($dRS['fecha'],(int)$dRS[$field]);
		$data[]=(int)$dRS[$field];
		$labels[]=$dRS['fecha'];
	}while ($dRS = mysqli_fetch_assoc($RS));
}else{
	$param['tit']='Historial IMC / Peso / Talla';
	do{
		$IMC=calcIMC($dRS['imc'],$dRS['peso'],$dRS['talla']);
		$labels[]=$dRS['fecha'];
		$data[]=array((int)$dRS['peso'],(int)$dRS['talla'],$IMC['val']);
	}while ($dRS = mysqli_fetch_assoc($RS));
	$leg[]=array('Peso','Talla','IMC');
	
	//$plot->SetLegend(array('Peso', 'Talla', 'I.M.C'));
	//$plot->SetLegendWorld(0.1, 95);
	//$plot->SetLegendPosition(0.5, 0.5, 'world', 2, 60);
	//$plot->SetLegendPixels(10, 10);
}
//echo $LOG;
echo json_encode(array("idp"=>$idp,"label"=>$param['tit'],"data"=>$data,"labels"=>$labels));
?>