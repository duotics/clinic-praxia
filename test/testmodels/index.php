<?php include("../../init.php");
echo "despues del init";
use App\Models\Paciente;
echo "despues del use paciente";
use App\Models\Componente;
echo "despues del use componente";

$mPac = new Paciente;
echo "despues del instnacia pac";
$mCom = new Componente;
echo "despues del instnacia com";
