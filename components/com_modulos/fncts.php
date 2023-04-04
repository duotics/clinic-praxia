<?php include('../../init.php');

use App\Models\Componente;

$mCom = new Componente;

$id = $_GET['id'] ?? $_POST['id'] ?? null;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$url = $_GET['url'] ?? $_POST['url'] ?? null;
$goTo = $url;
$det = $_POST;
$vP = FALSE;
if ((isset($det['form'])) && ($det['form'] == 'form_mod')) {
	if ((isset($acc)) && ($acc == md5('UPD'))) {
		$res = $mCom->updateComp($ids, $det['mod_ref'], $det['mod_nom'], $det['mod_des'], $det['mod_icon'], $det['mod_stat']);
		if ($res['est']) {
			$vP = TRUE;
			$LOG .= "<h4>Actualizado Correctamente.</h4>";
		} else $LOG .= '<h4>Error al Actualizar</h4>';
	}
	if ((isset($acc)) && ($acc == md5('INS'))) {
		$res = $mCom->insertComp($det['mod_ref'], $det['mod_nom'], $det['mod_des'], $det['mod_icon']);
		if ($res['est']) {
			$vP = TRUE;
			$id = $res['val'];
			$LOG .= "<h4>Creado Correctamente.</h4>";
		} else $LOG .= '<h4>Error al Grabar</h4>';
	}
	$goTo .= '?ids=' . $ids;
}
if ((isset($acc)) && ($acc == md5('DEL'))) {
	$res = $mCom->deleteComp($ids);
	if ($res['est']) {
		$vP = TRUE;
		$LOG .= "<h4>Eliminado Correctamente</h4>";
	} else $LOG .= '<h4>No se pudo Eliminar</h4>';
}
if ((isset($acc)) && ($acc == md5('STATUS'))) {
	$res = $mCom->changeStatus($id, $val);
	if ($res['est']) {
		$vP = TRUE;
		$LOG .= "<h4>Status Actualizado</h4>";
	} else $LOG .= '<h4>Error al Actualizar Status</h4>';
}
if ($vP == TRUE) {
	mysqli_query(conn, "COMMIT;");
	$LOGt = 'Operación Exitosa';
	$LOGc = $cfg['p']['c-ok'];
	$LOGi = $RAIZa . $_SESSION['conf']['i']['ok'];
} else {
	mysqli_query(conn, "ROLLBACK;");
	$LOGt = 'Solicitud no Procesada';
	$LOGc = $cfg['p']['c-fail'];
	$LOGi = $RAIZa . $_SESSION['conf']['i']['fail'];
}
$_SESSION['LOG']['m'] = $LOG;
$_SESSION['LOG']['c'] = $LOGc;
$_SESSION['LOG']['t'] = $LOGt;
$_SESSION['LOG']['i'] = $LOGi;
header(sprintf("Location: %s", $goTo));
