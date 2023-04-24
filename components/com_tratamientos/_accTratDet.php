<?php include("../../init.php");

use App\Models\Tratamiento;
use App\Models\Medicamento;
use App\Models\Indicacion;

$idt = $_GET['idt'] ?? $_POST['idt'] ?? null;
$idtd = $_GET['idtd'] ?? $_POST['idtd'] ?? null;
$idMed = $_GET['idMed'] ?? $_POST['idMed'] ?? null;
$idInd = $_GET['idInd'] ?? $_POST['idInd'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$data = $_GET['data'] ?? $_POST['data'] ?? null;
$mTrat = new Tratamiento;
$mMed = new Medicamento;
$mInd = new Indicacion;

$vP = FALSE;
$LOG = null;
$ret = null;

try {
	if ($acc) {
		$mTrat->setID($idt);
		$mTrat->det();
		if ($mTrat) {
			switch ($acc) {
				case "insTratDet":
					$ret = $mTrat->insertTratamientoDetalleVerifyGroup($idMed, $idInd);
					break;
				case "updTratDet":
					$mTrat->setIDsec($idtd);
					$ret = $mTrat->updateTratamientoDetalle($data);
					break;
				case "delTratDet":
					$mTrat->setIDsec($idtd);
					$ret = $mTrat->eliminarTratamientoDetalle();
					break;
			}
		} else throw new Exception("No existe tratamiento");
	} else throw new Exception("No action");
} catch (Exception $e) {
	$LOG = $e->getMessage();
}

echo json_encode($ret);
