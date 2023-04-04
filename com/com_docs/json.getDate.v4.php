<?php include("../../init.php");
$numDias = $_REQUEST['dias'] ?? 1;
$fecha = $_REQUEST['date'] ?? null;

if (!$fecha) {
  $fecha = date('d-m-Y');
}

$fechaInicial = DateTime::createFromFormat('d-m-Y', $fecha);

if ($numDias == 1) {
  $nombreMes = $fechaInicial->format('F');
  $anio = $fechaInicial->format('Y');
  $numeroDia = $fechaInicial->format('j');
  $cadenaResultado = "$numeroDia de $nombreMes de $anio";
} else if ($numDias > 1) {
  $numDias--;
  $periodo = new DatePeriod($fechaInicial, new DateInterval('P1D'), $numDias);
  $resultado = [];
  $diasDelMes = [];
  $mesActual = '';

  foreach ($periodo as $dia) {
    $nombreMes = $dia->format('F');
    $anio = $dia->format('Y');
    $numeroDia = $dia->format('j');
    $nombreDia = $dia->format('l');

    if ($nombreMes !== $mesActual) {
      if (!empty($mesActual)) {
        $resultado[] = implode(',', $diasDelMes) . " de $mesActual";
      }
      $mesActual = $nombreMes;
      $diasDelMes = [];
    }

    $diasDelMes[] = " $nombreDia $numeroDia";
  }
  $resultado[] = implode(',', $diasDelMes) . " de $mesActual";
  $cadenaResultado = implode('; ', $resultado) . " de $anio";
}

$cadenaResultado = changeDateEnglishToSpanish($cadenaResultado, "all");

echo $cadenaResultado;
