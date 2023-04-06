<?php include('../../init.php');

use App\Models\Componente;

$mCom = new Componente;
$id = $_REQUEST['id'] ?? null;
$ids = $_REQUEST['ids'] ?? null;
$acc = $_REQUEST['acc'] ?? null;
$val = $_REQUEST['val'] ??  null;
$goTo = $_REQUEST['url'] ?? null;
$data = $_POST;
$form = $data['form'];
$vP = FALSE;
$db->dbh->beginTransaction();
if ($form == md5('formC')) {
	switch ($acc) {
		case md5('UPDc'):
			$vP = $mCom->updateComp($ids, $data['refComp'], $data['nomComp'], $data['desComp'], $data['iconComp'], $data['status']);
			break;
		case md5('INSc'):
			$vP = $mCom->insertComp($data['refComp'], $data['nomComp'], $data['desComp'], $data['iconComp']);
			$ids = md5($vP['ret']);
			break;
	}
	$goTo .= '?ids=' . $ids;
}
switch ($acc) {
	case md5('DELc'):
		$vP = $mCom->deleteComp($ids);
		break;
	case md5('STc'):
		$vP = $mCom->changeStatus($ids, $val);
		break;
}

if (isset($vP['est'])) {
	$db->dbh->commit();
} else {
	$db->dbh->rollBack();
}
header(sprintf("Location: %s", $goTo));
