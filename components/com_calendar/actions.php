<?php include('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$accjs = FALSE;
$dat = $_POST;
$dat['est'] = $_POST['est'] ?? 1;
//TRANSACTION
mysqli_query(conn, "SET AUTOCOMMIT=0;");
mysqli_query(conn, "BEGIN;");

if (isset($dat['form']) && ($dat['form'] == 'AGE')) {
	if ($acc == md5('INS')) {
		if (!$est) $est = 1;
		$id_aud = AUD(NULL, 'Creación Reserva');
		$qryIns = sprintf(
			'INSERT INTO db_fullcalendar (fechai,fechaf,horai,horaf,pac_cod,typ_cod,obs,est,id_aud)
		VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($dat['fechai'], 'date'),
			SSQL($dat['fechaf'], 'date'),
			SSQL($dat['horai'], 'text'),
			SSQL($dat['horaf'], 'text'),
			SSQL($dat['pac_cod'], 'int'),
			SSQL($dat['typ_cod'], 'int'),
			SSQL($dat['obs'], 'text'),
			SSQL($dat['est'], 'int'),
			SSQL($id_aud, 'int')
		);
		if (mysqli_query(conn, $qryIns)) {
			$LOG .= '<p>EVENTO CREADO</p>';
			$vP = TRUE;
			$id = mysqli_insert_id(conn);
		} else {
			$LOG .= '<p>ERROR AL CREAR EVENTO</p>';
			$LOG .= mysqli_error(conn);
		}
		$goTo .= '?id=' . $id;
	} else if ($acc == md5('UPD')) {
		$detRes = detRow('db_fullcalendar', 'id', $id);
		$id_aud = AUD($detRes['id_aud'], 'Actualización Reserva');
		$qryUpd = sprintf(
			'UPDATE db_fullcalendar SET fechai=%s, fechaf=%s, horai=%s, horaf=%s, pac_cod=%s, typ_cod=%s, obs=%s, est=%s, id_aud=%s 
		WHERE id=%s',
			SSQL($dat['fechai'], 'date'),
			SSQL($dat['fechaf'], 'date'),
			SSQL($dat['horai'], 'text'),
			SSQL($dat['horaf'], 'text'),
			SSQL($dat['pac_cod'], 'int'),
			SSQL($dat['typ_cod'], 'int'),
			SSQL($dat['obs'], 'text'),
			SSQL($dat['est'], 'text'),
			SSQL($id_aud, 'int'),
			SSQL($id, 'int')
		);
		if (mysqli_query(conn, $qryUpd)) {
			$LOG .= '<p>EVENTO ACTUALIZADO</p>';
			$vP = TRUE;
		} else {
			$LOG .= '<p>ERROR AL ACTUALIZAR EVENTO</p>';
			$LOG .= mysqli_error(conn);
		}
		$goTo .= '?id=' . $id;
	} else {
		$LOG .= '<p>No se realizó ninguna acción</p>';
	}
} else {
	echo '<p>NO FORM AGE</p>';
}

if ($acc == md5('DELE')) {
	$qryUpd = sprintf(
		'UPDATE db_fullcalendar SET est=0 WHERE id=%s',
		SSQL($id, 'int')
	);
	//$qryDel=sprintf('DELETE FROM db_fullcalendar WHERE id=%s',
	//SSQL($id,'int'));
	if (mysqli_query(conn, $qryUpd)) {
		$LOG .= '<p>Evento Anulado Correctamente</p>';
		$accjs = TRUE;
		$vP = TRUE;
	} else {
		$LOG .= '<p>ERROR Anular Evento</p>';
		$LOG .= mysqli_error(conn);
	}
}

if ($acc == md5('DELEL')) {
	$detRes = detRow('db_fullcalendar', 'id', $id);
	$idp = $detRes['pac_cod'];
	$qryUpd = sprintf(
		'UPDATE db_fullcalendar SET est=0 WHERE id=%s',
		SSQL($id, 'int')
	);
	//$qryDel=sprintf('DELETE FROM db_fullcalendar WHERE id=%s',
	//SSQL($id,'int'));
	if (mysqli_query(conn, $qryUpd)) {
		$LOG .= '<p>Evento Anulado Correctamente</p>';
		$vP = TRUE;
	} else {
		$LOG .= '<p>ERROR Anular Evento</p>';
		$LOG .= mysqli_error(conn);
	}
	$goTo .= '?id=' . $idp;
}

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
if ($accjs == TRUE) {
	include(root['f'] . 'head.php'); ?>

	<body class="cero">
		<div id="alert" class="alert alert-info">
			<h2>Procesando</h2>
		</div>
		<script type="text/javascript">
			$("#alert").slideDown(300).delay(2000).fadeIn(300);
			parent.$.fancybox.close();
			parent.logGritter("<?php echo $_SESSION['LOG']['t'] ?>", "<?php echo $_SESSION['LOG']['m'] ?>", "<?php echo $_SESSION['LOG']['i'] ?>");
		</script>
		<?php unset($_SESSION['LOG']);
		unset($_SESSION['LOG']['m']); ?>
	</body>
<?php } else {
	header(sprintf("Location: %s", $goTo));
}
?>