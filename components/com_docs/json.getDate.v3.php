<?php include("../../init.php");
$dias = $_REQUEST['dias'] ?? 1;
$date = $_REQUEST['date'] ?? $sdate;
$diasGenerados = array();
$fechaActual = strtotime($date);

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

$salida = changeDateEnglishToSpanish($salida, "month");

echo $salida;