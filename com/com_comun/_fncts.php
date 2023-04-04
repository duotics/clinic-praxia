<?php require('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$action=$_GET['action'] ?? $_POST['action'] ?? null;
$urlreturn=$_SESSION['urlp'];
$exec=TRUE;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=$_GET['id'];
	$num_diagcon=totRowsTab('db_consultas_diagostico','id_diag',$id);
	if($num_diagcon>0){
		$LOG.='<p>No se pudo Eliminar</p>Existen Consultas relacionadas a este diagnostico';
		$exec=FALSE;
	}else{
		$qryDEL=sprintf('DELETE FROM `db_diagnosticos` WHERE id_diag=%s',
		SSQL($id,'int'));
		if(@mysqli_query(conn,$qryDEL)) $LOG.="<p>Diagnostico Eliminado Correctamente</p>";
		else{
			$LOG.='<p>No se pudo Eliminar</p>';
			$exec=FALSE;
		}
	}
	$urlreturn.='?id='.$id;
}
if(($_POST['form'])&&($_POST['form']=='fdiag')){
	$codigo=$_POST['codigo'];
	$nombre=$_POST['nombre'];
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO `db_diagnosticos`
		(`codigo`,`nombre`) VALUES (%s,%s)",
		SSQL($codigo, "text"),
		SSQL($nombre, "text"));
		if(mysqli_query(conn,$insertSQL)){
			$LOG.='<p>Diagnostico Creado Correctamente</p>';
		}else{
			$LOG.= '<p>Error. No se pudo crear Diagnostico</p>';
			$exec=FALSE;
		}
	}
	if($action=='UPD'){
		$updSQL = sprintf("UPDATE `db_diagnosticos` SET	`codigo`=%s,`nombre`=%s WHERE id_diag=%s",
		SSQL($codigo, "text"),
		SSQL($nombre, "text"),
		SSQL($id, "int"));
		if(mysqli_query(conn,$updSQL)) $LOG.='<p>Diagnostico Actualizado Correctamente</p>';
		else{
			$LOG.= '<p>Error. No se pudo actualizar Diagnostico</p>';
			$exec=FALSE;
		}
	}
}
if((!mysqli_error(conn))&&($exec==TRUE)){
	mysqli_query(conn,"COMMIT;");
	$LOGt.='Operación Ejecutada Exitosamente';
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$cfg['p']['i-ok'];
}else{
	mysqli_query(conn,"ROLLBACK;");
	$LOGt.='Fallo del Sistema';
	$LOG.=mysqli_error(conn);
	$LOGc=$cfg['p']['c-fail'];
	$LOGi=$RAIZa.$cfg['p']['i-fail'];
}
mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysqli_error(conn);
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlreturn));
?>