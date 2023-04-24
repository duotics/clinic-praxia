<?php include("../../init.php");

use App\Models\Tratamiento;
use App\Models\Medicamento;
use App\Models\Indicacion;

$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idd = $_GET['idd'] ?? $_POST['idd'] ?? null;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$data = $_GET['data'] ?? $_POST['data'] ?? null;
$mTrat = new Tratamiento;
$mMed = new Medicamento;
$mInd = new Indicacion;

$vP = FALSE;
$LOG = null;
$ret = null;

if ($acc) {
	switch ($acc) {
		case "insTratDet":
			$mCon->setID($idc);
			$ret = $mCon->insertTratamientoDetalleVerifyGroup($idd);
			break;
		case "updTratDet":
			$mCon->setID($idc);
			$ret = $mCon->insertConsultaDiagnosticoOther($data);
			break;
		case "delTratDet":
			$ret = $mCon->deleteConsultaDiagnostico($id);
			break;
	}
} else {
	$LOG = 'No action set';
}
echo json_encode(array("est" => $vP, "ret" => $ret, "log" => $LOG));
