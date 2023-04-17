<?php
include_once(RAIZv . 'davefx/phplot/phplot/phplot.php');
include_once('inc/enLetras.class.php');
include_once('inc/paginator.class.php');
include_once('inc/class.image-resize.php');
include_once(RAIZv . 'spipu/html2pdf/src/Html2Pdf.php');

//FUNCIONES SISTEMA CLINIC
require_once('inc/fnc_data.php');
require_once('inc/fnc_sys.php');
require_once('inc/fnc_gen.php');
require_once('inc/fnc_tra.php');
require_once('inc/fncDocs.php');


//Deshabilitar Reservas
function disable_reserv($con_fin, $pac_fin)
{
	if (@mysql_result(@mysqli_query(conn, "SELECT * FROM db_consultas_reserva WHERE con_num='$con_fin' AND pac_cod='$pac_fin'"), 'cons_res_num')) {
		if (@mysqli_query(conn, "DELETE FROM db_consultas_reserva WHERE con_num='$con_fin' AND pac_cod='$pac_fin'") or ($res_fun = mysqli_error(conn)))
			$res_fun .= "Eliminada Reserva";
		else
			$res_fun .= "Falla Eliminación Reserva";
	}
	return $res_fun;
}
/*
// Calcula la edad (formato: año/mes/dia)
function edad($edad){
if($edad){
list($anio,$mes,$dia) = explode("-",$edad);
$anio_dif = date("Y") - $anio; $mes_dif = date("m") - $mes; $dia_dif = date("d") - $dia;
if ($dia_dif < 0 || $mes_dif < 0) $anio_dif--;
return $anio_dif.' Años';
}else return '-';
}*/

//Sesiones Pendientes de Tratamiento de una Terapia
function fnc_ses_pen($ter_num)
{
	if (@mysqli_query(conn, "SELECT * FROM tbl_sesiones WHERE ses_status='0' AND ter_num='$ter_num'")) {
		$all_RS_ter_pen = mysqli_query(conn, "SELECT * FROM tbl_sesiones WHERE ses_status='0' AND ter_num='$ter_num'");
		$res = mysqli_num_rows($all_RS_ter_pen);
	} else $res = 0;
	return $res;
}
//Sesiones Realizadas (Tratadas) de una Terapia
function fnc_ses_real($ter_num)
{
	if (@mysqli_query(conn, "SELECT * FROM tbl_sesiones WHERE ses_status='0' AND ter_num='$ter_num'")) {
		$all_RS_ter_pen = mysqli_query(conn, "SELECT * FROM tbl_sesiones WHERE ses_status='1' AND ter_num='$ter_num'");
		$res = mysqli_num_rows($all_RS_ter_pen);
	} else $res = 0;
	return $res;
}


//Numero de Factura mas alto
function fnc_datafacnum()
{
	$query_RS_datos = "SELECT max(fac_num) as num FROM tbl_factura";
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	return ($row_RS_datos);
	mysqli_free_result($RS_datos);
}

function exam_numimg($param1)
{
	$query_RS_datos = sprintf(
		'SELECT COUNT(*) AS IMGE FROM `tbl_examenes_img` WHERE `idexamen`=%s',
		SSQL($param1, 'int')
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	return ($row_RS_datos['IMGE']);
	mysqli_free_result($RS_datos);
}


function uploadfile_ant($params, $file)
{
	$code = substr(md5(uniqid(rand())), 0, 6) . '_';
	$prefijo = '_' . $code . '_';
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam, '.'), strlen($fileextnam) - 1); // Saca su extension
	$filename = $prefijo . $params['pac'] . $ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab = 0; //Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	if (!in_array($ext, $params['ext'])) // Verifica si la extension es valida
	{
		$resultado .= ':: Archivo no Valido (permitido: ' . $params['ext'] . ') ::<br />';
		$aux_grab = 1;
	} else {
		if (filesize($file['tmp_name']) > $params['siz']) // Verifica el tamaño maximo
		{
			$resultado .= ':: Archivo Demasiado Grande :: maximo ' . ($params['siz'] / 1024 / 1024) . ' MB<br />';
			$aux_grab = 1;
		} else {
			if (!is_writable($params['pat'])) // Verifica permisos.
			{
				$resultado .= ':: Permisos Folder Insuficientes, contacte al Administrador del Sistema ::<br />';
				$aux_grab = 1;
			} else { // Mueve el archivo a su lugar correpondiente.
				if (move_uploaded_file($file['tmp_name'], $params['pat'] . $filename)) $archivo = $params['pat'] . $filename;
				else {
					$resultado .= ':: Error al cargar el archivo ::<br />';
					$aux_grab = 1;
				}
			}
		}
	}
	$auxres[0] = $resultado;
	$auxres[1] = $aux_grab;
	$auxres[2] = $filename;
	return $auxres;
}

function fnc_maxnumcons($id_pac)
{
	$id_pac_ct_RS_cons_tot = "-1";
	if (isset($id_pac)) {
		$id_pac_ct_RS_cons_tot = $id_pac;
	}
	$query_RS_cons_tot = 'SELECT MAX(con_num) as maxnumcons FROM db_consultas WHERE pac_cod=' . $id_pac_ct_RS_cons_tot;
	$RS_cons_tot = mysqli_query(conn, $query_RS_cons_tot) or die(mysqli_error(conn));
	$row_RS_cons_tot = mysqli_fetch_assoc($RS_cons_tot);
	$totalRows_RS_cons_tot = mysqli_num_rows($RS_cons_tot);
	return $row_RS_cons_tot['maxnumcons'];
	mysqli_free_result($RS_cons_tot);
}




function fnc_cutblanck($bus)
{
	if (substr($bus, 0, 1) == ' ') $bus = substr($bus, 1, strlen($bus));
	if (substr($bus, strlen($bus) - 1, 1) == ' ') $bus = substr($bus, 0, strlen($bus) - 1);
	return ($bus);
}
function fnc_gencad_search()
{
	session_start();
	$busqueda = fnc_cutblanck($_SESSION['sBr']);
	$trozos = explode(" ", $busqueda);
	$numero = count($trozos);
	if ($numero == 1) $cadbusca = 'SELECT * FROM db_pacientes_temp where fullname LIKE "%' . $busqueda . '%" ORDER BY cod_pac DESC';
	if ($numero > 1) $cadbusca = 'SELECT cod_pac, fullname, MATCH (fullname) AGAINST ("' . $busqueda . '") AS Score FROM db_pacientes_temp WHERE MATCH (fullname) AGAINST ("' . $busqueda . '") ORDER BY Score DESC';
	return $cadbusca;
}
function tableExists($table_name)
{
	$Table = mysqli_query(conn, "show tables like '" . $table_name . "'");
	if (mysql_fetch_row($Table) === false) return ("0");
	else return ("1");
}

//FUNCION REGISTRA ACCESO DE USUARIOS
function fnc_acces_usersys($param1)
{
	$accessDate = date('Y-m-d H:i:s', time() - 3600);
	$_SESSION['data_access'] = $accessDate;
	$accessIp = getRealIP();
	$qryINS = sprintf(
		'INSERT INTO db_user_access (user_cod, access_datet, access_ip) VALUES (%s, %s, %s)',
		SSQL($param1, 'int'),
		SSQL($accessDate, 'text'),
		SSQL($accessIp, 'text')
	);
	mysqli_query(conn, $qryINS) or die(mysqli_error(conn));
}
//Detalle factura
function fnc_datacons($param1, $param2)
{
	$query_RS_datos = sprintf(
		"SELECT * FROM db_consultas INNER JOIN db_pacientes ON db_consultas.pac_cod=db_pacientes.pac_cod WHERE db_consultas.con_num=%s AND db_consultas.pac_cod=%s",
		SSQL($param1, "int"),
		SSQL($param2, "int")
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
//Ultima Consulta
function fnc_lastcons($param1)
{
	$query_RS_datos = sprintf(
		"SELECT * FROM db_consultas WHERE db_consultas.pac_cod=%s ORDER BY db_consultas.con_num DESC",
		SSQL($param1, "int")
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}
function fnc_dataTerPacCons($param1, $param2)
{
	$query_RS_datos = sprintf(
		"SELECT * FROM tbl_terapias WHERE con_num = %s AND pac_cod=%s",
		SSQL($param1, "int"),
		SSQL($param2, "int")
	);
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($row_RS_datos);
}

function date_ame2euro($date = NULL)
{
	if (!$date) $datef = date('d-m-Y');
	else $datef = date("d-m-Y", strtotime($date));
	return $datef;
}

function dias_transcurridos($FUM, $FACT)
{
	$dias = (strtotime($FUM) - strtotime($FACT)) / 86400;
	$dias = abs($dias);
	$dias = floor($dias);
	return $dias;
}
function fnc_obst_fpp($FUM)
{
	return date('Y-M-d', strtotime('+8 days, -3 month, +1 year', strtotime($FUM)));
}
function fnc_obst_semges($FUM, $sdate)
{
	if ($FUM <= $sdate) return number_format((dias_transcurridos($FUM, $sdate) / 7), 1);
	else {
		return "Error";
	}
}
function fnc_obst_mesesvida($fIni, $fFin)
{
	$fIni = new DateTime($fIni);
	$fFin = new DateTime($fFin);
	$diferencia = $fIni->diff($fFin);
	$meses = ($diferencia->y * 12) + $diferencia->m;
	return $meses;
}
function fnc_totpac()
{
	$query_RS_datos = sprintf("SELECT * FROM db_pacientes");
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($totalRows_RS_datos);
}
function fnc_totCons()
{
	$query_RS_datos = sprintf("SELECT * FROM db_consultas");
	$RS_datos = mysqli_query(conn, $query_RS_datos) or die(mysqli_error(conn));
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	mysqli_free_result($RS_datos);
	return ($totalRows_RS_datos);
}
