<?php include('../../init.php');

$mTrat = new App\Models\Tratamiento();
$mCon = new App\Models\Consulta();

$id = $_GET['id'] ?? $_POST['id'] ?? null; //ID STANDAR
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null; //ID PACIENTE
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null; //ID CONSULTA
//Variables para funciones de TRATAMIENTOS
$idt = $_GET['idt'] ?? $_POST['idt'] ?? null;
$idtd = $_GET['idtd'] ?? $_POST['idtd'] ?? null;
//Variables para Medicamentos
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null;
//VARIABLE ACCION Y REDIRECCION
$goTo = $_GET['url'] ?? $_POST['url'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$vP = FALSE;
$goToP = null;
//ALL POST to $data
$data = $_POST;
$form = $data['form'] ?? null;
/**********************************************************************/
//BTN ACTIONS
if (isset($_POST["btnA"])) {
	// "Save Changes" clicked
	$LOG .= 'Action';
} else if (isset($_POST["btnP"])) {
	$LOG .= 'Print';
	$accP = TRUE;
	$accJS = TRUE;
} else if (isset($_POST["btnJ"])) {
	$LOG .= 'Close';
	$accJS = TRUE;
}
//FUNCIONES PARA TRATAMIENTOS
if (($form) && $form == 'tratdet') {
	$_SESSION['tab']['examf']['tabA'] = 'active';
	if ($acc == 'INSt') {
		$rP = $mTrat->insertTratamiento($idc, $idp, $data['fechap'], $data['diagnostico'], $data['obs']);
		$idt = $rP['ret'];
		$goToP .= '?idt=' . $idt;
	}
	if ($acc == 'UPDt') {
		$mTrat->setID($idt);
		$rP = $mTrat->updateTratamiento(
			$data['fechap'],
			$data['diagnostico'],
			$data['obs']
		);
		//update consulta proxima visita dias y tipo visita proxima consulta
		$rP = $mCon->updateProximaConsulta(
			$data['con_diapc'],
			$data['con_typvisP']
		);
		$goToP .= "?idt={$idt}";
	}
	if ($acc == md5("INStd")) {
		$mTrat->setID($idt);
		$mTrat->insertTratamientoDetalleVerifyGroup(
			$data['idMed'],
			$data['idInd'],
			$data['generico'],
			$data['comercial'],
			$data['presentacion'],
			$data['cantidad'],
			$data['numero'],
			$data['descripcion'],
			$data['indicacion']
		);
		$goToP = '?idt=' . $data['idTrat'];
	}

	if ($acc == md5("UPDtd")) {
		if ($_POST['tipTD'] == 'I') $indicacion = $_POST['descripcion'];
		$mTrat->updateTratamientoDetalle(
			$data['generico'],
			$data['comercial'],
			$data['presentacion'],
			$data['cantidad'],
			$data['numero'],
			$data['descripcion'],
			$data['indicacion']
		);
		$goToP = "?idt={$data['idTrat']}";
	}
} else {
	switch ($acc) {
		case md5("NEWt"):
			//$accJS=TRUE;
			$rP = $mTrat->insertTratamiento($idc, $idp);
			$idt = $rP['ret'];
			$goToP .= "?idt={$idt}";
			break;
		case md5("DELtf"):
			$accJS = TRUE;
			$mTrat->setID($idt);
			$rP = $mTrat->eliminarTratamiento();
			break;
		case md5("DELtd"):
			$mTrat->setIDsec($idtd);
			$rP = $mTrat->eliminarTratamientoDetalle();
			$goToP .= '?idt=' . $idt;
			break;
	}
}
/************************************************************************************/
//FUNCIONES GENERAL Y JS ACTIONS
/************************************************************************************/

///////////////////////////////////////////////////////////////////////
$goTo .= $goToP ?? null;


if (isset($accJS) && $accJS == TRUE) {
	$css['body'] = 'cero';
	include(root['f'] . 'head.php'); ?>
	<div id="alert" class="alert alert-info">
		<h2>Procesando</h2>
	</div>
	<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>

	<a class="printerButton btn btn-default btn-xs" data-id="<?php echo $idt ?>" data-rel="<?php echo route['c'] ?>com_tratamientos/recetaPrintJS.php">
		<i class="fa fa-print fa-lg"></i></a>

	<script type="text/javascript">
		$(document).ready(function() {
			<?php if (isset($accP)) { ?>$(".printerButton").trigger("click");
		<?php } else { ?>
			parent.location.reload();
		<?php } ?>
		});
		$("#alert").slideDown(300).delay(2000).fadeIn(300);
	</script>
	<?php include(root['f'] . 'footerC.php'); ?>
<?php } else {
	header(sprintf("Location: %s", $goTo));
}
?>