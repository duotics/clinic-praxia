<?php include("../init.php");
$Auth->vLogin();

use App\Models\Medicamento;

$mMed = new Medicamento;
$q = isset($_GET['q']) ? $_GET['q'] : '';
$res = $mMed->getSearchMed($q, 20);
echo json_encode($res);
