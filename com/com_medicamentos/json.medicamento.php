<?php require_once('../../init.php');
$mMed = new App\Models\Medicamento;
$param = $_REQUEST['param'] ?? null;
$vP = false;
$LOG = null;
if ($param) {
	$mMed->setID(md5($param));
	$dMed = $mMed->detDet();
	if ($dMed) $vP = TRUE;
	else $LOG = "No se encontraron registros con el parametro -param- $param ";
} else $LOG = 'No existe parametro -param-';
echo json_encode(array("est" => $vP, "val" => $dMed ?? null, "log" => $LOG));
