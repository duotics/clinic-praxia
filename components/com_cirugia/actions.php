<?php include('../../init.php');

use App\Models\Cirugia;

$mCir = new Cirugia;

$vP = FALSE; //Inicializa Estado Transaccion
$id = $_GET['id'] ?? $_POST['id'] ?? null; //ID STANDAR
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null; //ID REF -> ID CIRUGIA
//VARIABLE ACCION Y REDIRECCION
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$goToParam = null;
$accjs = null;

if ($idr) {
	$mCir->setID($idr);
	$mCir->det();
	$idCir = $mCir->getID();
}
if ((isset($_POST['form'])) && ($_POST['form'] == md5("fCir"))) {
	$mCir->uploadMedia($_FILES['efile'] ?? null, $idCir ?? null); //IMAGE FILES UPLOAD
	switch ($acc) {
		case md5("INSc"):
			$res = $mCir->insertCir($_POST['idp'], $_POST['idc'], $sdate, $_POST['diagnostico'], $_POST['cirugiar'], $_POST['fechar'], $_POST['protocolo'], $_POST['evolucion']);
			$idr = md5($res['val']);
			break;
		case md5("UPDc"):
			$res = $mCir->updateCir($idr, $_POST['diagnostico'], $_POST['cirugiar'], $_POST['fechar'], $_POST['protocolo'], $_POST['evolucion']);
			break;
	}
	$goTo .= "?idr=$idr";
}
// BEG ACC FUNCTIONS
switch ($acc) {
	case md5("DELc"):
		$accjs = TRUE; //Action JS
		$res = $mCir->deleteCir($idr);
		break;
	case md5("DELcm"):
		$res = $mCir->deleteMedia($id);
		$idr = $mCir->getID(TRUE);
		$goToParam = "?idr=$idr";
		break;
}

vP($res['est'], $res['log']);

if ($accjs) echo "<script>parent.location.reload();</script>";
else header("Location: {$goTo}{$goToParam}");
