<?php include('../../init.php');
$LOG = null;
$data = array(
	"tbl" => $_REQUEST['tbl'] ?? null,
	"field" => $_REQUEST['campo'] ?? null,
	"param" => $_REQUEST['valor'] ?? null,
	"ids" => $_REQUEST['cod'] ?? null
);
$id = $data['ids'];
$param = $data['param'];
$vP = false;
try {
	if (($data['tbl']) && ($data['ids'])) { //Verify if tbl params isset  open transaction
		//BEG PDO
		$db->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);

		switch ($data['tbl']) {
			case "pac":
				$tbl = 'db_pacientes';
				$key = 'pac_cod';
				$params = array($data['field'] => $data['param']);
				$cond = array("md5($key)", "=", $data['ids'], $key);
				$ret = $db->updRow($tbl, $params, $cond);
				$LOG .= $ret['log'];
				if ($ret['est']) $vP = true;
				break;
			case "hc":
				$tbl = 'db_pacientes_hc';
				$key = 'pac_cod';
				$params = array($data['field'] => $data['param']);
				$cond = array("md5($key)", "=", $data['ids'], $key);
				$ret = $db->updRow($tbl, $params, $cond);
				$LOG .= $ret['log'];
				if ($ret['est']) $vP = true;
				break;
			case "gin":
				$tbl = 'db_pacientes_gin';
				$key = 'pac_cod';
				$params = array($data['field'] => $data['param']);
				$cond = array("md5($key)", "=", $data['ids'], $key);
				$ret = $db->updRow($tbl, $params, $cond);
				$LOG .= $ret['log'];
				if ($ret['est']) $vP = true;
				break;
			case "con":
				$tbl = 'db_consultas';
				$key = 'con_num';
				$params = array($data['field'] => $data['param']);
				$cond = array("md5($key)", "=", $data['ids'], $key);
				$ret = $db->updRow($tbl, $params, $cond);
				$LOG .= $ret['log'];
				if ($ret['est']) $vP = true;
				break;
			case "exa":
				$tbl = 'db_examenes';
				$key = 'id_exa';
				$params = array($data['field'] => $data['param']);
				$cond = array("md5($key)", "=", $data['ids'], $key);
				$ret = $db->updRow($tbl, $params, $cond);
				$LOG .= $ret['log'];
				if ($ret['est']) $vP = true;
				break;
			case "exadet":
				$tbl = 'db_examenes_det';
				$key = 'id';
				$params = array($data['field'] => $data['param']);
				$cond = array("md5($key)", "=", $data['ids'], $key);
				$ret = $db->updRow($tbl, $params, $cond);
				$LOG .= $ret['log'];
				if ($ret['est']) $vP = true;
				break;
				/*
				case "condiag":
				$tbl = 'db_consultas_diagnostico';
				switch ($data['acc']) {
					case "insDiag":
						$params=array("con_num"=>"", "id_diag"=>"");
						$vP=$db->insRow($tbl,$params);
					break;
					case "insOther":
						$vP=$db->insRow($tbl,$params);
					break;
					case "delDiag"
						$vP=$db->delRow($tbl,"id",$id);
					break;
				}

				$array = array('pac_cod' => $idp);
				$ret = $db->insRow($tbl, $params);
				break;

				"acc" => $_REQUEST['acc'] ?? null,
				"tbl" => $_REQUEST['tbl'] ?? null,
				"field" => $_REQUEST['campo'] ?? null,
				"param" => $_REQUEST['valor'] ?? null,
				"ids" => $_REQUEST['cod'] ?? null
				*/
		}




		/*
		//CONSULTA DIAGNOSTICOS
		if ($tbl == 'condiag') {
			if ($id) {
				if ($field == 'sel') {
					$qryIns = sprintf(
						'INSERT INTO db_consultas_diagostico (con_num, id_diag) VALUES (%s,%s)',
						SSQL($id, 'int'),
						SSQL($param, 'int')
					);
					//$LOG.=$qryIns;
					if (mysqli_query($conn, $qryIns)) {
						$LOG .= 'Diagnóstico Guardado';
						$res = TRUE;
					} else {
						$LOG .= 'Error al Guardar Diagnóstico';
						$LOG .= mysqli_error($conn);
						$res = FALSE;
					}
				} else if ($field == 'otro') {
					$qryIns = sprintf(
						'INSERT INTO db_consultas_diagostico (con_num, id_diag, obs) VALUES (%s,%s,%s)',
						SSQL($id, 'int'),
						SSQL(1, 'int'),
						SSQL($param, 'text')
					);
					//$LOG.=$qryIns;
					if (mysqli_query($conn, $qryIns)) {
						$LOG .= 'Diagnóstico Guardado';
						$res = TRUE;
					} else {
						$LOG .= 'Error al Guardar Diagnóstico';
						$LOG .= mysqli_error($conn);
						$res = FALSE;
					}
				} else if ($field == 'des') {
					$qryD = sprintf(
						'DELETE FROM db_consultas_diagostico WHERE con_num=%s AND id_diag=%s LIMIT 1',
						SSQL($id, 'int'),
						SSQL($param, 'int')
					);
					//$LOG.=$qryDel;
					if (mysqli_query($conn, $qryD)) {
						$LOG .= 'Diagnóstico Eliminado';
						$res = TRUE;
					} else {
						$LOG .= 'Error al Eliminar Diagnóstico';
						$LOG .= mysqli_error($conn);
						$res = FALSE;
					}
				} else {
					$res = FALSE;
					$LOG .= 'Error, Diagnostico Consulta ExP000';
				}
				
				//$qryIns=sprintf('INSERT INTO db_consultas_diagostico (con_num, id_diad) VALUES (%s,%s)',
				//SSQL($field,''),
				//SSQL($param,'text'),
				//SSQL($id,'int'));
				//if(mysqli_query($conn,$qryUpd)){
				//	$LOG.='Datos Consulta Guardados';
				//	$res=TRUE;
				//}else{
				//	$LOG.='Error al Actualizar Consulta';
				//	$LOG.=mysqli_error($conn);
				//	$res=FALSE;
				//}
				//$LOG.=$field.'-'.$param;
			} else {
				$res = FALSE;
				$LOG .= 'No hay Consulta, Guardar Consulta';
			}
		}
		*/
		if (isset($ret['est']) && $ret['est']) $vP = TRUE;
		$db->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
		//END PDO
	} else {
		$LOG .= "Params -tbl- [{$data['tbl']}] and -cod- cant be null";
	}
} catch (Exception $e) {
	//$LOG= "Error en ejecución";//$e->getMessage();
	$LOG = $e->getMessage();
}

echo json_encode(array("cod" => $id ?? null, "res" => $vP ?? null, "inf" => $LOG ?? null));
