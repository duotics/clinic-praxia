<?php include('../init.php');
$paramTbl = $_GET['tbl'] ?? null;
$paramField = $_GET['campo'] ?? null;
$paramValue = $_GET['valor'] ?? null;
$paramID = $_GET['cod'] ?? null;
$vP = false;
$LOG = null;
try {
	//$db->startTransaction();
	if (($paramTbl) && ($paramID)) { //Verify if tbl params isset  open transaction
		//BEG PDO
		switch ($paramTbl) {
			case "pac":
				$tbl = 'db_pacientes';
				$key = 'pac_cod';
				$params = array($paramField => $paramValue);
				$cond = array("md5($key)", "=", $paramID, $key);
				$ret = $db->updRow($tbl, $params, $cond);
				break;
			case "hc":
				$tbl = 'db_pacientes_hc';
				$key = 'pac_cod';
				$params = array($paramField => $paramValue);
				$cond = array("md5($key)", "=", $paramID, $key);
				$ret = $db->updRow($tbl, $params, $cond);
				break;
			case "gin":
				$tbl = 'db_pacientes_gin';
				$key = 'pac_cod';
				$params = array($paramField => $paramValue);
				$cond = array("md5($key)", "=", $paramID, $key);
				$ret = $db->updRow($tbl, $params, $cond);
				break;
			case "con":
				$tbl = 'db_consultas';
				$key = 'con_num';
				$params = array($paramField => $paramValue);
				$cond = array("md5($key)", "=", $paramID, $key);
				$ret = $db->updRow($tbl, $params, $cond);
				break;
			case "exa":
				$tbl = 'db_examenes';
				$key = 'id_exa';
				$params = array($paramField => $paramValue);
				$cond = array("md5($key)", "=", $paramID, $key);
				$ret = $db->updRow($tbl, $params, $cond);
				break;
			case "exadet":
				$tbl = 'db_examenes_det';
				$key = 'id';
				$params = array($paramField => $paramValue);
				$cond = array("md5($key)", "=", $paramID, $key);
				$ret = $db->updRow($tbl, $params, $cond);
				break;
		}
		$vP = $ret['est'] ?? FALSE;
		$LOG = $ret['log'] ?? FALSE;
		//END PDO
	} else {
		$LOG = "Params -tbl- [{$paramTbl}] and -cod- cant be null";
		throw new Exception($LOG);
	}
	//$db->endTransaction();
} catch (Exception $e) {
	$LOG = $e->getMessage();
} 
/*
catch (PDOException $e) {
	//$db->cancelTransaction();
	$LOG = $e->getMessage();
}
*/

echo json_encode(array("cod" => $paramID, "res" => $vP, "inf" => $LOG));
