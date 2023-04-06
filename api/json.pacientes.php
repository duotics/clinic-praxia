<?php require_once('../init.php');

use App\Models\Paciente;

$mPac = new Paciente;
$term = $_GET['term'] ?? null;
$mPac->setTerm($term);
$lPacSearch = $mPac->getAllSearchPacTerm();
echo json_encode($lPacSearch);
