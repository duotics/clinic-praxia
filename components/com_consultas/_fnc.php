<?php include('../../init.php');
//FUNCIONES FORMULARIO CONSULTAS
//PARAMETROS
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null; //Id que viene de AJAX
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null; //Id que viene de AJAX
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null; //Id que viene de AJAX
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null; //Id que viene de AJAX
$mod = $_GET['mod'] ?? $_POST['mod'] ?? null; //mod
$dat = $_POST;
$vP = FALSE;
mysqli_query(conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn, "BEGIN;"); //Inicia la transaccion
if ((isset($mod)) && ($mod == md5('consForm'))) {
	if ($acc == md5("INSc")) {
		$idAud = AUD(NULL, 'Creación Consulta');
		$qryins = sprintf(
			'INSERT INTO db_consultas (pac_cod, con_fec, con_typ, con_typvis, con_val, tip_pag, dcon_mot, id_aud, con_stat) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($idp, "int"),
			SSQL($sdatet, "text"),
			SSQL($dat["con_typ"] ?? null, "int"),
			SSQL($dat["con_typvis"] ?? null, "int"),
			SSQL($dat["con_val"] ?? null, "double"),
			SSQL($dat["tip_pag"] ?? null, "text"),
			SSQL($dat["dcon_mot"] ?? null, "text"),
			SSQL($idAud ?? null, "int"),
			SSQL('1', "text")
		);
		if (mysqli_query(conn, $qryins)) {
			$vP = TRUE;
			$idc = mysqli_insert_id(conn);
			$LOG .= "<p>Consulta Grabada Correctamente</p>";
			if ($idr) $LOG .= verifyRESid($idr);
			else $LOG .= verifyREShis($idp);
		} else $LOG .= "<p>Error al Grabar Consulta</p>";
	}
	if ($acc == md5("UPDc")) {
		$detCon = detRow('db_consultas', 'con_num', $idc);
		$idAud = AUD($detCon['id_aud'], 'Actualización Consulta');
		$qryupd = sprintf(
			'UPDATE db_consultas SET con_upd=%s, con_typ=%s, con_typvis=%s, con_val=%s, tip_pag=%s, dcon_mot=%s, id_aud=%s, con_stat=%s WHERE con_num=%s',
			SSQL($sdatet, "text"),
			SSQL($dat["con_typ"] ?? null, "int"),
			SSQL($dat["con_typvis"] ?? null, "int"),
			SSQL($dat["con_val"] ?? null, "double"),
			SSQL($dat["tip_pag"] ?? null, "text"),
			SSQL($dat["dcon_mot"] ?? null, "text"),
			SSQL($idAud ?? null, "int"),
			SSQL("1", "text"),
			SSQL($idc, "int")
		);
		if (mysqli_query(conn, $qryupd)) {
			$vP = TRUE;
			$LOG .= '<p>Consulta Guardada Correctamente.</p>';
			if ($idr) $LOG .= verifyRESid($idr);
		} else $LOG .= '<p>ERROR al Actualizar Consulta</p>';
	}
}
/*****************************/
$LOG .= mysqli_error(conn);
if ((!mysqli_error(conn)) && ($vP == TRUE)) {
	mysqli_query(conn, "COMMIT;");
	$LOGt = 'Operación Ejecutada Exitosamente';
	$LOGc = $cfg['p']['c-ok'];
	$LOGi = $RAIZa . $_SESSION['conf']['i']['ok'];
	$insertGoTo = 'form.php?idc=' . $idc;
} else {
	mysqli_query(conn, "ROLLBACK;");
	$LOGt = 'Fallo del Sistema, intente de nuevo';
	$LOGc = $cfg['p']['c-fail'];
	$insertGoTo = 'form.php?idc=' . $idc . '&idp=' . $idp;
	$LOGi = $RAIZa . $_SESSION['conf']['i']['fail'];
}
mysqli_query(conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit
$LOG .= mysqli_error(conn);
$_SESSION['LOG']['m'] = $LOG;
$_SESSION['LOG']['t'] = $LOGt;
$_SESSION['LOG']['c'] = $LOGc;
$_SESSION['LOG']['i'] = $LOGi;
header(sprintf("Location: %s", $insertGoTo));
