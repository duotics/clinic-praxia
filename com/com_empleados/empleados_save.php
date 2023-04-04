<?php require('../../init.php');

$action=$_GET['action'] ?? $_POST['action'] ?? null;
$urlreturn=$_SESSION['urlp'];

$id=$_POST['id_input'];
$ced_emp=$_POST['ced_emp'];
$nom_emp=$_POST['nom_emp'];
$ape_emp=$_POST['ape_emp'];
$dir_emp=$_POST['dir_emp'];
$tel_emp=$_POST['tel_emp'];
$cel_emp=$_POST['cel_emp'];
$mail_emp=$_POST['mail_emp'];

mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion

if(($action)&&($action=='DEL')){
	$LOG=NULL;
	$id=$_GET['id'];	
	$qryDEL = sprintf("UPDATE db_empleados SET emp_status=%s WHERE emp_cod=%s",
	SSQL('E', "text"),
	SSQL($id, "int"));			
	if(@mysqli_query(conn,$qryDEL)) $LOG.="<p>Recurso Eliminado</p>";
	else $LOG.='<p>No se pudo Eliminar</p>';
	$urlreturn.='?id='.$id;
}
//estado empleados A=activo, E=eliminado
if(($_POST['form'])&&($_POST['form']=='fmed')){
	if($action=='INS'){
		$insertSQL = sprintf("INSERT INTO db_empleados
		(emp_ced,emp_nom,emp_ape,emp_dir,emp_tel,emp_cel,emp_mail,emp_status) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",
		SSQL($ced_emp, "text"),		
		SSQL($nom_emp, "text"),
		SSQL($ape_emp, "text"),
		SSQL($dir_emp, "text"),
		SSQL($tel_emp, "text"),
		SSQL($cel_emp, "text"),
		SSQL($mail_emp, "text"),
		SSQL('A', "text"));
		if(mysqli_query(conn,$insertSQL)){
			$LOG.='<p>Recurso Creado</p>';
		}else{
			$LOG.= '<p>Error al Crear Recurso</p>';
		}
	}
				
	if($action=='UPD'){
		$updSQL = sprintf("UPDATE db_empleados SET emp_nom=%s, emp_ape=%s, emp_dir=%s, emp_tel=%s, emp_cel=%s, emp_mail=%s WHERE emp_cod=%s",
		SSQL($nom_emp, "text"),
		SSQL($ape_emp, "text"),
		SSQL($dir_emp, "text"),
		SSQL($tel_emp, "text"),
		SSQL($cel_emp, "text"),
		SSQL($mail_emp, "text"),
		SSQL($id, "int"));
	if(mysqli_query(conn,$updSQL)) $LOG.='<p>Recurso Actualizado</p>';
	else $LOG.= '<h4>Error al Actualizar Recurso</h4>';
	}
}
$LOG.=mysqli_error(conn);
if(!mysqli_error(conn)){
	mysqli_query(conn,"COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysqli_query(conn,"ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $urlreturn));
?>