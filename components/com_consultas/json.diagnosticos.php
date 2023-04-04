<?php include("../../init.php");

use App\Models\Diagnostico;

$mDiag = new Diagnostico;
$q = isset($_GET['q']) ? $_GET['q'] : '';
$res = $mDiag->getSearchDiag($q, 20);
echo json_encode($res);
