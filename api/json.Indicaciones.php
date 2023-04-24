<?php include("../init.php");
$Auth->vLogin();

use App\Models\Indicacion;

$mMed = new Indicacion;
$q = isset($_GET['q']) ? $_GET['q'] : '';
$res = $mMed->getAllAPI();
echo json_encode($res);
