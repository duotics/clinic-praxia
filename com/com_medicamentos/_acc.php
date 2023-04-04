<?php require('../../init.php');

use App\Models\Medicamento;
use App\Models\Indicacion;

$mMed = new Medicamento;
$mInd = new Indicacion;

$id = $_GET['id'] ?? $_POST['id'] ?? null;
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$val = $_GET['val'] ?? $_POST['val'] ?? null;
$url = $_GET['url'] ?? $_POST['url'] ?? null;
$goTo = $url;
$goToP = null;
$data = $_POST;
$form = $data['form'] ?? null;
$vP = FALSE;
try {
	$db->startTransaction();
	if ($form == md5("fmed")) {
		$_SESSION['tab']['medf']['tabA'] = 'active';
		switch ($acc) {
			case md5("INSm"):
				$res = $mMed->insertMedicamento($data['lab'], $data['generico'], $data['comercial'], $data['presentacion'], $data['cantidad'], $data['descripcion'], 1);
				$ids = $mMed->getID();
				break;
			case md5("UPDm"):
				$mMed->setID($ids);
				$mMed->updateMedicamento($data['lab'], $data['generico'], $data['comercial'], $data['presentacion'], $data['cantidad'], $data['descripcion'], $data['estado'] ?? 0);
				break;
		}
	}
	if ($form == md5("MedGrp")) {
		$_SESSION['tab']['medf']['tabB'] = 'active';
		switch ($acc) {
			case md5("INSmg"):
				$mMed->setID($ids);
				$mMed->insertMedicamentoGroup($data["idref"]);
				break;
		}
	}
	if ($form == md5("find")) {
		switch ($acc) {
			case md5("INSi"):
				$res = $mInd->insertIndicacion($data['des'], $data['feat'], $data['est']);
				$ids = $mInd->getID();
				break;
			case md5("UPDi"):
				$mInd->setID($ids);
				$res = $mInd->updateIndicacion($data['des'], $data['feat'], $data['est']);
				break;
		}
	}
	switch ($acc) {
		case md5("DELm"):
			$mMed->setID($ids);
			$res = $mMed->deleteMedicamento();
			break;
		case md5("STm"):
			$mMed->setID($ids);
			$res = $mMed->changeStatus($val);
			break;
		case md5("CLONm"):
			$mMed->setID($ids);
			$res = $mMed->clonMedicamento();
			$ids = $mMed->getID();
			break;
		case md5("DELmg"):
			$res = $mMed->deleteMedicamentoGroup($idr);
			$ids = $mMed->getID();
			$_SESSION['tab']['medf']['tabB'] = 'active';
			break;
		case md5("DELi"):
			$mInd->setID($ids);
			$res = $mInd->deleteIndicacion();
			break;
		case md5("STi"):
			$mInd->setID($ids);
			$res = $mInd->changeStatus($val);
			break;
		case md5("FTi"):
			$mInd->setID($ids);
			$res = $mInd->changeFeature($val);
			break;
	}
	$db->endTransaction();
} catch (PDOException $e) {
	$db->cancelTransaction();
	echo 'Error: ' . $e->getMessage();
}
$goToP = '?ids=' . $ids;
header(sprintf("Location: %s", $goTo . $goToP));
