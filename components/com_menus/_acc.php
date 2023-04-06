<?php include('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$ids = $_GET['ids'] ?? $_POST['ids'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$val = $_GET['val'] ?? $_POST['val'] ?? null;
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$det = $_POST;
$vP = FALSE;
$accjs = FALSE;

mysqli_query($conn, "SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query($conn, "BEGIN;"); //Inicia la transaccion
//ACCIONES formMC (MENUS CONTENEDORES)
if ((isset($det['form'])) && ($det['form'] == md5('formMC'))) {
	if ((isset($acc)) && ($acc == md5('UPDmc'))) {
		$qry = sprintf(
			'UPDATE dbMenu SET nomMenu=%s, refMenu=%s WHERE md5(idMenu)=%s',
			SSQL($det['iNom'], 'text'),
			SSQL($det['iRef'], 'text'),
			SSQL($ids, 'text')
		);
		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$LOG .= cfg['p']['upd-true'];
		} else $LOG .= cfg['p']['upd-false'] . mysqli_error($conn);
	}
	if ((isset($acc)) && ($acc == md5('INSmc'))) {
		$qry = sprintf(
			'INSERT INTO dbMenu (nomMenu, refMenu, status) 
			VALUES (%s,%s,%s)',
			SSQL($det['iNom'], 'text'),
			SSQL($det['iRef'], 'text'),
			SSQL('1', 'int')
		);
		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$id = mysqli_insert_id($conn);
			$ids = md5($id);
			$LOG .= cfg['p']['ins-true'];
		} else $LOG .= cfg['p']['ins-false'] . mysqli_error($conn);
	}
	$goTo .= '?ids=' . $ids;
}
if ((isset($det['form'])) && ($det['form'] == md5('formMI'))) {
	if ((isset($acc)) && ($acc == md5('UPDmi'))) {
		$qry = sprintf(
			'UPDATE dbMenuItem SET 
			idMenu=%s, parentMItem=%s, nomMItem=%s, titMItem=%s, linkMItem=%s, iconMItem=%s, ordMItem=%s, status=%s, cssMItem=%s, csslMItem=%s, precodeMItem=%s, poscodeMItem=%s, idComp=%s  
			WHERE md5(idMItem)=%s',
			SSQL($det['dIDC'], 'int'),
			SSQL($det['dIDP'], 'int'),
			SSQL($det['dNom'], 'text'),
			SSQL($det['dTit'], 'text'),
			SSQL($det['dLnk'], 'text'),
			SSQL($det['dIco'], 'text'),
			SSQL($det['dOrd'], 'int'),
			SSQL($det['dStat'], 'int'),
			SSQL($det['dCss'], 'text'),
			SSQL($det['dCssl'], 'text'),
			SSQL($det['dPreCode'], 'text'),
			SSQL($det['dPostCode'], 'text'),
			SSQL($det['dMod'], 'int'),
			SSQL($ids, 'text')
		);
		if (mysqli_query($conn, $qry)) {
			$LOG .= cfg['p']['upd-true'];
			$qry = sprintf(
				'UPDATE dbMenuItem SET idMenu=%s WHERE parentMItem=%s',
				SSQL($det['dIDC'], 'int'),
				SSQL($id, 'int')
			);
			if (mysqli_query($conn, $qry)) {
				$vP = TRUE;
				$LOG .= "<h4>Sub-items Actualizados Correctamente.</h4>";
			} else $LOG .= '<h4>Error al Actualizar Hijos</h4>';
		} else $LOG .= cfg['p']['upd-false'];
	}
	if ((isset($acc)) && ($acc == md5('INSmi'))) {
		$qry = sprintf(
			'INSERT INTO dbMenuItem (idMenu, parentMItem, nomMItem, titMItem, linkMItem, iconMItem, ordMItem, status, cssMItem, csslMItem, precodeMItem, poscodeMItem, idComp) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($det['dIDC'], 'int'),
			SSQL($det['dIDP'], 'int'),
			SSQL($det['dNom'], 'text'),
			SSQL($det['dTit'], 'text'),
			SSQL($det['dLnk'], 'text'),
			SSQL($det['dIco'], 'text'),
			SSQL($det['dOrd'], 'int'),
			SSQL('1', 'int'),
			SSQL($det['dCss'], 'text'),
			SSQL($det['dCssl'], 'text'),
			SSQL($det['dPreCode'], 'text'),
			SSQL($det['dPostCode'], 'text'),
			SSQL($det['dMod'], 'text')
		);

		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$id = mysqli_insert_id($conn);
			$ids = md5($id);
			$LOG .= cfg['p']['ins-true'];
		} else $LOG .= cfg['p']['ins-false'] . mysqli_error($conn);
	}
	$goTo .= '?ids=' . $ids;
}

//ACCIONES GET
if ((isset($acc)) && ($acc == md5('DELmc'))) {
	$totI = totRowsTab('dbMenuItem', 'md5(idMenu)', $ids);
	if (!($totI)) {
		$qry = sprintf(
			'DELETE FROM dbMenu WHERE md5(idMenu)=%s LIMIT 1',
			SSQL($ids, 'text')
		);
		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$LOG .= cfg['p']['del-true'];
		} else {
			$LOG .= cfg['p']['del-false'] . mysqli_error($conn);
		}
	} else {
		$LOG .= cfg['p']['del-false'] . '<p>Items relacionados</p>' . mysqli_error($conn);
	}
}
if ((isset($acc)) && ($acc == md5('STmc'))) {
	$qry = sprintf(
		'UPDATE dbMenu SET stat=%s WHERE md5(idMenu)=%s LIMIT 1',
		SSQL($val, 'int'),
		SSQL($ids, 'text')
	);
	if (mysqli_query($conn, $qry)) {
		$vP = TRUE;
		$LOG .= cfg['p']['est-true'];
	} else $LOG .= cfg['p']['est-false'] . mysqli_error($conn);
}
if ((isset($acc)) && ($acc == md5('STmi'))) {
	$qry = sprintf(
		'UPDATE dbMenuItem SET status=%s WHERE md5(idMItem)=%s LIMIT 1',
		SSQL($val, 'int'),
		SSQL($ids, 'text')
	);
	if (mysqli_query($conn, $qry)) {
		$vP = TRUE;
		$LOG .= cfg['p']['est-true'];
	} else $LOG .= cfg['p']['est-false'] . mysqli_error($conn);
}
if ((isset($acc)) && ($acc == md5('DELmi'))) {
	$qry = sprintf(
		'DELETE FROM dbMenuItemUser WHERE md5(idMItem)=%s LIMIT 1',
		SSQL($ids, 'text')
	);
	if (mysqli_query($conn, $qry)) {
		$qry = sprintf(
			'DELETE FROM dbMenuItem WHERE md5(idMItem)=%s',
			SSQL($ids, 'text')
		);
		if (mysqli_query($conn, $qry)) {
			$vP = TRUE;
			$LOG .= cfg['p']['del-true'];
		} else $LOG .= cfg['p']['del-false'] . mysqli_error($conn);
	}
	//$accjs=TRUE;
}
/******************************/

if ($vD == TRUE) $LOG .= $LOGd;
$LOG .= mysqli_error($conn);
$LOGr['m'] = $LOG;
if (($vP == TRUE) && (!mysqli_error($conn))) {
	mysqli_query($conn, "COMMIT;");
	$LOGr['t'] = cfg['p']['m-ok'];
	$LOGr['c'] = cfg['p']['c-ok'];
	$LOGr['i'] = route['a'] . cfg['p']['i-ok'];
} else {
	mysqli_query($conn, "ROLLBACK;");
	$LOGr['t'] = cfg['p']['m-fail'];
	$LOGr['c'] = cfg['p']['c-fail'];
	$LOGr['i'] = route['a'] . cfg['p']['i-fail'];
}
$_SESSION['LOG'] = $LOGr;


/******************************/

if ($accjs == TRUE) {
	include(root['f'] . 'head.php'); ?>

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
	header(sprintf("Location: %s", $goTo));
}
?>