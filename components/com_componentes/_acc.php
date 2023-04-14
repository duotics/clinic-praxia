<?php include('../../init.php');
$dM = $Auth->vLogin('COMP');

use App\Models\Componente;
//INSTANCIA
$mCom = new Componente;
//PARAMETROS
$id = $_REQUEST['id'] ?? null;
$ids = $_REQUEST['ids'] ?? null;
$acc = $_REQUEST['acc'] ?? null;
$val = $_REQUEST['val'] ??  null;
$goTo = $_REQUEST['url'] ?? null;
$data = $_POST;
$form = $data['form'] ?? null;
$vP = FALSE;
try {
	//TRANSACCION
	$db->dbh->beginTransaction();
	if ($form == md5($dM['ref'])) {
		switch ($acc) {
			case md5('UPDc'):
				$vP = $mCom->updateComp($ids, $data['refComp'], $data['nomComp'], $data['desComp'], $data['iconComp'], $data['status']);
				break;
			case md5('INSc'):
				$vP = $mCom->insertComp($data['refComp'], $data['nomComp'], $data['desComp'], $data['iconComp']);
				$ids = (!empty($vP['val'])) ? md5($vP['val']) : null;
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
	vP($vP['est'], $vP['log']);
	$db->dbh->commit();
} catch (PDOException $e) {
	$db->dbh->rollBack();
	vP(false, $e->getMessage());
} catch (Exception $e) {
	$db->dbh->rollBack();
	vP(false, $e->getMessage());
}
header(sprintf("Location: %s", $goTo));
