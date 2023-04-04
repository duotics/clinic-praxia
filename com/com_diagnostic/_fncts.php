<?php require('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$goTo=$_GET['url'] ?? $_POST['url'] ?? null;
$LOG=NULL;
$data=$_POST;
$vD=FALSE;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion
/**************************************/
/**************************************/
$LOGd='acc. '.$acc.'<br>';
if(($_POST['form'])&&($_POST['form']==md5('fdiag'))){
	$codigo=$_POST['codigo'];
	$nombre=$_POST['nombre'];
	if($acc==md5('INSd')){
		$qry=sprintf("INSERT INTO db_diagnosticos (codigo,nombre,ref,val) VALUES (%s,%s,%s,%s)",
					 SSQL($data[codigo], 'text'),
					 SSQL($data[nombre], 'text'),
					 SSQL($data[val], 'text'),
					 SSQL($data[ref], 'text'));
		if(@mysqli_query(conn,$qry)){
			$vP=TRUE;
			$LOG.='<p>Diagnostico Creado Correctamente</p>';
		}else $LOG.= '<p>Error. No se pudo crear Diagnostico</p>'.mysqli_error(conn);
	}
	if($acc==md5('UPDd')){
		$qry=sprintf("UPDATE db_diagnosticos SET codigo=%s, nombre=%s, val=%s, ref=%s WHERE id_diag=%s",
					 SSQL($data[codigo], 'text'),
					 SSQL($data[nombre], 'text'),
					 SSQL($data[val], 'text'),
					 SSQL($data[ref], 'text'),
					 SSQL($id, 'int'));
		if(@mysqli_query(conn,$qry)){
			$vP=TRUE;
			$LOG.='<p>Actualizado Correctamente</p>';
		}else $LOG.= '<p>Error al actualizar</p>'.mysqli_error(conn);
	}
}
if(($acc)&&($acc==md5('DELd'))){
	$conDiag=totRowsTab('db_consultas_diagostico','id_diag',$id);
	if($conDiag>0){
		$LOG.='<p>No se pudo Eliminar. Existen Consultas relacionadas a este diagnostico</p>';
	}else{
		$qryDEL=sprintf('DELETE FROM db_diagnosticos WHERE id_diag=%s',
		SSQL($id,'int'));
		if(@mysqli_query(conn,$qryDEL)){
			$vP=TRUE;
			$LOG.="<p>Diagnostico Eliminado Correctamente</p>";
		}else $LOG.='<p>No se pudo Eliminar</p>';
	}
	$goTo.='?id='.$id;
}
/**************************************/
/**************************************/
$LOG.=mysqli_error(conn);
if($vD==TRUE) $LOG.=$LOGd;
if((!mysqli_error(conn))&&($vP==TRUE)){
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
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
echo $LOG;
header(sprintf("Location: %s", $goTo));
?>