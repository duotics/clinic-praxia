<?php include('../../init.php');

use App\Models\Tipo;

$mTip = new Tipo;

$vP = FALSE;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$ref = $_GET['ref'] ?? $_POST['ref'] ?? null;
$val = $_GET['val'] ?? $_POST['val'] ?? null;
$form = $_POST['form'] ?? null;
$data = $_POST;

try {
	if ($ids) $mTip->setID($ids);

	if ($form == md5('formType')) {
		switch ($acc) {
			case md5('UPDt'):
				$rP = $mTip->updateTipo(
					$data['refMod'],
					$data['refType'],
					$data['nomType'],
					$data['valType'],
					$data['auxType'],
					$data['iconType'],
					$data['status']
				);
				break;
			case md5('INSt'):
				$rP = $mTip->insertTipo(
					$data['refMod'],
					$data['refType'],
					$data['nomType'],
					$data['valType'],
					$data['auxType'],
					$data['iconType'],
					$data['status']
				);
				$ids = $rP['val'] ?? null;
				break;
		}
		$goTo .= "?k={$ids}";
	}
	if (!isset($form)) {
		switch ($acc) {
			case md5('DELt'):
				$res = $mTip->deleteTipo();
				break;
			case md5('STt'):
				$res = $mTip->changeStatus($val);
				break;
			case md5('CLONt'):
				$res = $mTip->clonTipo();
				break;
		}
		if ($res['est']) $vP = TRUE;
	}
} catch (Exception $e) {
	vP(FALSE, $e->getMessage());
}
header(sprintf("Location: %s", $goTo));
