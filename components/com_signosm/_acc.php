<?php require('../../init.php');
$det = $_REQUEST;
$goTo = $det['url'];
$acc = $det['acc'];
$idp = $det['idp'];
$ids = $det['ids'];
$vP = FALSE;
mysqli_query(conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn, "BEGIN;"); //Inicia la transaccion
if (isset($det['form']) && ($det['form'] == md5('hispac'))) {
	$LOGd .= "form -> hispac<br>";
	switch ($acc) {
		case md5('INSs');
			$LOGd .= "acc -> INSs<br>";
			$qI = sprintf(
				"INSERT INTO db_signos (pac_cod,fecha,peso,paS,paD,talla,imc,temp,fc,fr,po2,co2) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				SSQL($idp, "int"),
				SSQL($sdate, "date"),
				SSQL($det['hpeso'] ?? null, "text"),
				SSQL($det['hpaS'] ?? null, "int"),
				SSQL($det['hpaD'] ?? null, "int"),
				SSQL($det['htalla'] ?? null, "text"),
				SSQL($det['himc'] ?? null, "text"),
				SSQL($det['htemp'] ?? null, "text"),
				SSQL($det['hfc'] ?? null, "text"),
				SSQL($det['hfr'] ?? null, "text"),
				SSQL($det['hpo2'] ?? null, "text"),
				SSQL($det['hco2'] ?? null, "text")
			);
			if (mysqli_query(conn, $qI)) {
				$LOG .= $cfg['p']['ins-true'];
				$ids = mysqli_insert_id(conn);
				$vP = TRUE;
			} else $LOG .= $cfg['p']['ins-false'] . mysqli_error(conn);
			break;
		case md5('UPDs');
			$LOGd .= "acc -> UPDs<br>";
			$qU = sprintf(
				"UPDATE db_signos SET 
			peso=%s, paS=%s, paD=%s, talla=%s , imc=%s, temp=%s, fc=%s, fr=%s, po2=%s, co2=%s
			WHERE id=%s",
				SSQL($det['hpeso'] ?? null, "text"),
				SSQL($det['hpaS'] ?? null, "int"),
				SSQL($det['hpaD'] ?? null, "int"),
				SSQL($det['htalla'] ?? null, "text"),
				SSQL($det['himc'] ?? null, "text"),
				SSQL($det['htemp'] ?? null, "text"),
				SSQL($det['hfc'] ?? null, "text"),
				SSQL($det['hfr'] ?? null, "text"),
				SSQL($det['hpo2'] ?? null, "text"),
				SSQL($det['hco2'] ?? null, "text"),
				SSQL($ids, "int")
			);
			if (mysqli_query(conn, $qU)) {
				$LOG .= $cfg['p']['upd-true'];
				$vP = TRUE;
			} else $LOG .= $cfg['p']['upd-false'] . mysqli_error(conn);
			break;
	}
	$qUB = sprintf(
		'UPDATE db_pacientes_bus SET est=%s WHERE idp=%s',
		SSQL('1', 'int'),
		SSQL($idp, 'int')
	);
	if (mysqli_query(conn, $qUB)) {
		$LOG .= 'Find status change.';
	} else {
		$LOG .= 'Fail Find status change';
	}
	$goToP = '?idp=' . $idp;
}

if (isset($acc) && ($acc == md5('DELs'))) {
	$LOGd .= "acc -> DELm<br>";
	$dS = detRow('db_signos', 'id', $ids);
	$idp = $dS['pac_cod'];
	$qDEL = sprintf(
		'DELETE FROM db_signos WHERE id=%s',
		SSQL($ids, 'int')
	);
	$LOGd .= $qDEL;
	if (mysqli_query(conn, $qDEL)) {
		$vP = TRUE;
		$LOG .= "<p>Signos Eliminados</p>";
	} else $LOG .= '<p>No se pudo Eliminar</p>' . mysqli_error(conn);
	$goToP = '?idp=' . $idp;
}

if ($vD == TRUE) $LOG .= $LOGd;
$LOG .= mysqli_error(conn);
$LOGr["m"] = $LOG;
if (($vP == TRUE) && (!mysqli_error(conn))) {
	$_SESSION['sigm']['auto'] = 'si';
	mysqli_query(conn, "COMMIT;");
	$LOGr["t"] = $cfg["p"]['m-ok'];
	$LOGr["c"] = $cfg["p"]['c-ok'];
	$LOGr["i"] = $RAIZa . $cfg["p"]['i-ok'];
} else {
	mysqli_query(conn, "ROLLBACK;");
	$LOGr["t"] = $cfg["p"]['m-fail'];
	$LOGr["c"] = $cfg["p"]['c-fail'];
	$LOGr["i"] = $RAIZa . $cfg["p"]['i-fail'];
}
mysqli_query(conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG'] = $LOGr;
//echo $LOGr[m];
header(sprintf("Location: %s", $goTo . $goToP));
