<?php require('../../init.php');
$dat=$_REQUEST;
$resT=0;
if(($dat['tab'])&&($dat['field'])&&($dat['param'])){
	$det=detRow($dat['tab'],$dat['field'],$dat['param'],$dat['ford'],$dat['vord']);
	if($det){
		$resL='Encontrado';
		$resT='1';
		$resV=$det;
	}else{
		$resL='No Encontrado';
	}
}else{
	$resL='No Data';
}
$datos = array( 'rRes' => $resT, 'rVal'=>$det, 'rLog' => $resL);
echo json_encode($datos);
?>