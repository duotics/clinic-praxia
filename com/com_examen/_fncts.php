<?php include('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null; //ID STANDAR
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null; //ID PACIENTE
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null; //ID CONSULTA
$ide = $_GET['ide'] ?? $_POST['ide'] ?? null;
$idef = $_GET['idef'] ?? $_POST['idef'] ?? null;
//VARIABLE ACCION Y REDIRECCION
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
//$vD = TRUE;
$data = $_POST;
$debug = null;
$debug .= '<hr>BEGIN<br>';
if (!$goTo) $goTo = $urlp;

//$data = $data;
mysqli_query(conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn, "BEGIN;"); //Inicia la transaccion
/**********************************************************************/

if (isset($_POST["btnA"])) {
	// "Save Changes" clicked
	$LOG .= 'Action';
} else if (isset($_POST["btnP"])) {
	$LOG .= 'Print';
} else if (isset($_POST["btnJ"])) {
	$LOG .= 'Close';
	$accjs = TRUE;
}
//FUNCIONES PARA EXAMENES
if ((isset($data['form'])) && ($data['form'] == md5('fExam'))) {
	//IMAGES FILES
	if (($_FILES['efile']['name'])) {
		$debug .= 'File Upload.<br>';
		$param_file['ext'] = array('.jpg', '.gif', '.png', '.jpeg', '.JPG', '.GIF', '.PNG', '.JPEG');
		$param_file['siz'] = 2097152; //en KBPS
		$param_file['pat'] = RAIZ . 'data/db/exam/';
		$param_file['pre'] = 'exa';
		$files = array();
		$fdata = $_FILES['efile'];
		if (is_array($fdata['name'])) {
			for ($i = 0; $i < count($fdata['name']); ++$i) {
				$files[] = array(
					'name'    => $fdata['name'][$i],
					'type'  => $fdata['type'][$i],
					'tmp_name' => $fdata['tmp_name'][$i],
					'error' => $fdata['error'][$i],
					'size'  => $fdata['size'][$i]
				);
			}
		} else $files[] = $fdata;
		foreach ($files as $file) {
			$upl = uploadfile($param_file, $file);
			if ($upl['EST'] == TRUE) {
				//INS MEDIA
				$qryIns = sprintf(
					"INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
					SSQL($upl['FILE'], "text"),
					SSQL($data['dfile'], "text"),
					SSQL("1", "int")
				);
				$ResultInsertc = mysqli_query(conn, $qryIns) or die(mysqli_error(conn));
				$insID = mysqli_insert_id(conn);
				//INS REP OBS MEDIA
				$qryIns = sprintf(
					"INSERT INTO db_examenes_media (id_exa, id_med) VALUES (%s,%s)",
					SSQL($ide, "int"),
					SSQL($insID, "int")
				);
				$ResultInsertc = mysqli_query(conn, $qryIns) or die(mysqli_error(conn));
				$insID = mysqli_insert_id(conn);

				fnc_genthumb($param_file['pat'], $upl['FILE'], "t_", 330, 330);
			}
			$LOG .= $upl['LOG'];
		}
	}
	switch ($acc) {
		case md5('INSe'):
			$qryinst = sprintf(
				'INSERT INTO db_examenes (id_ef,pac_cod,con_num,fecha,fechae,typ_cod,enc,des,pie,obs,resultado)
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
				SSQL($data['idef'], "int"),
				SSQL($data['idp'], "int"),
				SSQL($data['idc'], "int"),
				SSQL($sdate, "date"),
				SSQL($data['fechae'], "date"),
				SSQL($data['typ_cod'], "int"),
				SSQL($data['iEnc'], "text"),
				SSQL($data['iDes'], "text"),
				SSQL($data['iPie'], "text"),
				SSQL($data['obs'], "text"),
				SSQL($data['resultado'], "text")
			);
			if (@mysqli_query(conn, $qryinst)) {
				$vP = TRUE;
				$ide = @mysqli_insert_id(conn);
				$LOG .= '<p>Examen Creado</p>';
			} else $LOG .= 'Error al Insertar';
			//$goTo.='?ide='.$ide;
			break;
		case md5('UPDe'):
			$debug .= 'Update Examen<br>';
			$qryupd = sprintf(
				'UPDATE db_examenes SET id_ef=%s,fechae=%s,typ_cod=%s,enc=%s,des=%s,pie=%s,obs=%s,resultado=%s WHERE id_exa=%s',
				SSQL($data['idef'], "int"),
				SSQL($data['fechae'], "date"),
				SSQL($data['typ_cod'] ?? null, "int"),
				SSQL($data['iEnc'] ?? null, "text"),
				SSQL($data['iDes'], "text"),
				SSQL($data['iPie'] ?? null, "text"),
				SSQL($data['obs'], "text"),
				SSQL($data['resultado'], "text"),
				SSQL($data['ide'], "int")
			);
			if (@mysqli_query(conn, $qryupd)) {
				$vP = TRUE;
				$LOG .= '<p>Examen Actualizado</p>';
			} else $LOG .= 'Error al Actualizar' . mysqli_error(conn);
			//$goTo.='?ide='.$ide;
			break;
	}

	//BEG Multiple exam format det
	$debug .= 'Multiple Exam format det<br>';
	$valSel = $data['lefs'] ?? [];
	$resSel = $data['lefsR'] ?? null;
	$contMultVals = count($valSel);
	$debug .= 'examen det. ' . $contMultVals . '<br>';
	//$debug.=var_dump($valSel);

	$qryDelMC = sprintf(
		'DELETE FROM db_examenes_det WHERE ide=%s',
		SSQL($ide, "int")
	);
	mysqli_query(conn, $qryDelMC) or ($LOG .= mysqli_error(conn));

	foreach ($valSel as $valSelID) {
		$debug .= 'ValSel. ' . $valSelID . ' - Res. ' . $resSel[$valSelID] . '<br>';
		$qryinsMC = sprintf(
			'INSERT INTO db_examenes_det (ide, idefd, res) VALUES (%s,%s,%s)',
			SSQL($ide, "int"),
			SSQL($valSelID, "int"),
			SSQL($resSel[$valSelID], "text")
		);
		$debug .= $qryinsMC . '<br>';
		mysqli_query(conn, $qryinsMC) or ($LOG .= mysqli_error(conn));
	}
	//Eliminar MultiCats anteriores

	//$debug .= 'valsel. ' . $valSel; //var_dump($valSel);//'valsel. '.$valSel;

	//Inserta las MultiCats seleccionadas
	/*for($i=0;$i<$contMultVals;$i++){
		$qryinsMC=sprintf('INSERT INTO db_examenes_det (ide, idefd, res) VALUES (%s,%s,%s)',
			SSQL($ide, "int"),
			SSQL($valSel[$i], "int"),
			SSQL($resSel[$i], "text"));
		mysqli_query(conn,$qryinsMC)or($LOG.=mysqli_error(conn));
	}*/
	//END Multiple exam format det

	$goTo .= '?ide=' . $ide;
	if (isset($_POST["btnP"])) $goTo = 'examenPrint.php?id' . $ide;
}
/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/
if ((isset($acc)) && ($acc == md5('NEWe'))) {
	$dEF = detRow('db_examenes_format', 'id', $idef);

	$qryIE = sprintf(
		'INSERT INTO db_examenes (id_ef,con_num,pac_cod,fecha,fechae,enc,des,pie) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($idef, 'int'),
		SSQL($idc, 'int'),
		SSQL($idp, 'int'),
		SSQL($sdate, 'date'),
		SSQL($sdate, 'date'),
		SSQL($dEF["enc"], 'text'),
		SSQL($dEF["des"], 'text'),
		SSQL($dEF["pie"], 'text')
	);
	if (@mysqli_query(conn, $qryIE)) {
		$vP = TRUE;
		$id = @mysqli_insert_id(conn);
		$LOG .= $cfg['p']['ins-true'];

		$qEFd = sprintf(
			'SELECT * FROM db_examenes_format_det WHERE idef=%s AND act=1',
			SSQL($idef, 'int')
		);
		$debug .= $qEFd . '<br>';
		$RSefd = mysqli_query(conn, $qEFd);
		$dRSefd = mysqli_fetch_assoc($RSefd);
		$tRSefd = mysqli_num_rows($RSefd);
		if ($tRSefd > 0) {
			do {
				$qIEFd = sprintf(
					'INSERT INTO db_examenes_det (idefd,ide) VALUES (%s,%s)',
					SSQL($dRSefd["id"], 'int'),
					SSQL($id, 'int')
				);
				$debug .= $qIEFd . '<br>';
				if (@mysqli_query(conn, $qIEFd)) {
					$debug .= 'Detalle creado<br>';
				} else {
					$vP = FALSE;
					break;
				}
			} while ($dRSefd = mysqli_fetch_assoc($RSefd));
		}
	} else {
		$LOG .= $cfg['p']['ins-false'] . mysqli_error(conn);
	}
	$goTo = 'examenForm.php?ide=' . $id;
}
if ((isset($acc)) && ($acc == md5('DELe'))) {
	$accjs = TRUE;
	$detExa = detRow('db_examenes', 'id_exa', $ide);
	$idp = $detExa['pac_cod'];

	$qrydelM = sprintf(
		'DELETE FROM db_examenes_media WHERE id_exa=%s',
		SSQL($ide, "int")
	);
	if (@mysqli_query(conn, $qrydelM)) {
		$LOG .= '<p>Eliminado Multimedia Examen</p>';
		$qrydel = sprintf(
			'DELETE FROM db_examenes WHERE id_exa=%s',
			SSQL($ide, "int")
		);
		if (@mysqli_query(conn, $qrydel)) {
			$LOG .= '<p>Eliminado Examen</p>';
			$vP = TRUE;
		} else $LOG .= mysqli_error(conn);
	} else $LOG .= mysqli_error(conn);
	$goTo .= '?id=' . $idp;
}
if ((isset($acc)) && ($acc == md5('DELEF'))) {
	$qrydelM = sprintf(
		'DELETE FROM db_examenes_media WHERE id_exa=%s',
		SSQL($ide, "int")
	);
	if (@mysqli_query(conn, $qrydelM)) {
		$LOG .= '<p>Eliminado Multimedia Examen</p>';
		$qrydel = sprintf(
			'DELETE FROM db_examenes WHERE id_exa=%s',
			SSQL($ide, "int")
		);
		if (@mysqli_query(conn, $qrydel)) {
			$LOG .= '<p>Eliminado Examen</p>';
			$vP = TRUE;
		} else $LOG .= mysqli_error(conn);
	} else $LOG .= mysqli_error(conn);
	$accjs = TRUE;
}
if ((isset($acc)) && ($acc == 'delEimg')) {
	$qrydelei = sprintf(
		'DELETE FROM db_examenes_media WHERE id=%s',
		SSQL($id, 'int')
	);
	if (@mysqli_query(conn, $qrydelei)) {
		$vP = TRUE;
		$LOG .= '<h4>Archivo Eliminado</h4>';
	} else $LOG .= '<b>No se pudo Eliminar</b><br />';
	$goTo .= '?ide=' . $ide;
}

if ($vD == TRUE) $LOG .= $debug;
$LOG .= mysqli_error(conn);
if ((!mysqli_error(conn)) && ($vP == TRUE)) {
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
mysqli_query(conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m'] = $LOG;
$_SESSION['LOG']['c'] = $LOGc;
$_SESSION['LOG']['t'] = $LOGt;
$_SESSION['LOG']['i'] = $LOGi;


if (isset($accjs) && $accjs == TRUE) {
	$css['body'] = 'cero';
	include(RAIZf . 'head.php'); ?>
	<div id="alert" class="alert alert-info">
		<h2>Procesando</h2>
	</div>
	<script type="text/javascript">
		$("#alert").slideDown(300).delay(2000).fadeIn(300);
		parent.location.reload();
	</script>
	<?php include(RAIZf . 'footer.php'); ?>
<?php } else {
	header(sprintf("Location: %s", $goTo));
}
?>