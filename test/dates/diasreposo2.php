<?php
function obtenerDias($fecha = null, $numDias = 1)
{
    if (!$fecha) {
        $fecha = date('d-m-Y');
    }

    $fechaInicial = DateTime::createFromFormat('d-m-Y', $fecha);
    $periodo = new DatePeriod($fechaInicial, new DateInterval('P1D'), $numDias);

    $resultado = [];
    $diasDelMes = [];
    $mesActual = '';

    foreach ($periodo as $dia) {
        $nombreMes = $dia->format('F');
        $anio = $dia->format('Y');
        $numeroDia = $dia->format('j');

        if ($nombreMes !== $mesActual) {
            if (!empty($mesActual)) {
                $resultado[] = implode(',', $diasDelMes) . " de $mesActual";
            }
            $mesActual = $nombreMes;
            $diasDelMes = [];
        }

        $diasDelMes[] = $numeroDia;
    }

    $resultado[] = implode(',', $diasDelMes) . " de $mesActual";
    $cadenaResultado = implode('; ', $resultado) . " de $anio";

    return $cadenaResultado;
}

$fecha = "29-03-2023";
$numDias = 60;

echo obtenerDias($fecha, $numDias);
