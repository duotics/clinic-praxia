<?php include('../../init.php');
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idd = $_GET['idd'] ?? $_POST['idd'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$dDoc = fnc_datadoc($idd);
if ($dDoc) {
	$idp = $dDoc['pac_cod'];
	$idc = $dDoc['con_num'];
}
mysqli_query(conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn, "BEGIN;"); //Inicia la transaccion

if (isset($_POST["btnA"])) {
	// "Save Changes" clicked
	//$LOG.= 'Action';
} else if (isset($_POST["btnP"])) {
	//$LOG.= 'Print';
	$accP = TRUE;
	$accJS = TRUE;
} else if (isset($_POST["btnJ"])) {
	//$LOG.= 'Close';
	$accJS = TRUE;
}

if ((isset($_POST['form'])) && ($_POST['form'] == md5("fDocs"))) {
	if ($acc == md5("INSd")) {
		$qryinsd = sprintf(
			'INSERT INTO db_documentos (pac_cod,con_num,nombre,contenido,fecha)
	VALUES (%s,%s,%s,%s,%s)',
			SSQL($_POST['idp'], "int"),
			SSQL($_POST['idc'], "int"),
			SSQL($_POST['nombre'], "text"),
			SSQL($_POST['contenido'], "text"),
			SSQL($_POST['fecha'], "date")
		);
		if (@mysqli_query(conn, $qryinsd)) {
			$idd = @mysqli_insert_id(conn);
			$LOG .= '<h4>Documento Creado</h4> Numero. <strong>' . $idd . '</strong>';
		} else $LOG .= 'Error al Insertar';
		$goTo .= '?idd=' . $idd;
	}
	if ($acc == md5("UPDd")) {
		$qryupd = sprintf(
			'UPDATE db_documentos SET fecha=%s,nombre=%s,contenido=%s WHERE id_doc=%s',
			SSQL($_POST['fecha'], "date"),
			SSQL($_POST['nombre'], "text"),
			SSQL($_POST['contenido'], "text"),
			SSQL($idd, "int")
		);
		if (@mysqli_query(conn, $qryupd)) $LOG .= '<h4>Documento Actualizado</h4>';
		else $LOG .= '<h4>Error al Actualizar</h4>';
		$goTo .= '?idd=' . $idd;
	}
}
if ((isset($acc)) && ($acc == md5("DELd"))) {
	$qrydel = sprintf(
		'DELETE FROM db_documentos WHERE id_doc=%s',
		SSQL($idd, "int")
	);
	if (@mysqli_query(conn, $qrydel)) {
		$LOG .= '<h4>Eliminado Documento</h4>';
	} else {
		$LOG .= '<h4>Error al Eliminar</h4>';
		$LOG .= mysqli_error(conn);
	}
	$accJS = TRUE;
}
//VERIFY COMMIT
$LOG .= mysqli_error(conn);
if (!mysqli_error(conn)) {
	mysqli_query(conn, "COMMIT;");
	$LOGt = 'Operación Ejecutada Exitosamente';
	$LOGc = $cfg['p']['c-ok'];
	$LOGi = $RAIZa . $cfg['p']['i-ok'];
} else {
	mysqli_query(conn, "ROLLBACK;");
	$LOGt = 'Fallo del Sistema';
	$LOGc = $cfg['p']['c-fail'];
	$LOGi = $RAIZa . $cfg['p']['i-fail'];
}
mysqli_query(conn, "SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m'] = $LOG;
$_SESSION['LOG']['c'] = $LOGc;
$_SESSION['LOG']['t'] = $LOGt;
$_SESSION['LOG']['i'] = $LOGi;

if ($accJS == TRUE) {
	$css['body'] = 'cero';
	include(RAIZf . 'head.php'); ?>
	<div id="alert" class="alert alert-info">
		<h2>Procesando</h2>
	</div>
	<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>

	<a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idd ?>" data-rel="<?php echo $RAIZc ?>com_docs/docPrintJS.php">
		<i class="fa fa-print fa-lg"></i></a>

	<script type="text/javascript">
		$(document).ready(function() {
			<?php if ($accP) { ?>$(".printerButton").trigger("click");
		<?php } else { ?>
			parent.location.reload();
		<?php } ?>
		});
		$("#alert").slideDown(300).delay(2000).fadeIn(300);
	</script>
	<?php include(RAIZf . 'footerC.php'); ?>
<?php } else {
	header(sprintf("Location: %s", $goTo));
}
?>