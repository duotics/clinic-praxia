<?php require('../../init.php');
vLOGIN();
$dat=$_REQUEST;
$id=$dat['id'];
$GoTo=$dat['url'];
$vStep=FALSE;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion
	
	if(($dat['form'])&&($dat['form']=='formEmp')){
		$GoTo='form.php';
		if(($dat['acc'])&&($dat['acc']==md5('UPD'))){
			$dEmp=detRow('db_empleados','emp_cod',$dat['id']);
			$idA=AUD($dEmp['id_aud'],'Actualización Empleado');
			//UPDATE tbl_usuarioa
			$qryUpd=sprintf('UPDATE db_empleados 
			SET typ_cod=%s, emp_ced=%s, emp_nom=%s, emp_ape=%s, emp_dir=%s, emp_tel=%s, emp_cel=%s, emp_mail=%s, id_aud=%s 
			WHERE emp_cod=%s',
			SSQL($dat['typ_cod'],'int'),
			SSQL($dat['emp_ced'],'text'),
			SSQL($dat['emp_nom'],'text'),
			SSQL($dat['emp_ape'],'text'),
			SSQL($dat['emp_dir'],'text'),
			SSQL($dat['emp_tel'],'text'),
			SSQL($dat['emp_cel'],'text'),
			SSQL($dat['emp_mail'],'text'),
			SSQL($idA,'int'),
			SSQL($id,'int'));
			if(@mysqli_query(conn,$qryUpd)){
				$vStep=TRUE;
				$LOG.='<p>Empleado Actualizado</p>';
			}else{
				$LOG.='<p>No se pudo actualizar</p>';
				$LOG.=mysqli_error(conn);
			}
		}//END IF acc
		if(($dat['acc'])&&($dat['acc']==md5('INS'))){
			$idA=AUD($dEmp['id_aud'],'Actualización Empleado');
			//INSERT tbl_usuarioa
			$qryIns=sprintf('INSERT INTO db_empleados 
			(typ_cod, emp_ced, emp_nom, emp_ape, emp_dir, emp_tel, emp_cel, emp_mail, emp_status, id_aud) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($dat['typ_cod'],'int'),
			SSQL($dat['emp_ced'],'text'),
			SSQL($dat['emp_nom'],'text'),
			SSQL($dat['emp_ape'],'text'),
			SSQL($dat['emp_dit'],'text'),
			SSQL($dat['emp_tel'],'text'),
			SSQL($dat['emp_cel'],'text'),
			SSQL($dat['emp_mail'],'text'),
			SSQL($idA,'int'),
			SSQL(1,'int'));
			if(@mysqli_query(conn,$qryIns)){
				$vStep=TRUE;
				$id=mysqli_insert_id(conn);
				$LOG.='<p>Creado Correctamente</p>';
			}else{
				$LOG.='<p>Error al Crear Empleado</p>';
				$LOG.=mysqli_error(conn);
			}
		}//END IF acc
		$GoToParam='?id='.$id;
	}//END IF form
	
	//ACTUALIZAR STATUS EMPLEADO 1=ACTIVO, 0=INACTIVO
	if((isset($dat['acc']))&&($dat['acc']==md5('DELE'))){
		$GoTo=$dat['url'];
		$qry=sprintf('DELETE FROM db_empleados WHERE emp_cod=%s',
		SSQL($dat['id'],'int'));
		if(@mysqli_query(conn,$qry)){
			$vStep=TRUE;
			$LOG.="<h4>Status Actualizado.<h4>ID. ".$dat['id'];
		}else $LOG.='<h4>ERROR, no se pudo actualizar.</h4>'.mysqli_error(conn);
	}
	
	//ACTUALIZAR STATUS EMPLEADO 1=ACTIVO, 0=INACTIVO
	if((isset($dat['acc']))&&($dat['acc']==md5('STAT'))){
		$GoTo=$dat['url'];
		$qry=sprintf('UPDATE db_empleados SET emp_status=%s WHERE emp_cod=%s',
		SSQL($dat['val'],'int'),
		SSQL($dat['id'],'int'));
		if(@mysqli_query(conn,$qry)){
			$vStep=TRUE;
			$LOG.="<h4>Status Actualizado.<h4>ID. ".$dat['id'];
		}else $LOG.='<h4>ERROR, no se pudo actualizar.</h4>'.mysqli_error(conn);
	}


if((!mysqli_error(conn))&&($vStep==TRUE)){
	mysqli_query(conn,"COMMIT;");
	$_SESSION['sBr']=$_POST['pac_nom'].' '.$_POST['pac_ape'];
	$_SESSION['LOG']['t']='OPERACIÓN EXITOSA';	
	$_SESSION['LOG']['c']='info';
	$_SESSION['LOG']['i']=$RAIZa.'images/icons/Ok-48.png';
	$_SESSION['bsTheme']=$dat['user_theme'];
}else{
	mysqli_query(conn,"ROLLBACK;");
	$_SESSION['LOG']['t']='ERROR';	
	$_SESSION['LOG']['c']='danger';
	$_SESSION['LOG']['i']=$RAIZa.'images/icons/Cancel-48.png';
}
mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG.=mysqli_error(conn);
$_SESSION['LOG']['m']=$LOG;
//echo $LOG;
if(!$GoTo) $GoTo='index.php';
header(sprintf("Location: %s", $GoTo.$GoToParam));
?>