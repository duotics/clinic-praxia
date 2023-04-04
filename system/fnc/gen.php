<?php require('../../init.php');
$data=$_REQUEST;
switch($data['acc']){
	case 'FechaToEdad':
		//$val=edad($data['val']).' Años';
		$val=edadC($data['val']);
	break;
}
echo json_encode( array( "id"=>$id,"val"=>$val,"log"=>$LOG));
?>