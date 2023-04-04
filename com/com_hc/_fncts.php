<?php include('../../init.php');
$_SESSION['LOG'] = NULL; //INICIALIZA SESSION LOG
$id = $_GET['id'] ?? $_POST['id'] ?? null; //ID STANDAR
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null; //ID PACIENTE
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null; //ID CONSULTA
//Variables para funciones de TRATAMIENTOS
$idt = $_GET['idt'] ?? $_POST['idt'] ?? null;
$idtd = $_GET['idtd'] ?? $_POST['idtd'] ?? null;

$ide = $_GET['ide'] ?? $_POST['ide'] ?? null;
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null;
//Variables para funcion de Obstetricia
$ido = $_GET['ido'] ?? $_POST['ido'] ?? null;

//VARIABLE ACCION Y REDIRECCION
$action = $_GET['action'] ?? $_POST['action'] ?? null;
$urlreturn = $_SESSION['urlp'];
/**********************************************************************/
//FUNCIONES PARA TRATAMIENTOS
if ((isset($_POST['form'])) && ($_POST['form'] == 'tratdet')) {
	if ($action == 'INS') {
		$qryinst = sprintf(
			'INSERT INTO db_tratamientos (con_num, pac_cod, fecha, fechap, diagnostico, obs)
	VALUES (%s,%s,%s,%s,%s,%s)',
			SSQL($_POST['idc'], "int"),
			SSQL($_POST['idp'], "int"),
			SSQL($_POST['fecha'], "date"),
			SSQL($_POST['fechap'], "date"),
			SSQL($_POST['diagnostico'], "text"),
			SSQL($_POST['obs'], "text")
		);
		if (@mysqli_query(conn, $qryinst)) {
			$idt = @mysqli_insert_id(conn);
			$LOG .= '<h4>Tratamiento Creado</h4> Numero. <strong>' . $idt . '</strong>';
		} else $LOG .= 'Error al Insertar';
		$urlreturn .= '?idt=' . $idt;
	}

	if ($action == 'UPD') {
		$qryinst = sprintf(
			'UPDATE db_tratamientos SET diagnostico=%s, fechap=%s, obs=%s WHERE tid=%s',
			SSQL($_POST['diagnostico'], "text"),
			SSQL($_POST['fechap'], "date"),
			SSQL($_POST['obs'], "text"),
			SSQL($_POST['idt'], "int")
		);
		if (@mysqli_query(conn, $qryinst)) {
			$idt = $_POST['idt'];
			$LOG .= '<p>Tratamiento Actualizado</p>';
		} else $LOG .= '<p>Error al Actualizar</p>';
		$urlreturn .= '?idt=' . $idt;
	}

	if ($action == 'INSD') {
		$qryins = sprintf(
			'INSERT INTO db_tratamientos_detalle (tid, id_form, generico, comercial, presentacion, cantidad, descripcion)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
			SSQL($_POST['trat_id'], "int"),
			SSQL($_POST['id_form'], "int"),
			SSQL($_POST['generico'], "text"),
			SSQL($_POST['comercial'], "text"),
			SSQL($_POST['presentacion'], "text"),
			SSQL($_POST['cantidad'], "int"),
			SSQL($_POST['descripcion'], "text")
		);
		if (@mysqli_query(conn, $qryins)) $LOG .= '<p>Medicamento Guardado</p>';
		else $LOG .= '<p>Error al Guardar Medicamento</p>';
		$urlreturn = 'tratamiento_form.php?idt=' . $_POST['trat_id'];
	}

	if ($action == 'UPDD') {
		$qryUpd = sprintf(
			'UPDATE db_tratamientos_detalle SET generico=%s, comercial=%s, presentacion=%s, cantidad=%s, descripcion=%s WHERE id=%s',
			SSQL($_POST['generico'], "text"),
			SSQL($_POST['comercial'], "text"),
			SSQL($_POST['presentacion'], "text"),
			SSQL($_POST['cantidad'], "int"),
			SSQL($_POST['descripcion'], "text"),
			SSQL($idtd, "int")
		);
		if (@mysqli_query(conn, $qryUpd)) $LOG .= '<p>Medicamento Guardado</p>';
		else $LOG .= '<p>Error al Guardar Medicamento</p>';
		$urlreturn = 'tratamiento_form.php?idt=' . $_POST['trat_id'];
	}
}
/**********************************************************************/
//FUNCIONES PARA OBSTETRICIA
if ((isset($_POST['form'])) && ($_POST['form'] == 'obsdet')) {
	if ($action == 'INS') {
		$qryINS = sprintf(
			'INSERT INTO db_obstetrico (pac_cod, obs_fec, obs_fec_um, obs_fecf)
	VALUES (%s,%s,%s,%s)',
			SSQL($idp, "int"),
			SSQL($_POST['obs_fec'], "date"),
			SSQL($_POST['obs_fec_um'], "date"),
			SSQL($_POST['obs_fecf'], "date")
		);
		if (@mysqli_query(conn, $qryINS)) {
			$id = @mysqli_insert_id(conn);
			$LOG .= '<h4>Seguimiento Obstétrico Creado</h4> Numero. <strong>' . $id . '</strong>';
		} else $LOG .= '<h4>Error al Insertar</h4>Intente Nuevamente';
		$urlreturn .= '?ido=' . $id;
	}

	if ($action == 'UPD') {
		$qryinst = sprintf(
			'UPDATE db_obstetrico SET obs_fec=%s, obs_fec_um=%s, obs_fecf=%s WHERE obs_id=%s',
			SSQL($_POST['obs_fec'], "date"),
			SSQL($_POST['obs_fec_um'], "date"),
			SSQL($_POST['obs_fecf'], "date"),
			SSQL($ido, 'int')
		);
		if (@mysqli_query(conn, $qryinst)) {
			$LOG .= '<h4>Seguimiento Actualizado</h4>';
			$_SESSION['LOG']['t'] = 'OPERACIÓN EXITOSA';
			$_SESSION['LOG']['c'] = 'info';
			$_SESSION['LOG']['i'] = $RAIZa . $cfg['p']['i-ok'];
		} else $LOG .= 'Error al Actualizar';
		$urlreturn .= '?ido=' . $ido;
	}

	if ($action == 'INSD') {
		$qryins = sprintf(
			'INSERT INTO db_obstetrico_detalle (obs_id, obs_det, obs_fec)
		VALUES (%s,%s,%s)',
			SSQL($ido, 'int'),
			SSQL($_POST['obs_det'], 'text'),
			SSQL($_POST['obs_fec'], 'date')
		);
		if (@mysqli_query(conn, $qryins)) {
			$LOG .= '<h4>Visita Guardada</h4>';
			$_SESSION['LOG']['t'] = 'OPERACIÓN EXITOSA';
			$_SESSION['LOG']['c'] = 'info';
			$_SESSION['LOG']['i'] = $RAIZa . $cfg['p']['i-ok'];
		} else $LOG .= '<h4>Error al Insertar<h4>';
		$urlreturn = '?ido=' . $ido;
	}
}

//FUNCIONES PARA EXAMENES
if ((isset($_POST['form'])) && ($_POST['form'] == 'fexamen')) {

	if (($_FILES['efile']['name'])) {
		$param_file['ext'] = array('.jpg', '.gif', '.png', '.jpeg', '.JPG', '.GIF', '.PNG', '.JPEG');
		$param_file['siz'] = 2097152;
		$param_file['pat'] = RAIZ . 'media/db/exam/';
		$param_file['pre'] = 'exa';
		$upl = uploadfile($param_file, $_FILES['efile']);
		if ($upl['EST'] == TRUE) {
			//INS MEDIA
			$qryIns = sprintf(
				"INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
				SSQL($upl['FILE'], "text"),
				SSQL($dfile, "text"),
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
			//fnc_genthumb($param_file['pat'], $aux_grab[2], "t_", 250, 200);
		}
	}



	if ($action == 'INS') {
		$qryinst = sprintf(
			'INSERT INTO db_examenes (pac_cod,con_num,fecha,fechae,typ_cod,descripcion,resultado)
	VALUES (%s,%s,%s,%s,%s,%s,%s)',
			SSQL($_POST['idp'], "int"),
			SSQL($_POST['idc'], "int"),
			SSQL($sdate, "date"),
			SSQL($_POST['fechae'], "date"),
			SSQL($_POST['typ_cod'], "int"),
			SSQL($_POST['descripcion'], "text"),
			SSQL($_POST['resultado'], "text")
		);
		if (@mysqli_query(conn, $qryinst)) {
			$ide = @mysqli_insert_id(conn);
			$LOG .= '<p>Examen Creado</p>';
		} else $LOG .= 'Error al Insertar';
		$urlreturn .= '?ide=' . $ide;
	}
	if ($action == 'UPD') {
		$qryupd = sprintf(
			'UPDATE db_examenes SET fechae=%s,typ_cod=%s,descripcion=%s,resultado=%s WHERE id_exa=%s',
			SSQL($_POST['fechae'], "date"),
			SSQL($_POST['typ_cod'], "int"),
			SSQL($_POST['descripcion'], "text"),
			SSQL($_POST['resultado'], "text"),
			SSQL($_POST['ide'], "int")
		);
		if (@mysqli_query(conn, $qryupd)) $LOG .= '<p>Examen Actualizado</p>';
		else $LOG .= 'Error al Actualizar';
		$urlreturn .= '?ide=' . $ide;
	}
}


/************************************************************************************/
//FUNCIONES DE ELIMINACION GENERAL
/************************************************************************************/

//Eliminación de TRATAMIENTO (cab)
if ((isset($action)) && ($action == 'DELTF')) {
	$accjs = TRUE;
	$qrydelD = sprintf(
		'DELETE FROM db_tratamientos_detalle WHERE tid=%s',
		SSQL($idt, "int")
	);
	if (@mysqli_query(conn, $qrydelD)) {
		$LOG .= '<p>Eliminados Medicamentos Tratamiento</p>';
		$qrydel = sprintf(
			'DELETE FROM db_tratamientos WHERE tid=%s',
			SSQL($idt, "int")
		);
		if (@mysqli_query(conn, $qrydel)) {
			$LOG .= '<p>Eliminado Tratamiento</p>';
		} else {
			$LOG .= mysqli_error(conn);
		}
	} else {
		$LOG .= mysqli_error(conn);
	}
}
//Eliminación de TRATAMIENTO Detalle
if ((isset($action)) && ($action == 'DELTD')) {
	$qrydel = sprintf(
		'DELETE FROM db_tratamientos_detalle WHERE id=%s',
		SSQL($idtd, "int")
	);
	if (@mysqli_query(conn, $qrydel)) $LOG .= '<p>Eliminado Medicamento</p>';
	$urlreturn = 'tratamiento_form.php?idt=' . $idt;
}

//Eliminación de OBSTETRICO (cab)
if ((isset($action)) && ($action == 'DELOF')) {
	$qrydelD = sprintf(
		'DELETE FROM db_obstetrico_detalle WHERE obs_id=%s',
		SSQL($ido, "int")
	);
	if (@mysqli_query(conn, $qrydelD)) {
		$LOG .= '<p>Eliminado Detalles Seguimiento</p>';
		$qrydel = sprintf(
			'DELETE FROM db_obstetrico WHERE obs_id=%s',
			SSQL($ido, "int")
		);
		if (@mysqli_query(conn, $qrydel)) $LOG .= '<p>Eliminado Seguimiento</p>';
		else $LOG .= '<p>Error al Eliminar Seguimiento</p>';
	} else $LOG .= '<p>Error al Eliminar Detalles</p>';
	echo '<script type="text/javascript">parent.Shadowbox.close();</script>';
}
//Eliminación de OBSTETRICO Detalle
if ((isset($action)) && ($action == 'DELOD')) {
	$qrydel = sprintf(
		'DELETE FROM db_obstetrico_detalle WHERE id=%s',
		SSQL($idod, "int")
	);
	if (@mysqli_query(conn, $qrydel)) $LOG .= '<p>Eliminado Registro de Seguimiento</p>';
	$urlreturn .= '?ido=' . $ido;
}


if ((isset($action)) && ($action == 'DELEF')) {
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
		} else {
			$LOG .= mysqli_error(conn);
		}
	} else {
		$LOG .= mysqli_error(conn);
	}
	$accjs = TRUE;
}

if ((isset($action)) && ($action == 'delEimg')) {
	$qrydelei = sprintf(
		'DELETE FROM db_examenes_media WHERE id=%s',
		SSQL($id, 'int')
	);
	if (@mysqli_query(conn, $qrydelei)) $LOG .= '<h4>Archivo Eliminado</h4>Se ha eliminado correctamente imagen. ID: <strong>' . $id . '</strong>';
	else $LOG .= '<b>No se pudo Eliminar</b><br />';
	$urlreturn .= '?ide=' . $ide;
}
if ((isset($action)) && ($action == 'delRimg')) {
	$qrydelei = sprintf(
		'DELETE FROM db_cirugias_media WHERE id=%s',
		SSQL($id, 'int')
	);
	if (@mysqli_query(conn, $qrydelei)) $LOG .= '<h4>Archivo Eliminado</h4>Se ha eliminado correctamente el archivo. ID: <strong>' . $id . '</strong>';
	else $LOG .= '<b>No se pudo Eliminar</b><br />';
	$urlreturn .= '?idr=' . $idr;
}

$LOG .= mysqli_error(conn);
$_SESSION['LOG']['m'] = $LOG;

if ($accjs == TRUE) {
	include(RAIZf . 'head.php'); ?>

	<body class="cero">
		<div id="alert" class="alert alert-info">
			<h2>Procesando</h2>
		</div>
		<script type="text/javascript">
			$("#alert").slideDown(300).delay(2000).fadeIn(300);
			parent.location.reload();
		</script>
	</body>
<?php } else {
	header(sprintf("Location: %s", $urlreturn));
}
?>