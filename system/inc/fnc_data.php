<?php
function detRowNP($table, $params)
{ //v1.0
	$lP = null;
	if ($params) {
		foreach ($params as $x => $dat) {
			foreach ($dat as $y => $xVal) $lP .= $xVal['cond'] . ' ' . $xVal['field'] . ' ' . $xVal['comp'] . ' "' . $xVal['val'] . '" ';
		}
	}
	$qry = sprintf(
		"SELECT * FROM %s WHERE 1=1 " . $lP,
		SSQL($table, '')
	);
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS);
}
//Verifico la Reserva para Eliminarla
function verifyRESid($id)
{
	$LOG = null;
	$detRes = detRow('db_fullcalendar', 'id', $id);
	if ($detRes) {
		$qryUpd = sprintf(
			'UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
			SSQL('2', "text"),
			SSQL($id, "int")
		);
		if (mysqli_query(conn, $qryUpd)) {
			$LOG .= '<p>Reserva Actualizada</p>';
		} else {
			$LOG .= '<p>Error al Actualizar Reserva</p>';
		}
	}
	return $LOG;
}

//Verifico la Reserva para Eliminarla el dia actual
function verifyREShis($idp)
{
	$LOG = null;
	//$qry=sprintf('SELECT * FROM ');
	//$detRes=detRow('db_fullcalendar','id',$id);
	//if($detRes){
	$qryUpd = sprintf(
		'UPDATE db_fullcalendar SET est=%s WHERE pac_cod=%s AND fechai=%s AND est=1 LIMIT 1',
		SSQL('2', "text"),
		SSQL($idp, "int"),
		SSQL($GLOBALS['sdate'], "date")
	);
	if (mysqli_query(conn, $qryUpd)) {
		$LOG .= '<p>Reserva Actualizada</p>';
	}

	return $LOG;
	//else{
	//$LOG.='<p>Error al Actualizar Reserva</p>';
	//}
	//}
}



//Verifico la Reserva para Eliminarla
function verifyRES($idp)
{
	$LOG = null;
	$detRes = detRow2P('db_fullcalendar', 'pac_cod', $idp, 'est', '1', ' AND ');
	if ($detRes) {
		$qryUpd = sprintf(
			'UPDATE db_fullcalendar SET est=%s WHERE id=%s LIMIT 1',
			SSQL('2', "text"),
			SSQL($detRes['id'], "int")
		);
		if (mysqli_query(conn, $qryUpd)) {
			$LOG .= '<p>Reserva Actualizada</p>';
		} else {
			$LOG .= '<p>Error al Actualizar Reserva</p>';
		}
	}
}

//Datos TYPES (db_types) [OK nueva version este si va]
function dTyp($param)
{
	$qry = sprintf("SELECT * FROM  db_types WHERE typ_cod=%s", SSQL($param, 'text'));
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS);
}


//Datos Modulo Componente
function detCom($param1)
{
	$qry = sprintf("SELECT * FROM db_componentes WHERE mod_cod=%s", SSQL($param1, 'text'));
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS);
}
//ESTADO FACTURA
function estCon($est)
{
	if ($est == '0') {
		$stat['txt'] = 'Pendiente';
		$stat['inf'] = '<a class="btn disabled btn-info navbar-btn">Pendiente <i class="fa fa-exclamation-circle"></i></a>';
	} else if ($est == '1') {
		$stat['txt'] = 'Tratada';
		$stat['inf'] = '<a class="btn disabled btn-info navbar-btn">Tratada <i class="fa fa-check-square-o"></i></a>';
	} else if ($est == '2') {
		$stat['txt'] = 'Finalizada';
		$stat['inf'] = '<a class="btn disabled btn-danger navbar-btn">Finalizada <i class="fa fa-check-square-o"></i></a>';
	} else if ($est == '3') {
		$stat['txt'] = 'Anulada';
		$stat['inf'] = '<a class="btn disabled btn-danger navbar-btn">Anulada <i class="fa fa-check-square-o"></i></a>';
	} else if ($est == '5') {
		$stat['txt'] = 'Reservada';
		$stat['inf'] = '<a class="btn btn-info navbar-btn">Reservada <i class="fa fa-check-square-o"></i></a>';
	} else if (!$est) {
		$stat['txt'] = 'NO GUARDADA';
		$stat['inf'] = '<a class="btn disabled btn-danger navbar-btn">NO GUARDADA <i class="fa fa-arrow-circle-right"></i></a>';
	}
	return ($stat);
}

//ULTIMA IMAGEN DE UN PACIENTE
function lastImgPac($param1)
{
	$detMedFile = null;
	$detPacMed = detRow('db_pacientes_media', 'cod_pac', $param1, 'id', 'DESC');
	if ($detPacMed) {
		$detMed = detRow('db_media', 'id_med', $detPacMed['id_med']);
		if ($detMed) $detMedFile = $detMed['file'];
	}
	return $detMedFile;
}

/************************************************************************************************************
	FUNCIONES DATOS (seleccionados), para seleccionarlos dento del Generar Select
 ************************************************************************************************************/
function detRowSel($table, $fielID, $field, $param)
{
	$query_RS_datos = sprintf(
		'SELECT %s as sID FROM %s WHERE %s=%s',
		SSQL($fielID, ''),
		SSQL($table, ''),
		SSQL($field, ''),
		SSQL($param, 'text')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	if ($totalRows_RS_datos > 0) {
		$x = 0;
		do {
			$listCats[$x] = $row_RS_datos['sID'];
			$x++;
		} while ($row_RS_datos = mysqli_fetch_assoc($RS_datos));
	}
	mysqli_free_result($RS_datos);
	return ($listCats);
}

function detRowGSel($table, $fieldID, $fieldVal, $field, $param, $ord = FALSE, $valOrd = NULL, $ascdes = 'ASC')
{ //v1.0
	$orderBy = null;
	if ($ord) {
		if (!($valOrd)) $orderBy = 'ORDER BY ' . ' sVAL ' . $ascdes;
		else $orderBy = 'ORDER BY ' . $valOrd . ' ' . $ascdes;
	}
	$qry = sprintf(
		'SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s %s',
		SSQL($fieldVal, ''),
		SSQL($fieldID, ''),
		SSQL($table, ''),
		SSQL($field, ''),
		SSQL($param, 'text'),
		SSQL($orderBy, '')
	);
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	return ($RS);
}

//
function detRowGSel_ant($table, $fieldID, $fieldVal, $field, $param)
{
	$query_RS_datos = sprintf(
		'SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s',
		SSQL($fieldVal, ''),
		SSQL($fieldID, ''),
		SSQL($table, ''),
		SSQL($field, ''),
		SSQL($param, 'text')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	return ($RS_datos);
}

function detRowGSelNP($table, $fieldID, $fieldVal, $params, $ord = FALSE, $valOrd = NULL, $ascdes = 'ASC')
{ //v0.2
	$lP = null;
	if ($params) {
		foreach ($params as $x => $dat) {
			foreach ($dat as $y => $xVal) $lP .= $xVal['cond'] . ' ' . $xVal['field'] . ' ' . $xVal['comp'] . ' "' . $xVal['val'] . '" ';
		}
	}
	if ($ord) {
		if (!($valOrd)) $orderBy = 'ORDER BY ' . ' sVAL ' . $ascdes;
		else $orderBy = 'ORDER BY ' . $valOrd . ' ' . $ascdes;
	}
	$qry = sprintf(
		'SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 ' . $lP . ' %s',
		SSQL($fieldID, ''),
		SSQL($fieldVal, ''),
		SSQL($table, ''),
		SSQL($orderBy, '')
	);
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	return ($RS);
}

function detRow($table, $field, $param, $foN = NULL, $foF = 'ASC')
{ //v1.0
	$paramOrd = null;
	if ($foN) $paramOrd = 'ORDER BY ' . $foN . ' ' . $foF;
	$qry = sprintf(
		"SELECT * FROM %s WHERE %s = %s " . $paramOrd . ' LIMIT 1',
		SSQL($table, ''),
		SSQL($field, ''),
		SSQL($param, "text")
	);
	//echo '<hr>'.$qry.'<hr>';
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS);
}

function detRow_ant($table, $field, $param)
{
	$query_RS_datos = sprintf(
		"SELECT * FROM %s WHERE %s = %s",
		SSQL($table, ''),
		SSQL($field, ''),
		SSQL($param, "text")
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos de una TABLA / CAMPO / CONDICION
function detSigLast($id)
{
	$query_RS_datos = sprintf(
		"SELECT * FROM db_signos WHERE pac_cod = %s ORDER BY id DESC",
		SSQL($id, "int")
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos de una TABLA / CAMPO / CONDICION
function detRow2P($table, $field1, $param1, $field2, $param2, $cond)
{
	$query_RS_datos = sprintf(
		"SELECT * FROM %s WHERE %s=%s %s %s=%s",
		SSQL($table, ''),
		SSQL($field1, ''),
		SSQL($param1, "text"),
		SSQL($cond, ""),
		SSQL($field2, ""),
		SSQL($param2, "text")
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Modulo
function fnc_datamod($param1)
{
	$query_RS_datos = "SELECT * FROM db_componentes WHERE mod_ref='" . $param1 . "'";
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
//Datos Empleados
function dataEmp($param1)
{
	$query_RS_datos = sprintf(
		'SELECT * FROM db_empleados WHERE emp_cod=%s LIMIT 1',
		SSQL($param1, 'int')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
//Datos TYPES (db_types)
function fnc_datatyp($param1)
{
	$query_RS_datos = "SELECT * FROM  db_types WHERE typ_cod='" . $param1 . "'";
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
//Datos Usuario Systema
function dataUser($param1)
{
	$query_RS_datos = sprintf(
		'SELECT * FROM db_user_system WHERE user_username=%s LIMIT 1',
		SSQL($param1, 'text')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
//Datos paciente
function dataPac($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_pacientes WHERE db_pacientes.pac_cod = %s", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
//Datos paciente
function dataPachis($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_signos WHERE db_signos.pac_cod = %s ORDER BY id DESC LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Diagnostico Definitivo
function fnc_datadiagd($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_diagnosticos WHERE db_diagnosticos.id= %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Tratamiento
function fnc_datatrat($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_tratamientos WHERE tid= %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Tratamiento Detalle
function fnc_datatratd($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_tratamientos_detalle WHERE id= %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Obstetrico
function fnc_dataObs($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_obstetrico WHERE obs_id= %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Obstetrico Detalle
function fnc_dataObsd($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_obstetrico_detalle WHERE id= %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}


//Datos Examen
function fnc_dataexam($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM  db_examenes WHERE id = %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	return ($row_RS_datos);
	mysqli_free_result($RS_datos);
}

//Datos Documento Formato
function fnc_datadocf($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_documentos_formato WHERE id_df = %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Documento
function fnc_datadoc($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_documentos WHERE id_doc = %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//Datos Cirugia
function fnc_datacir($param1)
{
	$query_RS_datos = sprintf("SELECT * FROM db_cirugias WHERE id = %s LIMIT 1", SSQL($param1, "int"));
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

//TOT ROWS
function totRowsTab($table, $field = NULL, $param = NULL, $cond = '=')
{ //v.1.1
	$qryCond = null;
	// $table -> Table database
	// $field -> Campo cond
	if (($field) && ($param)) {
		$qryCond = sprintf(
			' WHERE %s %s %s',
			SSQL($field, ''),
			SSQL($cond, ''),
			SSQL($param, 'text')
		);
	}
	$qry = sprintf(
		'SELECT COUNT(*) AS TR FROM %s ' . $qryCond,
		SSQL($table, '')
	);
	$RS = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	//echo $qry.'<br>';
	return ($dRS['TR']);/*SHow me a integer value (count) of parameters*/
}
function totRowsTabP($table, $param = NULL)
{ //v.1.1
	$qry = sprintf(
		'SELECT COUNT(*) AS TR FROM %s WHERE 1=1 %s',
		SSQL($table, ''),
		SSQL($param, '')
	);
	$RS = mysqli_query(conn, stripslashes($qry)) or die(mysqli_error(conn));
	$dRS = mysqli_fetch_assoc($RS);
	return ($dRS['TR']);
}
function totRowsTab_ant($table, $field, $param)
{
	$query_RS_datos = sprintf(
		'SELECT * FROM %s WHERE %s=%s',
		SSQL($table, ''),
		SSQL($field, ''),
		SSQL($param, 'text')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	return ($totalRows_RS_datos);
}
function getParamSQLA($params)
{
	$qryParam = null;
	if ($params) {
		foreach ($params as $val) {
			if (!$val[3]) $val[3] = ' AND ';
			$qryParam .= $val[3] . ' ' . $val[0] . ' ' . $val[1] . ' "' . $val[2] . '"';
		}
	}
	return $qryParam;
}
