<?php include('../../init.php');
$id=$_REQUEST['id'];
$fi=$_REQUEST['start'];
$ff=$_REQUEST['end'];

$fi=explode('T',$fi);
$ff=explode('T',$ff);
$fi_fec=$fi[0];
$fi_hor=$fi[1];
$ff_fec=$ff[0];
$ff_hor=$ff[1];

$qryUpd=sprintf('UPDATE db_fullcalendar SET fechai=%s, fechaf=%s, horai=%s, horaf=%s WHERE id=%s',
	GetSQLValueString($fi_fec,'date'),
	GetSQLValueString($ff_fec,'date'),
	GetSQLValueString($fi_hor,'text'),
	GetSQLValueString($ff_hor,'text'),
	GetSQLValueString($id,'int'));
if(mysql_query($qryUpd)){
	$LOG.='Datos Guardados';
	$res=TRUE;
}else{
	$LOG.='Error Actualizar. ';
	$LOG.=mysql_error();
	$res=FALSE;
}
echo json_encode( array( "cod"=>$id,"res"=>$res,"inf"=>$LOG) );
?>