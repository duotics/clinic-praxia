<?php
//Verifico La Existencia de GINECOLOGIA
function verifyGIN($id_pac, $data)
{
	$LOG = null;
	$detGIN = detRow('db_pacientes_gin', 'pac_cod', $id_pac);
	if ($detGIN) {
		$qryUpd = sprintf(
			'UPDATE db_pacientes_gin SET 
		gin_men=%s, gin_fun=%s, gin_ges=%s, gin_pnor=%s, gin_pces=%s, gin_abo=%s, gin_hviv=%s, gin_hmue=%s, gin_mes=%s, gin_obs=%s 
		WHERE gin_id=%s',
			SSQL($data['gin_men'], "text"),
			SSQL($data['gin_fun'], "date"),
			SSQL($data['gin_ges'], "int"),
			SSQL($data['gin_pnor'], "int"),
			SSQL($data['gin_pces'], "int"),
			SSQL($data['gin_abo'], "int"),
			SSQL($data['gin_hviv'], "int"),
			SSQL($data['gin_hmue'], "int"),
			SSQL($data['gin_mes'], "int"),
			SSQL($data['gin_obs'], "text"),
			SSQL($detGIN['gin_id'], "int")
		);
		if (mysqli_query(conn, $qryUpd)) {
			$LOG .= '<p>Registro Ginecologico Actualizado</p>';
		} else {
			$LOG .= '<p>Error al Actualizar Registro Ginecologico</p>';
		}
	} else {
		$qryIns = sprintf(
			'INSERT INTO db_pacientes_gin 
		(pac_cod, gin_men, gin_fun, gin_ges, gin_pnor, gin_pces, gin_abo, gin_hviv, gin_hmue, gin_mes, gin_obs) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($id_pac, "int"),
			SSQL($data['gin_men'], "text"),
			SSQL($data['gin_fun'], "date"),
			SSQL($data['gin_ges'], "int"),
			SSQL($data['gin_pnor'], "int"),
			SSQL($data['gin_pces'], "int"),
			SSQL($data['gin_abo'], "int"),
			SSQL($data['gin_hviv'], "int"),
			SSQL($data['gin_hmue'], "int"),
			SSQL($data['gin_mes'], "int"),
			SSQL($data['gin_obs'], "text")
		);
		if (mysqli_query(conn, $qryIns)) {
			$LOG .= '<p>Registro Ginecologico Creado</p>';
		} else {
			$LOG .= '<p>Error al Crear Registro Ginecologico</p>';
		}
	}
	$LOG .= mysqli_error(conn);
	return ($LOG);
}

//Verifico La Existencia de Historia Clinica
function verifyHC($id_pac, $data)
{
	$LOG = null;
	$detHC = detRow('db_paciente_hc', 'pac_cod', $id_pac);
	if ($detHC) {
		$qryUpd = sprintf(
			'UPDATE db_paciente_hc SET hc_cir_pre=%s, hc_antf=%s, hc_antf=%s, hc_antp=%s, hc_hab=%s, hc_ale=%s, hc_cau_inf=%s, hc_cic_ra=%s, hc_obs=%s WHERE hc_id=%s',
			SSQL($data['hc_cir_pre'], "text"),
			SSQL($data['hc_antf'], "text"),
			SSQL($data['hc_antf'], "text"),
			SSQL($data['hc_antp'], "text"),
			SSQL($data['hc_hab'], "text"),
			SSQL($data['hc_ale'], "text"),
			SSQL($data['hc_cau_inf'], "text"),
			SSQL($data['hc_cic_ra'], "text"),
			SSQL($data['hc_obs'], "text"),
			SSQL($detHC['hc_id'], "int")
		);
		//echo $qryUpd;
		if (mysqli_query(conn, $qryUpd)) {
			$LOG .= '<p>Historia Clinica Actualizado</p>';
		} else {
			$LOG .= '<p>Error al Actualizar Historia Clinica</p>';
		}
	} else {
		$qryIns = sprintf(
			'INSERT INTO db_paciente_hc (pac_cod,hc_cir_pre,hc_antf,hc_antp,hc_hab,hc_ale,hc_cau_inf,hc_cic_ra,hc_obs) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($id_pac, "int"),
			SSQL($data['hc_cir_pre'], "text"),
			SSQL($data['hc_antf'], "text"),
			SSQL($data['hc_antp'], "text"),
			SSQL($data['hc_hab'], "text"),
			SSQL($data['hc_ale'], "text"),
			SSQL($data['hc_cau_inf'], "text"),
			SSQL($data['hc_cic_ra'], "text"),
			SSQL($data['hc_obs'], "text")
		);
		//echo $qryIns;
		if (mysqli_query(conn, $qryIns)) {
			$LOG .= '<h4>Crear Historia Clinica</h4>';
		} else {
			$LOG .= '<h4>Error Crear Historia Clinica</h4>';
		}
	}
	$LOG .= mysqli_error(conn);
	return ($LOG);
}
//FUNCION AUDITORIA
function AUD($id = NULL, $des = NULL, $eve = NULL)
{
	$id_aud = null;
	//Generación Descrición ($des), dependiendo del Evento ($eve)
	switch ($eve) {
		case 'sysacc': {
				$_SESSION['data_access'] = $GLOBALS['sdatet'];
				$des = 'IP. ' . getRealIpAddress();
				break;
			}
		default: {
			}
	}

	//Pregunto si existe id_aud ($id)
	if ($id) {
		//Pregunto Si db_auditoria Existente
		$detAud = detRow('db_auditoria', 'id_aud', $id);
		if ($detAud) {
			$id_aud = $detAud['id_aud'];
			//INSERTO db_auditoria_Detalle
			$qry = sprintf(
				'INSERT INTO db_auditoria_detalle (id_aud, user_cod, audd_datet, audd_eve, audd_des) 
			VALUES (%s,%s,%s,%s,%s)',
				SSQL($id, 'int'),
				SSQL($_SESSION['dU']['ID'], 'int'),
				SSQL($GLOBALS['sdatet'], 'text'),
				SSQL($eve, 'text'),
				SSQL($des, 'text')
			);
			@mysqli_query(conn, $qry);
		}
	} else {
		//INSERT db_auditoria
		$qryAud = sprintf(
			'INSERT INTO db_auditoria (aud_datet) 
		VALUES (%s)',
			SSQL($GLOBALS['sdatet'], 'text')
		);
		@mysqli_query(conn, $qryAud);
		$id_aud = mysqli_insert_id(conn);

		//INSERT db_auditoria_detalle
		$qryAudDet = sprintf(
			'INSERT INTO db_auditoria_detalle (id_aud, user_cod, audd_datet, audd_eve, audd_des) 
		VALUES (%s,%s,%s,%s,%s)',
			SSQL($id_aud, 'int'),
			SSQL($_SESSION['dU']['ID'], 'int'),
			SSQL($GLOBALS['sdatet'], 'text'),
			SSQL($eve, 'text'),
			SSQL($des, 'text')
		);
		@mysqli_query(conn, $qryAudDet);
	}
	return ($id_aud);
}
//Datos AUDITORIA
function infAud($id)
{
	$detAudi = dataAud($id, 'ASC');
	$detAudi_id = $detAudi['id'];
	$detAudi_user = $detAudi['emp_nom'] . ' ' . $detAudi['emp_ape'];
	$detAudi_inf = '<small>' . $detAudi_user . ' ' . $detAudi['audd_datet'] . '</small>';

	$detAudf = dataAud($id, 'DESC');
	$detAudf_id = $detAudf['id'];

	if ($detAudi_id != $detAudf_id) {
		$detAudf_user = $detAudf['emp_nom'] . ' ' . $detAudf['emp_ape'];
		$detAudf_inf = "Actualización. " . $detAudf_user . ' ' . $detAudf['audd_datet'];
	}

	$infAud = '<span title="' . $detAudf_inf . '" class="tooltips">' . $detAudi_inf . '</span>';
	return $infAud;
}

function dataAud($param1, $ord = 'DESC')
{
	$query_RS_datos = sprintf(
		'SELECT * FROM db_auditoria_detalle 
	LEFT JOIN db_user_system ON db_auditoria_detalle.user_cod=db_auditoria_detalle.user_cod 
	INNER JOIN db_empleados ON db_user_system.emp_cod=db_empleados.emp_cod 
	WHERE db_auditoria_detalle.id_aud=%s ORDER BY db_auditoria_detalle.id %s LIMIT 1',
		SSQL($param1, 'text'),
		SSQL($ord, '')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
