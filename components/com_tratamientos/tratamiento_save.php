<?php require('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$urlr='gest_tratamiento.php';
$det=$_POST;

mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion
if(($acc)&&($acc=='DEL')){
	$qry=sprintf('DELETE FROM db_terapiastrata WHERE id_trat=%s',
	SSQL($id,'int'));
	if(@mysqli_query(conn,$qry)) $LOG.="<h4>Eliminado Correctamente</h4>";
	else $LOG.='<h4>Error al Eliminar</h4>';
}
if(($_POST['form'])&&($_POST['form']=='fTtrat')){
	if($acc=='INS'){
		$qry = sprintf("INSERT INTO db_terapiastrata (nom_trat, obs_trat) VALUES (%s,%s)",
		SSQL($det['nom_trat'], "text"),
		SSQL($det['des_trat'], "text"));
		if(mysqli_query(conn,$qry)) $LOG.='<h4>Creado Correctamente</h4>';
		else $LOG.= '<h4>Error al Crear</h4>';
	}
	if($acc=='UPD'){
		$qry = sprintf("UPDATE db_terapiastrata SET nom_trat=%s, obs_trat=%s WHERE id_trat=%s",
		SSQL($det['nom_trat'], "text"),
		SSQL($det['des_trat'], "text"),
		SSQL($id, "int"));
		if(mysqli_query(conn,$qry)) $LOG.='<h4>Actualizado Correctamente</h4>';
		else $LOG.= '<h4>Error al Actualizar</h4>';
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
header(sprintf("Location: %s", $urlr));
?>