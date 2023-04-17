<?php require('../init.php');
$Auth->vLogin();

$acc = $_REQUEST['acc'] ?? null;
$val = $_REQUEST['val'] ?? null;
$LOG = null;
$ret = null;
$vP = FALSE;
try {
	if ($acc) {
		switch ($acc) {
			case 'FechaToEdad':
				$ret = calcular_edad($val);
				$vP = TRUE;
				break;
			default;
				throw new Exception('Action not defined');
		}
	} else {
		throw new Exception('No action defined');
	}
} catch (Exception $e) {
	$LOG = $e->getMessage();
}

echo json_encode(array("status" => $vP, "ret" => $ret, "log" => $LOG));
