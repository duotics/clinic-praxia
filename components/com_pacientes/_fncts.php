<?php include('../../init.php');
$dM = $Auth->vLogin('PACIENTE');
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$vP = FALSE;
//$vD=TRUE;
$data = $_POST;
mysqli_query(conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn, "BEGIN;"); //Inicia la transaccion
if ((isset($data['mod'])) && ($data['mod'] == $dM['mod_ref'])) {
	$LOGd .= '<small>mod</small>';
	if ((isset($acc)) && ($acc == md5("INSp"))) {
		$LOGd .= '<small>acc. INS</small>';
		$qry = sprintf(
			'INSERT INTO db_pacientes (pac_ced, pac_fec, pac_reg, pac_nom, pac_ape, pac_lugp, pac_lugr, pac_dir, pac_sect, pac_tel1 , pac_tel2, pac_email, pac_tipsan, pac_estciv, pac_hijos, pac_sexo, pac_raza, pac_ins, pac_pro, pac_emp, pac_ocu, pac_nompar, pac_telpar, pac_ocupar, pac_fecpar, pac_tipsanpar, publi, pac_obs, pac_tipst) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($data['pac_ced'], "text"),
			SSQL($data['pac_fec'], "date"),
			SSQL($sdate, "date"),
			SSQL(strtoupper($data['pac_nom']), "text"),
			SSQL(strtoupper($data['pac_ape']), "text"),
			SSQL($data['pac_lugp'] ?? null, "text"),
			SSQL($data['pac_lugr'] ?? null, "text"),
			SSQL($data['pac_dir'] ?? null, "text"),
			SSQL($data['pac_sect'] ?? null, "int"),
			SSQL($data['pac_tel1'] ?? null, "text"),
			SSQL($data['pac_tel2'] ?? null, "text"),
			SSQL($data['pac_email'] ?? null, "text"),
			SSQL($data['pac_tipsan'] ?? null, "int"),
			SSQL($data['pac_estciv'] ?? null, "int"),
			SSQL($data['pac_hijos'] ?? null, "int"),
			SSQL($data['pac_sexo'] ?? null, "int"),
			SSQL($data['pac_raza'] ?? null, "int"),
			SSQL($data['pac_ins'] ?? null, "int"),
			SSQL($data['pac_pro'] ?? null, "text"),
			SSQL($data['pac_emp'] ?? null, "text"),
			SSQL($data['pac_ocu'] ?? null, "text"),
			SSQL($data['pac_nompar'] ?? null, "text"),
			SSQL($data['pac_telpar'] ?? null, "text"),
			SSQL($data['pac_ocupar'] ?? null, "text"),
			SSQL($data['pac_fecpar'] ?? null, "date"),
			SSQL($data['pac_tipsanpar'] ?? null, "int"),
			SSQL($data['publi'] ?? null, "text"),
			SSQL($data['pac_obs'] ?? null, "text"),
			SSQL($data['pac_tipst'] ?? null, "int")
		);
		//$LOGd.='<small>'.$qry.'</small>';
		if (@mysqli_query(conn, $qry)) {
			$id = @mysqli_insert_id(conn);
			$LOG .= '<p>Paciente Creado</p>';
			// Registro Historia Clinic
			$qryHc = sprintf(
				'INSERT INTO db_paciente_hc (pac_cod) VALUES (%s)',
				SSQL($id, "int")
			);
			if (@mysqli_query(conn, $qryHc)) {
				$id_hc = @mysqli_insert_id(conn);
				$LOG .= '<p>Historial Clinica Generada</p>';
				//Registro Obstetrico
				$qryGin = sprintf(
					'INSERT INTO db_pacientes_gin (pac_cod) VALUES (%s)',
					SSQL($id, "int")
				);
				if (@mysqli_query(conn, $qryGin)) {
					$vP = TRUE;
					$id_gin = @mysqli_insert_id(conn);
					$LOG .= '<p>Registro Ginecologico Creado</p>';
				} else $LOG .= '<p>Error al Insertar</p>' . mysqli_error(conn);
			} else $LOG .= '<p>Error al Insertar</p>' . mysqli_error(conn);
		} else $LOG .= '<p>Error al Insertar</p>' . mysqli_error(conn);
		$goTo .= '?id=' . $id;
	}
	if ((isset($acc)) && ($acc == md5("UPDp"))) {
		$LOGd .= '<small>acc. UPD</small>';
		$qry = sprintf(
			'UPDATE db_pacientes SET pac_ced=%s, pac_fec=%s, pac_nom=%s, pac_ape=%s, pac_lugp=%s, pac_lugr=%s, pac_dir=%s, pac_sect=%s, pac_tel1=%s, pac_tel2=%s, pac_email=%s, pac_tipsan=%s, pac_estciv=%s, pac_hijos=%s, pac_sexo=%s, pac_raza=%s, pac_ins=%s, pac_pro=%s, pac_emp=%s, pac_ocu=%s, pac_nompar=%s, pac_telpar=%s, pac_ocupar=%s, pac_fecpar=%s, pac_tipsanpar=%s, publi=%s, pac_obs=%s, pac_tipst=%s 
		WHERE pac_cod=%s',
			SSQL($data['pac_ced'] ?? null, "text"),
			SSQL($data['pac_fec'] ?? null, "date"),
			SSQL(strtoupper($data['pac_nom'] ?? "null"), "text"),
			SSQL(strtoupper($data['pac_ape'] ?? ""), "text"),
			SSQL($data['pac_lugp'] ?? null, "text"),
			SSQL($data['pac_lugr'] ?? null, "text"),
			SSQL($data['pac_dir'] ?? null, "text"),
			SSQL($data['pac_sect'] ?? null, "text"),
			SSQL($data['pac_tel1'] ?? null, "text"),
			SSQL($data['pac_tel2'] ?? null, "text"),
			SSQL($data['pac_email'] ?? null, "text"),
			SSQL($data['pac_tipsan'] ?? null, "int"),
			SSQL($data['pac_estciv'] ?? null, "int"),
			SSQL($data['pac_hijos'] ?? null, "int"),
			SSQL($data['pac_sexo'] ?? null, "int"),
			SSQL($data['pac_raza'] ?? null, "int"),
			SSQL($data['pac_ins'] ?? null, "int"),
			SSQL($data['pac_pro'] ?? null, "text"),
			SSQL($data['pac_emp'] ?? null, "text"),
			SSQL($data['pac_ocu'] ?? null, "text"),
			SSQL($data['pac_nompar'] ?? null, "text"),
			SSQL($data['pac_telpar'] ?? null, "text"),
			SSQL($data['pac_ocupar'] ?? null, "text"),
			SSQL($data['pac_fecpar'] ?? null, "date"),
			SSQL($data['pac_tipsanpar'] ?? null, "int"),
			SSQL($data['publi'] ?? null, "text"),
			SSQL($data['pac_obs'] ?? null, "text"),
			SSQL($data['pac_tipst'] ?? null, "int"),
			SSQL($id, "int")
		);
		$LOGd .= '<small>' . $qry . '</small>';
		if (@mysqli_query(conn, $qry)) {
			$vP = TRUE;
			$LOG .= '<p>Actualizado Correctamente </p>' . $data['pac_nom'] . ' ' . $data['pac_ape'];
		} else $LOG .= '<p>Error al Actualizar Paciente</p>' . mysqli_error(conn);
		$goTo .= '?id=' . $id;
	}
}
$LOG .= mysqli_error(conn);
if ($vD == TRUE) $LOG .= $LOGd;
if ((!mysqli_error(conn)) && ($vP == TRUE)) {
	$_SESSION['sBr'] = $data['pac_nom'] . ' ' . $data['pac_ape'];
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
