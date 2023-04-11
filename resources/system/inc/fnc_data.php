<?php

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

/************************************************************************************************************
	FUNCIONES DATOS (seleccionados), para seleccionarlos dento del Generar Select
 ************************************************************************************************************/


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
