<?php require_once('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$ide = $_GET['ide'] ?? $_POST['ide'] ?? null;
$idefd = $_GET['idefd'] ?? $_POST['idefd'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$val = $_GET['val'] ?? $_POST['val'] ?? null;
$form = $_GET['form'] ?? $_POST['form'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$data = $_POST;
mysqli_query(conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn, "BEGIN;"); //Inicia la transaccion
if ((isset($form)) && ($form == md5('fexamenf'))) {
	$_SESSION['tab']['examf']['tabA'] = 'active';
	switch ($acc) {
		case md5('INSef'):
			$idA = AUD(NULL, 'Creación formato examen');
			$qry = sprintf(
				'INSERT INTO db_examenes_format (nom,enc,des,pie,idA) VALUES (%s,%s,%s,%s,%s)',
				SSQL($data['iNom'], 'text'),
				SSQL($data['iEnc'], 'text'),
				SSQL($data['iDes'], 'text'),
				SSQL($data['iPie'], 'text'),
				SSQL($idA, 'int')
			);
			//$LOG.=$qry.'<br>';
			if (@mysqli_query(conn, $qry)) {
				$vP = TRUE;
				$id = @mysqli_insert_id(conn);
				$LOG .= '<p>Formato creado correctamente</p>';
			} else {
				$LOG .= '<p>Error al crear formato</p>' . mysqli_error(conn);
			}
			break;
		case md5('UPDef'):
			$detEF = detRow('db_examenes_format', 'id', $id);
			$idA = AUD($detEF['idA'], 'Actualización formato examen');
			$qry = sprintf(
				'UPDATE db_examenes_format SET nom=%s, enc=%s, des=%s, pie=%s, idA=%s WHERE id=%s',
				SSQL($data['iNom'], 'text'),
				SSQL($data['iEnc'], 'text'),
				SSQL($data['iDes'], 'text'),
				SSQL($data['iPie'], 'text'),
				SSQL($idA, 'int'),
				SSQL($id, 'text')
			);
			//$LOG.=$qry.'<br>';
			if (@mysqli_query(conn, $qry)) {
				$vP = TRUE;
				$LOG .= '<p>Formato actualizado correctamente</p>';
			} else {
				$LOG .= '<p>Error al actualizar formato</p>' . mysqli_error(conn);
			}
			break;
	}
	$goTo .= '?id=' . $id;
}

if ((isset($form)) && ($form == md5('fexamenfd'))) {
	$_SESSION['tab']['examf']['tabB'] = 'active';
	switch ($acc) {
		case md5('INSefd'):
			//$idA=AUD(NULL,'Creación formato examen');
			$qry = sprintf(
				'INSERT INTO db_examenes_format_det (idef,nom,val,act,est) VALUES (%s,%s,%s,%s,%s)',
				SSQL($id, 'int'),
				SSQL($data['iNom'], 'text'),
				SSQL($data['iVal'], 'text'),
				SSQL($data['isCheck'], 'int'),
				SSQL($data['isAct'], 'int')
			);
			if (@mysqli_query(conn, $qry)) {
				$vP = TRUE;
				//$id=@mysqli_insert_id(conn);
				$LOG .= '<p>Examen para formato creado correctamente</p>';
			} else {
				$LOG .= '<p>Error al crear examen para formato</p>' . mysqli_error(conn);
			}
			break;
		case md5('UPDefd'):
			//$detEF=detRow('db_examenes_format','id',$id);
			//$idA=AUD($detEF['idA'],'Actualización formato examen');
			$qry = sprintf(
				'UPDATE db_examenes_format_det SET nom=%s ,val=%s, act=%s, est=%s WHERE id=%s',
				SSQL($data['iNom'], 'text'),
				SSQL($data['iVal'], 'text'),
				SSQL($data['isCheck'], 'text'),
				SSQL($data['isAct'], 'text'),
				SSQL($idefd, 'int')
			);
			//$LOG.=$qry.'<br>';
			if (@mysqli_query(conn, $qry)) {
				$vP = TRUE;
				$LOG .= '<p>Examen para formato, actualizado correctamente</p>';
			} else {
				$LOG .= '<p>Error al actualizar examen para formato</p>' . mysqli_error(conn);
			}
			break;
	}
	$goTo .= '?id=' . $id;
	echo $goTo;
}

//fexamenf
if (($acc) && ($acc == md5('STef'))) {
	$_SESSION['tab']['examf']['tabA'] = 'active';
	$qry = sprintf(
		'UPDATE db_examenes_format SET stat=%s WHERE id=%s LIMIT 1',
		SSQL($val, 'int'),
		SSQL($id, 'int')
	);
	if (@mysqli_query(conn, $qry)) {
		$vP = TRUE;
		$LOG .= "<p>Estado actualizado</p>";
	} else $LOG .= '<p>Error al actualiza</p>' . mysqli_error(conn);
	//$goTo.='?id='.$id;
}
if (($acc) && ($acc == md5('DELef'))) {
	$_SESSION['tab']['examf']['tabA'] = 'active';
	$qry = sprintf(
		'DELETE FROM db_examenes_format WHERE id=%s LIMIT 1',
		SSQL($id, 'int')
	);
	if (@mysqli_query(conn, $qry)) {
		$vP = TRUE;
		$LOG .= "<p>Eliminado correctamente</p>";
	} else $LOG .= '<p>Error al eliminar</p>' . mysqli_error(conn);
	//$goTo.='?id='.$id;
}
////////////////////////////////////////////////////////////////////////////
//EXAM FORMAT DETALLE
if (($acc) && ($acc == md5('SELefd'))) {
	$_SESSION['tab']['examf']['tabB'] = 'active';
	$qry = sprintf(
		'UPDATE db_examenes_format_det SET act=%s WHERE id=%s LIMIT 1',
		SSQL($val, 'int'),
		SSQL($idefd, 'int')
	);
	if (@mysqli_query(conn, $qry)) {
		$vP = TRUE;
		$LOG .= "<p>Estado actualizado</p>";
	} else $LOG .= '<p>Error al actualiza</p>' . mysqli_error(conn);
	$goTo .= '?id=' . $id;
}

if (($acc) && ($acc === md5('STefd'))) {
	$_SESSION['tab']['examf']['tabB'] = 'active';
	$qry = sprintf(
		'UPDATE db_examenes_format_det SET est=%s WHERE id=%s LIMIT 1',
		SSQL($val, 'int'),
		SSQL($idefd, 'int')
	);
	if (@mysqli_query(conn, $qry)) {
		$vP = TRUE;
		$LOG .= "<p>Estado actualizado</p>";
	} else $LOG .= '<p>Error al actualiza</p>' . mysqli_error(conn);
	$goTo .= '?id=' . $id;
}
if (($acc) && ($acc == md5('DELefd'))) {
	$_SESSION['tab']['examf']['tabB'] = 'active';
	$qry = sprintf(
		'DELETE FROM db_examenes_format_det WHERE id=%s LIMIT 1',
		SSQL($idefd, 'int')
	);
	if (@mysqli_query(conn, $qry)) {
		$vP = TRUE;
		$LOG .= "<p>Eliminado correctamente</p>";
	} else $LOG .= '<p>Error al eliminar</p>' . mysqli_error(conn);
	$goTo .= '?id=' . $id;
}
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
if (($acc) && ($acc == 'DEL')) {
	$detExa = detRow('db_examenes', 'id_exa', $ide);
	$idp = $detExa['pac_cod'];
	$qryDEL = sprintf(
		'DELETE FROM db_examenes WHERE id_exa=%s',
		SSQL($ide, 'int')
	);
	if (@mysqli_query(conn, $qryDEL)) {
		$LOG .= "<p>Eliminado Correctamente</p>";
	} else {
		$LOG .= '<p>No se pudo Eliminar</p>';
		$LOG .= mysqli_error(conn);
	}
	$goTo = 'gest.php?id=' . $idp;
}

$LOG .= mysqli_error(conn);
if ($vD == TRUE) $LOG .= $LOGd;
if ((!mysqli_error(conn)) && ($vP == TRUE)) {
	mysqli_query(conn, "COMMIT;");
	$LOGt = $cfg['p']['m-ok'];
	$LOGc = $cfg['p']['c-ok'];
	$LOGi = $RAIZa . $cfg['p']['i-ok'];
} else {
	mysqli_query(conn, "ROLLBACK;");
	$LOGt .= 'Solicitud no Procesada';
	$LOG .= mysqli_error(conn);
	$LOGc = $cfg['p']['c-fail'];
	$LOGi = $RAIZa . $cfg['p']['i-fail'];
}
mysqli_query(conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t'] = $LOGt;
$_SESSION['LOG']['m'] = $LOG;
$_SESSION['LOG']['c'] = $LOGc;
$_SESSION['LOG']['i'] = $LOGi;
header(sprintf("Location: %s", $goTo));
