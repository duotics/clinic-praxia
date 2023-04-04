<?php require('../../init.php');

use App\Models\Laboratorio;

$mLab = new Laboratorio;

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
	if ($form == md5("fLab")) {
		$_SESSION['tab']['medf']['tabA'] = 'active';
		switch ($acc) {
			case md5("INSl"):
				$res = $mLab->insertLaboratorio($data['iNom'], $data['iDes'], $data['iEst']);
				$ids = $mLab->getID();
				break;
			case md5("UPDl"):
				$mLab->setID($ids);
				$mLab->updateLaboratorio($data['iNom'], $data['iDes'], $data['iEst']);
				break;
		}
	}
	switch ($acc) {
		case md5("DELl"):
			$mLab->setID($ids);
			$res = $mLab->deleteLaboratorio();
			break;
		case md5("STl"):
			$mLab->setID($ids);
			$res = $mLab->changeStatus($val);
			break;
	}
	$db->endTransaction();
} catch (PDOException $e) {
	$db->cancelTransaction();
	echo 'Error: ' . $e->getMessage();
}
$goToP = '?ids=' . $ids;
header(sprintf("Location: %s", $goTo . $goToP));
