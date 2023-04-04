<?php include("../../init.php");
function generarDiasEntreFechas(string $fechaInicio, int $dias): string {
    $diasGenerados = array();
    $fechaActual = strtotime($fechaInicio);
    
    for ($i = 1; $i <= $dias; $i++) {
        $diasGenerados[] = date('Y-m-d', $fechaActual);
        $fechaActual = strtotime('+1 day', $fechaActual);
    }
    
    $meses = array();
    foreach ($diasGenerados as $dia) {
        $mes = date('F Y', strtotime($dia));
        if (!array_key_exists($mes, $meses)) {
            $meses[$mes] = array();
        }
        $meses[$mes][] = date('j', strtotime($dia));
    }
    
    $salida = '';
    foreach ($meses as $mes => $dias) {
        $salida .= $mes . ': ' . implode(', ', $dias) . '; ';
    }
    
    $salida=changeDateEnglishToSpanish($salida,"month");

    return $salida;
}



$fechaInicio = '2023-03-28';
$dias = 30;

$salida = generarDiasEntreFechas($fechaInicio, $dias);

echo $salida;