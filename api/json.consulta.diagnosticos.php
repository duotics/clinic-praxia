<?php include("../init.php");
$Auth->vLogin();

use App\Models\Consulta;

$mCon = new Consulta;
$ids = isset($_GET['ids']) ? $_GET['ids'] : '';
$mCon->setID($ids);
$res = $mCon->getAllDiag();
echo json_encode($res);
