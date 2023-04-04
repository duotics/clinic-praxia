<?php require_once('../../init.php');

function valMes($mes)
{
	switch (intval($mes)) {
		case 1:
			$valMes = ' Enero ';
			break;
		case 2:
			$valMes = ' Febrero ';
			break;
		case 3:
			$valMes = ' Marzo ';
			break;
		case 4:
			$valMes = ' Abril ';
			break;
		case 5:
			$valMes = ' Mayo ';
			break;
		case 6:
			$valMes = ' Junio ';
			break;
		case 7:
			$valMes = ' Julio ';
			break;
		case 8:
			$valMes = ' Agosto ';
			break;
		case 9:
			$valMes = ' Septiembre ';
			break;
		case 10:
			$valMes = ' Octubre ';
			break;
		case 11:
			$valMes = ' Noviembre ';
			break;
		case 12:
			$valMes = ' Diciembre ';
			break;
	}
	return $valMes;
}


$dat = $_REQUEST;
$fecha = $dat["rFec"] ?? null;
$dias = $dat["rDia"] ?? null;
if (!$fecha) $fecha = $sdate;
if (!$dias) $dias = 1;
$finF = null;

$fechaAnt = $fecha;
if ($dias > 1) {
	for ($x = 0; $x <= $dias - 1; $x++) {
		if ($x > 0) {
			$fecN = strtotime('+' . intval(1) . ' day', strtotime($fechaAnt));
		} else {
			$fecN = strtotime('+' . intval(0) . ' day', strtotime($fechaAnt));
		}
		setlocale(LC_ALL, "es_ES");
		$fecN = date('Y-m-d', $fecN);
		$fechaAnt = $fecN;
		$fecN = explode('-', $fecN);
		$finF[$fecN[0]][$fecN[1]] .= "$fecN[2],";
	}
} else {
	$fecN = explode('-', $fecha);
	$finF[$fecN[0]][$fecN[1]] .= "$fecN[2],";
}
$contY = 0; //Contador de Years
$contM = 0; //Contador de Months
$val .= ' ';
if ($dias > 1) {
	$val .= $dias . ' días (';
} else {
	$val .= $dias . ' día (';
}
foreach ($finF as $year => $month) {
	if ($contY > 0) $val .= ' y ';
	foreach ($month as $ma => $d) {
		if ($contM > 0) $val .= ' y ';
		$dF = substr($d, '-1');
		$dF = substr($d, 0, strlen($d) - 1);
		$val .= "$dF";
		$mF = valMes($ma);
		$val .= " de $mF";
		$contM++;
	}
	$val .= " del $year";
	$contY++;
}
$val .= ').';
if ($val) $est = 1;
else $est = 0;
$datos[] = array(
	'est' => $est,
	'val' => $val
);
echo json_encode($datos);
