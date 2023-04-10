<?php require('../../init.php');
//INIT VARS
$tabS = $_SESSION['tab']['con'] ?? null;
$view = false;
$dPac = null;
$dCon = null;
$dRes = null;
$statusCon = null;
$mCon = new App\Models\ConsultaInterfaz();
$mPac = new App\Models\PacienteInterfaz;
$mRes = new App\Models\Agendamiento;

$tabS = $_SESSION['tab']['con'] ?? null;
$idsPac = $_GET['kp'] ?? null;
$idsCon = $_GET['kc'] ?? null;
$idsRes = $_GET['kr'] ?? null;

if ($idsPac !== null) {
    // Opción 1: ID_PACIENTE
    echo "* hay ID Paciente<br>";
    $idsCon=null;
    $mPac->setID($idsPac);
    $mPac->det();
    $dPac = $mPac->getDet();
    $mRes->getLastResPac($idsPac);
    $dRes = $mRes->getDet();
    if ($dRes) {
        echo " - Reserva Existe<br>";
        echo "existe reserva<br>";
        $idr = $dRes['id'] ?? null;
        $statusCon = 3;
    } else {
        echo " - Reserva no Existe<br>";
        echo "no existe reserva obtengo consulta<br>";
        $idc = $dPac['con_num'] ?? null;
        $mCon->getLastConsPac($idsPac);
        $dCon = $mCon->getDet();
        if ($dCon) {
            $statusCon = $dCon['status'];
        }
    }
} elseif ($idsCon !== null) {
    // Opción 2: ID_CONSULTA
    echo "* hay ID Consulta<br>";
    $mCon->setID($idsCon);
    $mCon->det();
    $dCon = $mCon->getDet();
    if ($dCon) {
        echo " - existe detalle de consulta<br>";
        $statusCon = $dCon['status'];
        $idsPac = md5($dCon['pac_cod']);
        dep($idsPac);
        $mPac->setID($idsPac);
        $mPac->det();
        $dPac = $mPac->getDet();
    }
} elseif ($idsRes !== null) {
    // Opción 3: ID_RESERVA
    echo "* hay ID Reserva<br>";
    $mRes->setID($idsRes);
    $mRes->detResActive();
    $dRes = $mRes->getDet();
    $statusCon = 5;
    $idsPac = $dRes['pac_cod'] ?? null;
    if ($idsPac) {
        $mPac->setID(md5($idsPac));
        $mPac->det();
        $dPac = $mPac->getDet();
    }
} else {
    $view = false;
}

if ($dPac) $view = true;
/*
OBTAIN DETS

*/

$viewStatusCons = $mCon->statusCons($statusCon);

if ($view) {
    echo "<h1>Muestra Data VIEW $view</h1>";
} else {
    echo "<h1>NO Muestra Data VIEW $view</h1>";
}

dep($viewStatusCons, "STATUS CONS");
echo "<hr>";
dep($idsPac ?? null, "idsPac");
dep($idsCon ?? null, "idsCon");
dep($idsRes ?? null, "idsRes");
echo "<hr>";
dep($dPac ?? null, "dPac");
dep($dCon ?? null, "dCon");
dep($dRes ?? null, "dRes");
echo "<hr>";
