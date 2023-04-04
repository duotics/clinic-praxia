<?php include("../../init.php");

use App\Models\Consulta;

$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idd = $_GET['idd'] ?? $_POST['idd'] ?? null;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$data = $_GET['data'] ?? $_POST['data'] ?? null;
$mCon = new Consulta;
$vP = FALSE;
$LOG = null;
$ret = null;

if ($acc) {

    switch ($acc) {
        case "insConsDiag":
            $mCon->setID($idc);
            $ret = $mCon->insertConsultaDiagnostico($idd);
            break;
        case "insConsDiagOther":
            $mCon->setID($idc);
            $ret = $mCon->insertConsultaDiagnosticoOther($data);
            break;
        case "delConDiag":
            $ret = $mCon->deleteConsultaDiagnostico($id);
            break;
    }
} else {
    $LOG = 'No action set';
}
echo json_encode(array("est" => $vP, "ret" => $ret, "log" => $LOG));
