<?php
function convSig($val, $tip)
{
	switch ($tip) {
		case 'peso':
			$ret['peso-kg'] = $val . ' Kg';
			$ret['peso-lb'] = round($val * 2.20462262, 2) . ' Lb';
			break;
		case 'talla':
			$ret['talla-cm'] = $val . ' Cm';
			$ret['talla-pl'] = round($val / 2.54, 2) . ' "';
			break;
	}
	return $ret;
}
function insRow($table, $params)
{ //v.0.1
	$pIndex = implode(',', array_keys($params));
	$pValue = implode(',', array_values($params));
	$qry = sprintf(
		'INSERT INTO %s (%s) VALUES (%s)',
		SSQL($table, ''),
		SSQL($pIndex, ''),
		SSQL($pValue, '')
	);
	if (@mysqli_query(conn, $qry)) {
		$ret['est'] = TRUE;
		$ret['id'] = @mysqli_insert_id(conn);
		$ret['log'] = 'Creado correctamente';
	} else {
		$ret['est'] = FALSE;
		$ret['log'] = 'Error. ' . mysqli_error(conn);
	}
	return ($ret);
}




function detNumConAct($idc, $idp)
{

	$qryRTot = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<=%s',
		SSQL($idp, 'int'),
		SSQL($idc, 'int')
	);
	$RSRtot = mysqli_query(conn, $qryRTot);
	$row_RSRtot = mysqli_fetch_assoc($RSRtot);
	$numRTot = mysqli_num_rows($RSRtot);

	echo $numRTot;
}
function gebBtnHis($idc, $idp)
{
	$cssIni = null;
	$cssAnt = null;
	$cssFin = null;
	$cssSig = null;
	$link_ini = null;
	$link_fin = null;
	$qryTot = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s',
		SSQL($idp, 'int')
	);
	$RStot = mysqli_query(conn, $qryTot);
	$row_RStot = mysqli_fetch_assoc($RStot);
	$numTot = mysqli_num_rows($RStot);

	$qryRTot = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<=%s',
		SSQL($idp, 'int'),
		SSQL($idc, 'int')
	);
	$RSRtot = mysqli_query(conn, $qryRTot);
	$row_RSRtot = mysqli_fetch_assoc($RSRtot);
	$numRTot = mysqli_num_rows($RSRtot);

	$qryIni = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num ASC LIMIT 1',
		SSQL($idp, 'int')
	);
	$RSini = mysqli_query(conn, $qryIni);
	$row_RSini = mysqli_fetch_assoc($RSini);
	$idIni = $row_RSini['con_num'] ?? null;

	$qryFin = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num DESC LIMIT 1',
		SSQL($idp, 'int')
	);
	$RSfin = mysqli_query(conn, $qryFin);
	$row_RSfin = mysqli_fetch_assoc($RSfin);
	$idFin = $row_RSfin['con_num'] ?? null;

	$qryAnt = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s and con_num<%s ORDER BY con_num DESC LIMIT 1',
		SSQL($idp, 'int'),
		SSQL($idc, 'int')
	);
	$RSant = mysqli_query(conn, $qryAnt);
	$row_RSant = mysqli_fetch_assoc($RSant);
	$idAnt = $row_RSant['con_num'] ?? null;

	$qrySig = sprintf(
		'SELECT * FROM db_consultas WHERE pac_cod=%s and con_num>%s ORDER BY con_num ASC LIMIT 1',
		SSQL($idp, 'int'),
		SSQL($idc, 'int')
	);
	$RSsig = mysqli_query(conn, $qrySig);
	$row_RSsig = mysqli_fetch_assoc($RSsig);
	$idSig = $row_RSsig['con_num'] ?? null;

	if ($idIni == $idc) {
		$cssIni = 'disabled';
		$cssAnt = 'disabled';
	} else {
		$link_ini = 'form.php?idc=' . $row_RSini['con_num'];
	}
	if ($idFin == $idc) {
		$cssFin = 'disabled';
		$cssSig = 'disabled';
	} else {
		$link_fin = 'form.php?idc=' . $row_RSfin['con_num'];
	}

	$link_ant = 'form.php?idc=' . $idAnt;
	$link_sig = 'form.php?idc=' . $idSig;

	$btn_ini = '<a href="' . $link_ini . '" class="btn btn-default btn-sm ' . $cssIni . '"><i class="fa fa-fast-backward"></i>';
	$btn_ini .= '</a>';
	$btn_fin = '<a href="' . $link_fin . '" class="btn btn-default btn-sm ' . $cssFin . '"><i class="fa fa-fast-forward"></i>';
	$btn_fin .= '</a>';
	$btn_ant = '<a href="' . $link_ant . '" class="btn btn-default btn-sm ' . $cssAnt . '"><i class="fa fa-step-backward"></i>';
	$btn_ant .= '</a>';
	$btn_sig = '<a href="' . $link_sig . '" class="btn btn-default btn-sm ' . $cssSig . '"><i class="fa fa-step-forward"></i>';
	$btn_sig .= '</a>';
	echo $btn_ini . $btn_ant . '<span class="label label-default">' . $numRTot . ' / ' . $numTot . '</span>' . $btn_sig . $btn_fin;
}


function fnc_genthumb($path, $file, $pref, $mwidth, $mheight)
{
	$obj = new img_opt(); // Crear un objeto nuevo
	$obj->max_width($mwidth); // Decidir cual es el ancho maximo
	$obj->max_height($mheight); // Decidir el alto maximo
	$obj->image_path($path, $file, $pref); // Ruta, archivo, prefijo
	$obj->image_resize(); // Y finalmente cambiar el tamaño
}
function urlReturn($urlr, $urld = NULL)
{
	//$urlr -> URL para retornar
	//$urld -> URL defecto para el Modulo
	$urla = $_SESSION['urlp'];
	$urlc = $_SESSION['urlc'];
	if (($urlr) && ($urlr != $urlc)) {
		$urlf = $urlr;
	} else if (($urla) && ($urla != $urlc)) {
		$urlf = $urla;
	} else if (($urld) && ($urld != $urlc)) {
		$urlf = $urld;
	} else {
		$urlf = $GLOBALS['RAIZ'] . 'com_index/';
	}
	return $urlf;
}
