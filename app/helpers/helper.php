<?php
//Muestra información formateada
function dep($data, $tit = null)
{
    $format = print_r("<div><small>BEG Debug [{$tit}] > " . date('Y-m-d H:i:s'));
    if (isset($data)) {
        $format .= print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
    } else $format .= print_r(' *null* ');
    $format = print_r(" END</small></div>");
    return $format;
}

function addBusinessDaysToDate(string $date, int $numDays): string
{
    $currDate = new DateTime($date);
    $weekends = [6, 7]; // Saturday and Sunday

    while ($numDays > 0) {
        $currDate->modify('+1 day');
        if (!in_array($currDate->format('N'), $weekends)) {
            $numDays--;
        }
    }

    return $currDate->format('Y-m-d');
}

function addDaysToDateNoWeekend(string $fecha, int $numDias): string
{
    // Convertir la fecha en un objeto DateTime
    $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);

    // Sumar los días a la fecha
    $fechaObj->modify("+$numDias days");

    // Verificar si la fecha resultante es un sábado o domingo
    $diaSemana = $fechaObj->format('N');
    if ($diaSemana >= 6) {  // 6 es sábado, 7 es domingo
        // Agregar los días necesarios para llegar al siguiente lunes
        $diasHastaLunes = 8 - $diaSemana;  // 8 es el número de días para llegar al lunes
        $fechaObj->modify("+$diasHastaLunes days");
    }

    // Formatear la fecha resultante según el formato deseado
    $fechaFormateada = $fechaObj->format('Y-m-d');

    // Devolver la fecha formateada
    return $fechaFormateada;
}

function changeDateEnglishToSpanish($fecha = null, $option = "all")
{
    if (!$fecha) $fecha = date("l, j \\d\\e F \\d\\e Y");
    $nuevafecha = null;
    $spanish_days = array(
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    );

    $spanish_months = array(
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    );
    switch ($option) {
        case "day":
            $nuevafecha = strtr($fecha, $spanish_days);
            break;
        case "month":
            $nuevafecha = strtr($fecha, $spanish_months);
            break;
        case "all":
            $nuevafecha = strtr($fecha, $spanish_days);
            $nuevafecha = strtr($nuevafecha, $spanish_months);
            break;
    }
    return $nuevafecha;
}
