<?php include("../../init.php");

use App\Models\Medicamento;

$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idm = $_GET['idm'] ?? $_POST['idm'] ?? null;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$data = $_GET['data'] ?? $_POST['data'] ?? null;
$mMed = new Medicamento;
$vP = FALSE;
$LOG = null;
$ret = null;

if ($acc) {

    switch ($acc) {
        case "insMedGroup":
            $mMed->setID($idp);
            $mMed->insertMedicamentoGroup($idm);
            break;
    }
} else {
    $LOG = 'No action set';
}
echo json_encode(array("est" => $vP, "ret" => $ret, "log" => $LOG));
