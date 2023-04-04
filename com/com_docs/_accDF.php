<?php require_once('../../init.php');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$ids=$_GET['ids'] ?? $_POST['ids'] ?? null;
$ide=$_GET['ide'] ?? $_POST['ide'] ?? null;
$idefd=$_GET['idefd'] ?? $_POST['idefd'] ?? null;
$acc=$_GET['acc'] ?? $_POST['acc'] ?? null;
$val=$_GET['val'] ?? $_POST['val'] ?? null;
$form=$_GET['form'] ?? $_POST['form'] ?? null;
$goTo=$_GET['url'] ?? $_POST['url'] ?? null;
$data=$_POST;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion
if((isset($form))&&($form==md5('fFormat'))){
	switch($acc){
		case md5('INSf'):
			$idA=AUD(NULL,'Creación formato documento');
			$qry=sprintf('INSERT INTO db_documentos_formato (nombre,formato,status,idA) VALUES (%s,%s,%s,%s)',
						SSQL($data['iNom'],'text'),
						SSQL($data['iFor'],'text'),
						SSQL($data['iStat'],'int'),
						SSQL($idA,'int'));
			$LOGd.=$qry.'<br>';
			if(mysqli_query(conn,$qry)){
				$vP=TRUE;
				$id=mysqli_insert_id(conn);
				$ids=md5($id);
				$LOG.='<p>Formato creado correctamente</p>';
			}else $LOG.='<p>Error al crear formato</p>'.mysqli_error(conn);
		break;
		case md5('UPDf'):
			$detF=detRow('db_documentos_formato','md5(id_df)',$ids);
			$id=$detF['id_df'];
			$idA=AUD($detF['idA'],'Actualización formato examen');
			$qry=sprintf('UPDATE db_documentos_formato SET nombre=%s, formato=%s, status=%s, idA=%s WHERE id_df=%s LIMIT 1',
						SSQL($data['iNom'],'text'),
						SSQL($data['iFor'],'text'),
						SSQL($data['iStat'],'int'),
						SSQL($idA,'int'),
						SSQL($id,'int'));
			//$LOGd.=$qry.'<br>';
			if(mysqli_query(conn,$qry)){
				$vP=TRUE;
				$LOG.='<p>Formato actualizado correctamente</p>';
			}else $LOG.='<p>Error al actualizar formato</p>'.mysqli_error(conn);
		break;
	}
	$goTo.='?ids='.$ids;
}
//fexamenf
if(($acc)&&($acc==md5('STf'))){
	//$_SESSION['tab']['examf']['tabA']='active';
	$qry=sprintf('UPDATE db_documentos_formato SET status=%s WHERE md5(id_df)=%s LIMIT 1',
					SSQL($val,'int'),
					SSQL($ids,'text'));
	$LOGd.=$qry.'<br>';
	if(mysqli_query(conn,$qry)){
		$vP=TRUE;
		$LOG.="<p>Estado actualizado</p>";
	}else $LOG.='<p>Error al actualizar</p>'.mysqli_error(conn);
	//if(!$goTo) $goTo.='docFormat.PHP';
}
if(($acc)&&($acc==md5('DELf'))){
	//$_SESSION['tab']['examf']['tabA']='active';
	$qry=sprintf('DELETE FROM db_documentos_formato WHERE md5(id_df)=%s LIMIT 1',
					SSQL($ids,'text'));
	$LOGd.=$qry.'<br>';
	if(mysqli_query(conn,$qry)){
		$vP=TRUE;
		$LOG.="<p>Eliminado correctamente</p>";
	}else $LOG.='<p>Error al eliminar</p>'.mysqli_error(conn);
	//if(!$goTo) $goTo.='docFormat.PHP';
}
////////////////////////////////////////////////////////////////////////////
$LOG.=mysqli_error(conn);
if($vD==TRUE) $LOG.=$LOGd;
if((!mysqli_error(conn))&&($vP==TRUE)){
	mysqli_query(conn,"COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysqli_query(conn,"ROLLBACK;");
	$LOGt.='Solicitud no Procesada';
	$LOG.=mysqli_error(conn);
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
