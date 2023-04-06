<?php include('../../init.php');
$Auth->vLogin();
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$form=$_GET['form'] ?? $_POST['form'] ?? null;
$url=$_GET['url'] ?? $_POST['url'] ?? null;
$goTo=$url;

$det=$_POST;	
$vP=FALSE;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion

if(($form)&&($form=='formUsrPerm')){
	if(($acc)&&($acc=='UPD')){
		//Query 2
		$qryELIM = sprintf('DELETE FROM tbl_menus_usuario WHERE usr_id=%s', SSQL($id, 'int'));
		if(mysqli_query(conn,$qryELIM)){
			$vPM=TRUE;
			foreach($det['CMP'] as $valMen){
				$qryIM= sprintf('INSERT INTO tbl_menus_usuario (usr_id, men_id) VALUES (%s, %s)',
				SSQL($id,'int'),
				SSQL($valMen,'int'));
				if(!mysqli_query(conn,$qryIM)){
					$LOG.= '<h4>Error al Crear Permisos</h4>'.mysqli_error(conn);
					$vPM=FALSE;
					break;
				}
			}
			if($vPM){
				$LOG.='<h4>Permisos Actualizados Correctamente</h4>';
				$vP=TRUE;
			} else $vP=FALSE;
		}else{
			$LOG.= '<h4>Error al Eliminar Permisos Anteriores.</h4>'.mysqli_error(conn);
		}
	}
$goTo.='?id='.$id;
}

if(($acc)&&($acc=='CLEAN')){
		
}

$LOG.=mysqli_error(conn);
if((!mysqli_error(conn))&&($vP==TRUE)){
	mysqli_query(conn,"COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
	$LOG.='EJECUTADO.';
}else{
	mysqli_query(conn,"ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
	$LOG.='NO SE REALIZA.';
}		

mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit		
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

header(sprintf("Location: %s", $goTo));
?>