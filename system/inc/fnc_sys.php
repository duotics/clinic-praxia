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

function genStatus($dest, $params, $css = NULL)
{ //v.2.0
	$lP = NULL;
	$firstP = TRUE;
	foreach ($params as $x => $xVal) {
		if ($x == 'val') {
			if ($xVal == 1) {
				$xVal = 0;
				$cssST = 'btn btn-success btn-xs';
				$txtST = '<span class="glyphicon glyphicon-ok"></span>';
			} else {
				$xVal = 1;
				$cssST = 'btn btn-warning btn-xs';
				$txtST = '<span class="glyphicon glyphicon-remove"></span>';
			}
		}
		if ($firstP == TRUE) {
			$lP .= '?' . $x . '=' . $xVal;
			$firstP = FALSE;
		} else $lP .= '&' . $x . '=' . $xVal;
	}
	$st = '<a href="' . $dest . $lP . '" class="' . $cssST . ' ' . $css . '">' . $txtST . '</a>';
	return $st;
}

function edadC($dateBorn)
{
	$ret = NULL;
	if ($dateBorn) {
		$dateAct = $GLOBALS['sdate']; // separamos en partes las fechas 
		$array_nacimiento = explode("-", $dateBorn);
		$array_actual = explode("-", $dateAct);
		$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
		$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
		$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 
		//ajuste de posible negativo en $días 
		if ($dias < 0) {
			--$meses;
			//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
			switch ($array_actual[1]) {
				case 1:
					$dias_mes_anterior = 31;
					break;
				case 2:
					$dias_mes_anterior = 31;
					break;
				case 3:
					if (bisiesto($array_actual[0])) {
						$dias_mes_anterior = 29;
						break;
					} else {
						$dias_mes_anterior = 28;
						break;
					}
				case 4:
					$dias_mes_anterior = 31;
					break;
				case 5:
					$dias_mes_anterior = 30;
					break;
				case 6:
					$dias_mes_anterior = 31;
					break;
				case 7:
					$dias_mes_anterior = 30;
					break;
				case 8:
					$dias_mes_anterior = 31;
					break;
				case 9:
					$dias_mes_anterior = 31;
					break;
				case 10:
					$dias_mes_anterior = 30;
					break;
				case 11:
					$dias_mes_anterior = 31;
					break;
				case 12:
					$dias_mes_anterior = 30;
					break;
			}
			$dias = $dias + $dias_mes_anterior;
		}
		//ajuste de posible negativo en $meses 
		if ($meses < 0) {
			--$anos;
			$meses = $meses + 12;
		}
		$ret = $anos . " años <br> " . $meses . " meses <br> " . $dias . " días ";
	} else $ret;
	return ($ret);
}

function bisiesto($anio_actual)
{
	$bisiesto = false;
	//probamos si el mes de febrero del año actual tiene 29 días 
	if (checkdate(2, 29, $anio_actual)) {
		$bisiesto = true;
	}
	return $bisiesto;
}

//END FUNCTION LOGIN
//BEG GENERACION MENU
function genMenu($refMC, $css = NULL, $vrfUL = TRUE)
{
	$ret = null;
	//Consulta para Menus Principales
	$qry = sprintf(
		"SELECT * FROM tbl_menus_items 
	INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
	INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
	WHERE tbl_menus.ref = %s 
	AND tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s 
	AND tbl_menus_items.men_stat = %s 
	ORDER BY men_orden ASC",
		SSQL($refMC, 'text'),
		SSQL('0', 'int'),
		SSQL($_SESSION['dU']['ID'], 'int'),
		SSQL('1', 'text')
	);
	$RSmp = mysqli_query(conn, $qry) or die(mysqli_error(conn));
	$dRSmp = mysqli_fetch_assoc($RSmp);
	$tRSmp = mysqli_num_rows($RSmp);
	if ($tRSmp > 0) {
		do {
			//Consulta para Submenus
			$qry2 = sprintf(
				"SELECT * FROM tbl_menus_items 
			INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
			WHERE tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s AND tbl_menus_items.men_stat = %s 
			ORDER BY men_orden ASC",
				SSQL($dRSmp['men_id'], 'int'),
				SSQL($_SESSION['dU']['ID'], 'int'),
				SSQL(1, 'int')
			);
			$RSmi = mysqli_query(conn, $qry2) or die(mysqli_error(conn));
			$dRSmi = mysqli_fetch_assoc($RSmi);
			$tRSmi = mysqli_num_rows($RSmi);
			if ($tRSmi > 0) $cssSM = "dropdown";
			else $cssSM = "";
			if ($dRSmp['men_link']) $link = $GLOBALS['RAIZc'] . $dRSmp['men_link'];
			else $link = "#";
			if ($dRSmp['men_precode']) $ret .= $dRSmp['men_precode'];
			$ret .= '<li class="' . $cssSM . '">';
			if ($tRSmi > 0) {
				$ret .= '<a href="' . $link . '" class="dropdown-toggle"';
				if ($tRSmi > 0) {
					$ret .= 'data-toggle="dropdown"';
				}
				$ret .= '>';
				if ($dRSmp['men_icon']) $ret .= '<i class="' . $dRSmp['men_icon'] . '"></i> ';
				$ret .= $dRSmp['men_tit'];
				if ($tRSmi > 0) {
					$ret .= ' <b class="caret"></b>';
				}
				$ret .= '</a>';
				$ret .= '<ul class="dropdown-menu">';
				do {
					if ($dRSmi['men_link']) {
						$link = $GLOBALS['RAIZc'] . $dRSmi['men_link'];
					} else {
						$link = "#";
					}
					if ($dRSmi['men_precode']) $ret .= $dRSmi['men_precode'];
					$ret .= '<li><a href="' . $link . '">';
					if ($dRSmi['men_icon']) $ret .= '<i class="' . $dRSmi['men_icon'] . '"></i> ';
					$ret .= $dRSmi['men_tit'] . '</a></li>';
					if ($dRSmi['men_postcode']) $ret .= $dRSmi['men_postcode'];
				} while ($dRSmi = mysqli_fetch_assoc($RSmi));
				mysqli_free_result($RSmi);
				$ret .= '</ul>';
			} else {

				$ret .= '<a href="' . $link . '">';
				if ($dRSmp['men_icon']) $ret .= '<i class="' . $dRSmp['men_icon'] . '"></i> ';
				$ret .= $dRSmp['men_tit'] . '</a>';
			}
			$ret .= '</li>';
			if ($dRSmp['men_postcode']) $ret .= $dRSmp['men_postcode'];
		} while ($dRSmp = mysqli_fetch_assoc($RSmp));
		mysqli_free_result($RSmp);
	} else {
		$ret .= null; //'<li>No existen menus para <strong>'.$refMC.'</strong></li>';
	}
	//Verifica si solicito UL, si no devolveria solo LI
	if ($vrfUL) $ret = '<ul class="' . $css . '">' . $ret . '</ul>';
	return $ret;
}
//END GENERACION MENU
//Funcion para visualizar status v.2.0
function fncStat($dest, $params, $css = NULL)
{
	$lP = null;
	$firstP = TRUE;
	foreach ($params as $x => $xVal) {
		if ($x == 'val') {
			if ($xVal == 1) {
				$xVal = 0;
				$cssST = 'btn btn-success btn-xs';
				$txtST = '<span class="glyphicon glyphicon-ok"></span>';
			} else {
				$xVal = 1;
				$cssST = 'btn btn-warning btn-xs';
				$txtST = '<span class="glyphicon glyphicon-remove"></span>';
			}
		}
		if ($firstP == TRUE) {
			$lP .= '?' . $x . '=' . $xVal;
			$firstP = FALSE;
		} else $lP .= '&' . $x . '=' . $xVal;
	}
	$st = '<a href="' . $dest . $lP . '" class="' . $cssST . ' ' . $css . '">' . $txtST . '</a>';
	return $st;
}

//GENERATE PAGE HEADER MODULE COMPONENT

function genHeader($MOD = null, $tip = 'page-header', $cont = NULL, $floatR = NULL, $floatL = NULL, $css = 'mb-2', $tag = 'h1')
{ //duotics_lib->v.0.11
	$ret = null;
	$retMod = null;
	switch ($tip) {
		case 'card':
			if ($MOD) {
				if (isset($MOD['mod_icon'])) $retMod .= '<span class="label label-default"><i class="' . $MOD['mod_icon'] . '"></i></span>';
				$retMod .= '<span class="label label-primary">' . $MOD['mod_nom'] . '</span>';
			}
			$ret .= '<div class="card mt-2 mb-2 ' . $css . '">';
			$ret .= '	<div class="card-body">';
			$ret .= '		<div class="btn-group float-right">';
			$ret .=		$floatR;
			$ret .= '		</div>';
			$ret .= '		<h2 class="mb-0">';
			$ret .=		$retMod . ' ' . $cont;
			$ret .= '		</h2>';
			$ret .= '	</div>';
			$ret .= '</div>';
			break;
		case 'page-header':
			if ($MOD) {
				$retMod .= '<span class=""><i class="' . ($MOD['mod_icon'] ?? null) . '"></i></span> ';
				$retMod .= '<span class="label label-primary">' . ($MOD['id'] ?? null) . '</span> ';
				$retMod .= '<span class="">' . $MOD['mod_nom'] . '</span> ';
				$retMod .= '<small class="label label-default">' . ($MOD['mod_des'] ?? null) . '</small>';
			}
			$ret .= '<div class="page-header mt-2 mb-2 ' . $css . '">';
			if ($floatL) $ret .= '<div class="pull-left">' . $floatL . '</div>';
			if ($floatR) $ret .= '<div class="pull-right">' . $floatR . '</div>';
			$ret .= '<' . $tag . '>';
			$ret .= $retMod . ' ' . $cont;
			$ret .= '</' . $tag . '>';
			$ret .= '</div>';
			break;
		case 'header':
			if ($MOD) {
				$retMod .= '<span class=""><i class="' . ($MOD['mod_icon'] ?? null) . '"></i></span> ';
				$retMod .= '<span class="">' . $MOD['mod_nom'] . '</span> ';
				$retMod .= '<small class="badge badge-light">' . ($MOD['mod_des'] ?? null) . '</small>';
			}
			$ret .= '<div class="border-bottom mt-2 mb-2 ' . $css . '">';
			if ($floatL) $ret .= '<div class="pull-left">' . $floatL . '</div>';
			if ($floatR) $ret .= '<div class="pull-right">' . $floatR . '</div>';
			$ret .= '<' . $tag . '>';
			$ret .= $retMod . ' ' . $cont;
			$ret .= '</' . $tag . '>';
			$ret .= '</div>';
			break;
		case 'navbar':
			$ret .= '<nav class="navbar navbar-default ' . $css . '">
			<div class="container-fluid">
			<a class="navbar-brand" href="#">
			<i class="' . ($MOD['mod_icon'] ?? null) . '"></i> ' .
				($MOD['mod_nom'] ?? null) . ' <small class="label label-default">' . ($MOD['mod_des'] ?? null) . '</small>
			</a>
			<ul class="nav navbar-nav mr-auto">
			' . $cont . '
			</ul>
			</div>
			</nav>';
			break;
		default:
			$ret = '<div>';
			if (isset($MOD['mod_cod'])) $ret .= ' <span class="badge badge-secondary">' . $MOD['mod_cod'] . '</span> ';
			$ret .= $MOD['mod_nom'] ?? null;
			$ret .= '<div>';
			break;
	}
	return $ret;
}

function genPageHeader_old($MOD, $tip = 'page-header', $tit = NULL, $tag = 'h1', $id = NULL, $des = NULL, $icon = NULL, $floatL = NULL, $floatR = NULL)
{ //duotics_lib->v.0.11
	if (!isset($tag) || ($tag == '')) $tag = 'h1';
	$banMod = FALSE;
	if ($MOD) {
		$dM = detCom($MOD);
		if (!$dM['mod_nom']) $dM['mod_nom'] = $dM['men_tit'];
		if ($dM) $banMod = TRUE;
	}
	if (!$banMod) {
		$dM['mod_nom'] = $tit;
		$dM['mod_cod'] = $id;
		$dM['mod_des'] = $des;
		$dM['mod_icon'] = $icon;
	}
	$ret = null;
	switch ($tip) {
		case 'page-header':
			$ret .= '<div class="page-header">';
			if ($floatL) $ret .= '<div class="pull-left">' . $floatL . '</div>';
			if ($floatR) $ret .= '<div class="pull-right">' . $floatR . '</div>';
			$ret .= '<' . $tag . '>';
			if ($dM['mod_icon']) $ret .= ' <i class="' . $dM['mod_icon'] . '"></i> ';
			if ($id) $ret .= ' <span class="badge badge-primary">' . $dM['mod_cod'] . '</span> ';
			$ret .= $dM['mod_nom'];
			$ret .= ' <small>' . $dM['mod_des'] . '</small>';
			$ret .= '</' . $tag . '>';
			$ret .= '</div>';
			break;
		case 'navbar':
			$ret .= '<nav class="navbar navbar-default">';
			$ret .= '<div class="container-fluid">';
			$ret .= '<div class="navbar-header">';
			$ret .= '<a class="navbar-brand" href="#">' . $dM['mod_nom'];
			$ret .= ' <small class="badge badge-secondary">' . $dM['mod_des'] . '</small></a>';
			$ret .= '</div>';
			$ret .= '</div></nav>';
			break;
		case 'card':
			$ret .= '<div class="card mb-2">';
			$ret .= '	<div class="card-body">';
			$ret .= '		<div class="btn-group float-right">';
			$ret .= $floatR;
			$ret .= '		</div>';
			$ret .= '		<h2 class="mb-0">';
			$ret .= '			<?php echo $wp1 ?>';
			$ret .= '			<span class="badge badge-secondary">' . $dM['mod_nom'] . '</span>';
			$ret .= '			<span class="badge badge-primary"><?php echo $id ?></span>';
			$ret .= '			<?php echo $dFile["tit"] ?>';
			$ret .= '		</h2>';
			$ret .= '	</div>';
			$ret .= '</div>';
		default:
			$ret .= '<div>';
			if ($id) $ret .= ' <span class="badge badge-secondary">' . $dM['mod_cod'] . '</span> ';
			$ret .= $dM['mod_nom'];
			$ret .= '<div>';
			break;
	}
	return $ret;
}

function genPageHead_old($MOD, $tit = NULL, $tag = 'h1', $id = NULL, $des = NULL, $icon = NULL)
{
	$banMod = FALSE;
	if ($MOD) {
		$rowMod = detCom($MOD);
		if ($rowMod) {
			$banMod = TRUE;
		}
	}
	if ($banMod == FALSE) {
		$rowMod['mod_nom'] = $tit;
		$rowMod['mod_cod'] = $id;
		$rowMod['mod_des'] = $des;
		$rowMod['mod_icon'] = $icon;
	}
	$returnTit = null;
	$returnTit .= '<div class="page-header">';
	$returnTit .= '<' . $tag . '>';
	if ($rowMod['mod_icon']) {
		$returnTit .= ' <i class="' . $rowMod['mod_icon'] . '"></i> ';
	}
	if ($id) {
		$returnTit .= ' <span class="label label-primary">' . $rowMod['mod_cod'] . '</span> ';
	}
	$returnTit .= $rowMod['mod_nom'];
	$returnTit .= ' <small>' . $rowMod['mod_des'] . '</small>';
	$returnTit .= '</' . $tag . '>';
	$returnTit .= '</div>';

	return $returnTit;
}

function gen_pageTit_old($MOD, $tit = NULL, $des = NULL, $icon = NULL)
{
	$banMod = FALSE;
	if ($MOD) {
		$rowMod = fnc_datamod($MOD);
		if ($rowMod) {
			$banMod = TRUE;
		}
	}
	if ($banMod == FALSE) {
		$rowMod['mod_nom'] = $tit;
		$rowMod['mod_des'] = $des;
		$rowMod['mod_icon'] = $icon;
	}
	$returnTit = null;
	$returnTit .= '<div class="page-header">';
	$returnTit .= '<h2>';
	if ($rowMod['mod_icon']) {
		$returnTit .= ' <span class="' . $rowMod['mod_icon'] . '"></span> ';
	}
	$returnTit .= $rowMod['mod_nom'];
	$returnTit .= ' <small>' . $rowMod['mod_des'] . '</small>';
	$returnTit .= '</h2>';
	$returnTit .= '</div>';

	return $returnTit;
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
