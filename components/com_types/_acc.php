<?php include('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$ref = $_GET['ref'] ?? $_POST['ref'] ?? null;
$val = $_GET['val'] ?? $_POST['val'] ?? null;
$vP = FALSE;
$data = $_POST;
mysqli_query($conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query($conn, "BEGIN;"); //Inicia la transaccion
if ((isset($data['form'])) && ($data['form'] == md5('formType'))) {
	if ((isset($acc)) && ($acc == md5('UPDt'))) {
		$qry = sprintf(
			'UPDATE dbTypes SET idComp=%s, refType=%s, nomType=%s, iconType=%s, valType=%s, auxType=%s WHERE idType=%s',
			SSQL($data['iMod'], 'text'),
			SSQL($data['iRef'], 'text'),
			SSQL($data['iNom'], 'text'),
			SSQL($data['iIcon'], 'text'),
			SSQL($data['iVal'], 'text'),
			SSQL($data['iAux'], 'text'),
			SSQL($id, 'int')
		);
		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$LOG .= cfg['p']['upd-true'];
		} else $LOG .= cfg['p']['upd-false'] . mysqli_error($conn);
	}else if ((isset($acc)) && ($acc == md5('INSt'))) {
		$qry = sprintf(
			'INSERT INTO dbTypes (idComp, refType, nomType, iconType, valType, auxType, status) 
		VALUES (%s,%s,%s,%s,%s,%s,%s)',
			SSQL($data['iMod'], 'text'),
			SSQL($data['iRef'], 'text'),
			SSQL($data['iNom'], 'text'),
			SSQL($data['iIcon'], 'text'),
			SSQL($data['iVal'], 'text'),
			SSQL($data['iAux'], 'text'),
			SSQL('1', 'int')
		);
		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$id = mysqli_insert_id($conn);
			$LOG .= cfg['p']['ins-true'];
		} else $LOG .= cfg['p']['ins-false'] . mysqli_error($conn);
	}
	$goTo .= '?id=' . $id;
}
if ((isset($acc)) && ($acc == md5('DELt'))) {
	$LOGd .= 'DEL<br>';
	$qry = sprintf(
		'DELETE FROM dbTypes WHERE idType=%s LIMIT 1',
		SSQL($id, 'int')
	);
	$LOGd .= $qry . '<br>';
	if (mysqli_query($conn, $qry)) {
		$vP = TRUE;
		$LOG .= cfg['p']['del-true'];
	} else $LOG .= cfg['p']['del-false'] . mysqli_error($conn);
	$goTo .= '?ref=' . $ref;
}
if ((isset($acc)) && ($acc == md5('STt'))) {
	$LOGd .= 'ST<br>';
	$qry = sprintf(
		'UPDATE dbTypes SET status=%s WHERE idType=%s LIMIT 1',
		SSQL($val, 'int'),
		SSQL($ids, 'int')
	);
	if (mysqli_query($conn, $qry)) {
		$vP = TRUE;
		$LOG .= cfg['p']['est-true'];
	} else $LOG .= cfg['p']['est-false'] . mysqli_error($conn);
	$goTo .= '?ref=' . $ref;
}
if ((isset($acc)) && ($acc == md5("CLONEt"))) {
	$LOGd .= 'CLONEt<br>';
	$dT = detRow('dbTypes', 'idType', $id);

	$qry = sprintf(
		'INSERT INTO dbTypes (idComp, refType, nomType, iconType, valType, auxType, status) 
		VALUES (%s,%s,%s,%s,%s,%s,%s)',
		SSQL($dT['idComp'], 'text'),
		SSQL($dT['refType'], 'text'),
		SSQL($dT['nomType'], 'text'),
		SSQL($dT['iconType'], 'text'),
		SSQL($dT['valType'], 'text'),
		SSQL($dT['auxType'], 'text'),
		SSQL($dT['status'], 'int')
	);
	if (mysqli_query($conn, $qry)) {
		$vP = TRUE;
		$id = mysqli_insert_id($conn);
		$LOG .= cfg['p']['ins-true'];
	} else $LOG .= cfg['p']['ins-false'] . mysqli_error($conn);
	$goTo .= '?id=' . $id;
}

$LOG .= mysqli_error($conn);
if ($vD == TRUE) $LOG .= $LOGd;
if ((!mysqli_error($conn)) && ($vP == TRUE)) {
	$_SESSION['sBr'] = $data['pac_nom'] . ' ' . $data['pac_ape'];
	mysqli_query($conn, "COMMIT;");
	$LOGt .= cfg['p']['m-ok'];
	$LOGc = cfg['p']['c-ok'];
	$LOGi = route['a'] . cfg['p']['i-ok'];
} else {
	mysqli_query($conn, "ROLLBACK;");
	$LOGt .= cfg['p']['m-fail'];
	$LOGc = cfg['p']['c-fail'];
	$LOGi = route['a'] . cfg['p']['i-fail'];
}
mysqli_query($conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit

$_SESSION['LOG']['t'] = $LOGt;
$_SESSION['LOG']['m'] = $LOG;
$_SESSION['LOG']['c'] = $LOGc;
$_SESSION['LOG']['i'] = $LOGi;
mysqli_query($conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit
//$goTo=urlr($goTo);
header(sprintf("Location: %s", $goTo));
