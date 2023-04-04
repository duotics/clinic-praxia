<?php require('../../init.php');
$idp = null;
$field = null;
$type = null;
$idp = $_REQUEST['idp'] ?? null;
$field = $_REQUEST['field'] ?? null;
$type = $_REQUEST['type'] ?? null;

$LOG .= 'inicio<br>';

$qS = sprintf(
	"SELECT * FROM db_signos WHERE md5(pac_cod) = %s ORDER BY id ASC",
	SSQL($idp, 'text')
);
$RS = mysqli_query(conn, $qS) or die(mysqli_error(conn));
$dRS = mysqli_fetch_assoc($RS);
$tRS = mysqli_num_rows($RS);
$LOG .= $qS . '<br>';
$LOG .= 'Rows. ' . $tRS . '<br>';
$datos = array();
if ($field) {
	if (!$type) $type = 'line';
	$LOG .= 'Field found<br>';
	$param['tit'] = 'Historial ' . $field;
	do {
		$LOG .= $dRS['fecha'] . '-' . $dRS[$field] . '<br>';
		$labels[] = $dRS['fecha'];
		switch ($field) {
			case "pa":
				$LOG .= "field pa";
				$type = 'bar';
				$valret = $dRS[$field];
				$valretd = $array = explode("/", $valret);
				$data[$field . "-SISTOLICA"][] = $valretd[0];
				$data[$field . "-DIASTOLICA"][] = $valretd[1];
				break;
			case "imc":
				$LOG .= "imc";
				$imc = calcIMCm(null, $dRS['peso'], $dRS['talla']);
				$data[$field][] = $imc['val'];
				break;
			default:
				$data[$field][] = (int)$dRS[$field];
		}
	} while ($dRS = mysqli_fetch_assoc($RS));
} else {
	if (!$type) $type = 'bar';
	$param['tit'] = 'Historial IMC / Peso / Talla';
	do {
		$IMC = calcIMC($dRS['imc'], $dRS['peso'], $dRS['talla']);
		$labels[] = $dRS['fecha'];
		$data['talla'][] = array((int)$dRS['talla']);
		$data['peso'][] = array((int)$dRS['peso']);
	} while ($dRS = mysqli_fetch_assoc($RS));
	$leg[] = array('Peso', 'Talla', 'IMC');

	//$plot->SetLegend(array('Peso', 'Talla', 'I.M.C'));
	//$plot->SetLegendWorld(0.1, 95);
	//$plot->SetLegendPosition(0.5, 0.5, 'world', 2, 60);
	//$plot->SetLegendPixels(10, 10);
}
//echo $LOG;
echo json_encode(array("idp" => $idp, "label" => $param['tit'], "type" => $type, "data" => $data, "labels" => $labels));
