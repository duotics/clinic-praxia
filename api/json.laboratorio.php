<?php require_once('../init.php');
$Auth->vLogin();
$mInd = new App\Models\Indicacion;
$param = $_REQUEST['param'] ?? null;
$vP = false;
$LOG = null;
if ($param) {
	$mInd->setID($param);
	$mInd->det();
	$dMed = $mInd->det;
	if ($dMed) $vP = TRUE;
	else $LOG = "No se encontraron registros con el parametro -param- $param ";
} else $LOG = 'No existe parametro -param-';
$ret = array("est" => $vP, "val" => $dMed ?? null, "log" => $LOG);
echo json_encode($ret);
