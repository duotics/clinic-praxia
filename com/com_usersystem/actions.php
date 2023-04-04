<?php require('../../init.php');
vLOGIN();
$dat=$_REQUEST;
$id=$dat['id'];
$vStep=FALSE;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion
	
	//BEG USER
	if(($dat['form'])&&($dat['form']=='formUsr')){
		$GoTo='form.php';
		if(($dat['acc'])&&($dat['acc']==md5('INS'))){
			$idAud=AUD(NULL,'Creación Usuario');
			$qryInsUser=sprintf('INSERT INTO tbl_usuario 
			(emp_cod, usr_nombre, usr_contrasena, usr_theme, usr_est, id_aud) 
			VALUES(%s,%s,%s,%s,%s,%s)',
			SSQL($dat['inpEmpCod'],'int'),
			SSQL($dat['inpUserNom'],'text'),
			SSQL(md5($dat['inpUserPass']),'text'),
			SSQL($dat['inpUserTheme'],'text'),
			SSQL('1','int'),
			SSQL($idAud,'int'));
			if(mysqli_query(conn,$qryInsUser)){
				$id=mysqli_insert_id(conn);
				$LOG.='<p>Usuario Creado Correctamente</p>';
				$vStep=TRUE;
			}else{
				$LOG.='<p>Error Crear usuario</p>';
				$LOG.=mysqli_error(conn);
			}
		}
		if(($dat['acc'])&&($dat['acc']==md5('UPD'))){
			$dU=detRow('tbl_usuario','usr_id',$dat['id']);
			$idAud=AUD($dU['id_aud'],'Actualización Usuario');
			$qryUpdUser=sprintf('UPDATE tbl_usuario SET 
			emp_cod=%s, usr_nombre=%s, usr_theme=%s
			WHERE usr_id=%s',
			SSQL($dat['inpEmpCod'],'int'),
			SSQL($dat['inpUserNom'],'text'),
			SSQL($dat['inpUserTheme'],'text'),
			SSQL($dat['id'],'int'));
			if(mysqli_query(conn,$qryUpdUser)){
				$LOG.='<p>Usuario Actualizado Correctamente</p>';
				$vStep=TRUE;
			}else{
				$LOG.='<p>Error Actualizar usuario</p>';
				$LOG.=mysqli_error(conn);
			}
		
			if(($dat['formPassNew1'])&&($dat['formPassNew2'])){
				if($dat['formPassNew1']==$dat['formPassNew2']){
					$idAud=AUD($dU['id_aud'],'Actualización Contraseña');
					$qryUpdPass=sprintf('UPDATE tbl_usuario SET 
					usr_contrasena=%s WHERE usr_id=%s',
					SSQL(md5($dat['formPassNew1']),'text'),
					SSQL($dat['id'],'int'));
					if(mysqli_query(conn,$qryUpdPass)){
						$LOG.='<p>Contraseña Actualizada Correctamente</p>';
						$vStep=TRUE;
					}else{
						$LOG.='<p>Error Actualizar Contraseña</p>';
						$LOG.=mysqli_error(conn);
					}
				}else{
					$LOG.='<p>CONTRASEÑA NO SE PUDO ACTUALIZAR, no coinciden</p>';
				}
			}else{
				$LOG.='<p>CONTRASEÑA VACIA</p>';
			}
		}
		$GoTo.='?id='.$id;
	}//END USER
	
	
	if(($dat['form'])&&($dat['form']=='formPass')){
	$GoTo=$RAIZc.'com_usersystem/changePass.php';
	//Valid Token
	$datUsu=detRow('tbl_usuario','usr_id',$_SESSION['dU']['ID']);
	if($datUsu){
		//Usuario Valido
		$datUsu_passAnt=$datUsu['usr_contrasena'];
		if($datUsu_passAnt==md5($dat['formPassAnt'])){
			//Contraseña Anterior Correcta
			if($datUsu_passAnt!=md5($dat['formPassNew1'])){
				//Contraseña Nueva Difente a la Original
				if($dat['formPassNew1']==$dat['formPassNew2']){
					//Contraseñas Nuevas Coincidentes
					//Actualizo Contraseña
					$passNew=md5($dat['formPassNew1']);
					$id_aud=AUD($datUsu['id_aud'],'Cambio Password Usuario');
					$qry=sprintf('UPDATE tbl_usuario SET usr_contrasena=%s, id_aud=%s WHERE usr_id=%s',
					SSQL($passNew,'text'),
					SSQL($id_aud,'int'),
					SSQL($_SESSION['dU']['ID'],'int'));
					if(mysqli_query(conn,$qry)){
						//Contraseña Modificada
						$vStep=TRUE;
						$LOG.='<h4>Contraseña Modificada Correctamente</h4>';
					}else{
						//Error al modificar contraseña
						$LOG.=mysqli_error(conn);
						$LOG.='<h4>No se pudo modificar contraseña</h4>';
					}
				}else{
					//Contraseñas no Coinciden
					$LOG.='<h4>LAS CONTRASEÑAS NUEVAS NO COINCIDEN</h4>Intente otra vez';
				}
			}else{
				//Contraseña Anterior Incorrecta
				$LOG.='<h4>LA NUEVA CONTRASEÑA ES IGUAL A LA ANTERIOR</h4>Ingrese una nueva clave';
			}
			
		}else{
			//Contraseña Anterior Incorrecta
			$LOG.='<h4>CONTRASEÑA ANTERIOR INCORRECTA</h4>Intente otra vez';
		}
	}else{
		//Usuario No Existe
		$LOG.='<h4>USUARIO NO EXISTE EN EL SISTEMA</h4>';
	}
	}//END IF
	
	if(($dat['form'])&&($dat['form']=='formPerfil')){
		$GoTo=$RAIZc.'com_usersystem/user_perfil.php';
		
		$datUsu=detRow('tbl_usuario','usr_id',$_SESSION['dU']['ID']);
		$datEmp=detRow('db_empleados','emp_cod',$datUsu['emp_cod']);
		$id_aud=AUD($datUsu['id_aud'],'Actualización Usuario');
		//UPDATE tbl_usuarioa
		$qryUpdUsr=sprintf('UPDATE tbl_usuario SET usr_nombre=%s, usr_theme=%s, id_aud=%s WHERE usr_id=%s',
		SSQL($dat['usr_nombre'],'text'),
		SSQL($dat['user_theme'],'text'),
		SSQL($id_aud,'int'),
		SSQL($_SESSION['dU']['ID'],'int'));
		if(@mysqli_query(conn,$qryUpdUsr)){
			$LOG.='<p>Usuario Actualizado</p>';
			//UPDATE db_empleados
			$id_aud=AUD($datEmp['id_aud'],'Actualización Empleado');
			$qryUpdEmp=sprintf('UPDATE db_empleados SET typ_cod=%s, emp_ced=%s, emp_nom=%s, emp_ape=%s, emp_dir=%s, emp_tel=%s, emp_cel=%s, emp_mail=%s, id_aud=%s WHERE emp_cod=%s',
			SSQL($dat['typ_cod'],'int'),
			SSQL($dat['emp_ced'],'text'),
			SSQL($dat['emp_nom'],'text'),
			SSQL($dat['emp_ape'],'text'),
			SSQL($dat['emp_dir'],'text'),
			SSQL($dat['emp_tel'],'text'),
			SSQL($dat['emp_cel'],'text'),
			SSQL($dat['emp_mail'],'text'),
			SSQL($id_aud,'int'),
			SSQL($datUsu['emp_cod'],'text'));
			if(@mysqli_query(conn,$qryUpdEmp)){
				$LOG.='<p>Empleado Actualizado</p>';
				$vStep=TRUE;
			}else{
				$LOG.='<p>No se pudo actualizar</p>';
				$LOG.=mysqli_error(conn);
			}
		}else{
			$LOG.='<p>No se pudo actualizar</p>';
			$LOG.=mysqli_error(conn);
		}
	}
	//ACTUALIZAR STATUS EMPLEADO 1=ACTIVO, 0=INACTIVO
	if((isset($dat['acc']))&&($dat['acc']==md5('STAT'))){
		$GoTo=$dat['url'];
		$qry=sprintf('UPDATE tbl_usuario SET usr_est=%s WHERE usr_id=%s',
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
header(sprintf("Location: %s", $GoTo));
?>