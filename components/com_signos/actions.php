<?php require_once('../../init.php');
if(($_POST['form'])&&($_POST['form']=='hispac')){
	$id=$_POST['id'];
	$fecha=$_POST['hfecha'];
	$peso=$_POST['hpeso'];
	$pa=$_POST['hpa'];
	$talla=$_POST['htalla'];
	$imc=$_POST['himc'];
	$insertSQL = sprintf("INSERT INTO `db_signos`
	(`pac_cod`,`fecha`,`peso`,`pa`,`talla`,`imc`) VALUES (%s,%s,%s,%s,%s,%s)",
		SSQL($id, "int"),
		SSQL($sdate, "date"),
		SSQL($peso, "text"),
		SSQL($pa, "text"),
		SSQL($talla, "text"),
		SSQL($imc, "text")
	);
	$ResultInsert = mysqli_query(conn,$insertSQL) or die(mysqli_error(conn));
}
if(($_GET['action'])&&($_GET['action']=='DEL')){
	$idh=$_GET['idh'];
	$id=$_GET['id'];
	$qryDEL='DELETE FROM `db_signos` WHERE id='.$idh;
	if(@mysqli_query(conn,$qryDEL)) $LOG.="Eliminado Correctamente:: ID = ".$idh;
	else $LOG.='<b>No se pudo Eliminar</b>';
}
header("Location: ".$_SESSION['urlp'].'?id='.$id);
?>


