<?php include("../../init.php");

use App\Models\Medicamento;

$mDiag = new Medicamento;
$q = isset($_GET['q']) ? $_GET['q'] : '';
$res = $mDiag->getSearchMed($q, 20);
echo json_encode($res);
