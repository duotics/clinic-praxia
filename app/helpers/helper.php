<?php
//Muestra información formateada
function edad($edad)
{
	if ($edad) {
		list($Y, $m, $d) = explode("-", $edad);
		return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
	} else return '-';
}
function fnc_cutblanck($bus)
{
    if (substr($bus, 0, 1) == ' ') $bus = substr($bus, 1, strlen($bus));
    if (substr($bus, strlen($bus) - 1, 1) == ' ') $bus = substr($bus, 0, strlen($bus) - 1);
    return ($bus);
}

function calcIMCm($IMC = NULL, $pesoKG = NULL, $talla = NULL)
{

	global $RAIZi;
	$infIMC = null;
	$tallacm = $talla / 100;
	if ((!$IMC) || ($IMC == NULL) || ($IMC == 0)) {
		if (($tallacm > 0) && ($pesoKG > 0)) {
			$IMC = $pesoKG / ($tallacm * $tallacm);
		}
	}
	if ($IMC) {
		$retIMC['val'] = number_format($IMC, 2);
		if ($IMC <= 0) $infIMCb = ' <span class="btn btn-default btn-lg btn-block"> IMC </span> ';
		if (($IMC > 0) && ($IMC < 18)) {
			$infIMCb = '<span class="btn btn-danger btn-lg btn-block">Peso Bajo</span>';
		}
		if (($IMC >= 18) && ($IMC < 25)) {
			$infIMCb = '<span class="btn btn-info btn-lg btn-block">Normal</span>';
		}
		if (($IMC >= 25) && ($IMC < 30)) {
			$infIMCb = '<span class="btn btn-success btn-lg btn-block">Sobrepeso</span>';
		}
		if (($IMC >= 30) && ($IMC < 35)) {
			$infIMCb = '<span class="btn btn-warning btn-lg btn-block">Obesidad I</span>';
		}
		if (($IMC >= 35) && ($IMC < 40)) {
			$infIMCb = '<span class="btn btn-warning btn-lg btn-block">Obesidad II</span>';
		}
		if ($IMC >= 40) {
			$infIMCb = '<span class="btn btn-danger btn-block btn-lg"> Obesidad III</span>';
		}

		$infIMC .= '<a href="' . $RAIZi . 'struct/img-IMC-02.jpg" class="fancybox">' . $infIMCb . '</a>';
		$infIMC .= "
		<table class='table table-bordered cero' style='font-size:120%'>
		<tr><th>I.M.C.</th><th>$retIMC[val]</th><tr>
		<tr><td>$pesoKG kg.</td><td>$talla cm.</td><tr>
		</table>";


		$retIMC['inf'] = $infIMC;


		$retIMC['log'] = 'calculado';
	} else {
		$retIMC['log'] = 'no params';
	}
	return $retIMC;
}

function calcIMC($IMC = NULL, $pesoKG = NULL, $talla = NULL)
{
	$val = null;
	$IMC = null;

	$talla = (int)$talla / 100;
	if ((!$IMC) || ($IMC == NULL) || ($IMC == 0)) {
		if (($talla > 0) && ($pesoKG > 0)) {
			$valTalla = $talla * $talla;
			$IMC = (double)$pesoKG / (double)$valTalla;
		}
	}

	if ($IMC <= 0) $infIMC = ' <span class="label label-default"> IMC </span> ';
	if (($IMC > 0) && ($IMC < 18)) {
		$infIMC = '<span class="label label-danger">Peso Bajo</span>';
	}
	if (($IMC >= 18) && ($IMC < 25)) {
		$infIMC = '<span class="label label-info">Normal</span>';
	}
	if (($IMC >= 25) && ($IMC < 30)) {
		$infIMC = '<span class="label label-success">Sobrepeso</span>';
	}
	if (($IMC >= 30) && ($IMC < 35)) {
		$infIMC = '<span class="label label-warning">Obesidad I</span>';
	}
	if (($IMC >= 35) && ($IMC < 40)) {
		$infIMC = '<span class="label label-warning">Obesidad II</span>';
	}
	if ($IMC >= 40) {
		$infIMC = '<span class="label label-danger"> Obesidad III</span>';
	}
	if (isset($IMC)) $val = number_format($IMC, 2);
	$ret['val'] = $val;
	$ret['inf'] = $infIMC;

	return $ret;
}

function calcPAm($paS, $paD)
{
	global $RAIZi;
	$infPA = null;
	if ($paS && $paD) {
		if (($paS < 120) && ($paD < 80)) {
			$infPAb = '<span class="btn btn-success btn-lg btn-block">NORMAL</span>';
		}
		if ((($paS >= 120) && ($paS <= 129)) && ($paD < 80)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ELEVADA</span>';
		}
		if ((($paS >= 130) || ($paS <= 139)) && ($paD >= 80) && ($paD <= 89)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ALTA NIVEL 1</span>';
		}
		if (($paS >= 140) || ($paD >= 90)) {
			$infPAb = '<span class="btn btn-warning btn-lg btn-block">ALTA NIVEL 2</span>';
		}
		if (($paS >= 180) || ($paD >= 120)) {
			$infPAb = '<span class="btn btn-danger btn-lg btn-block">CRISIS HIPERTENSION</span>';
		}

		$infPA .= '<a href="' . $RAIZi . 'struct/img-PA-01.jpg" class="fancybox">' . $infPAb . '</a>';
		$infPA .= "
		<table class='table table-bordered cero' style='font-size:120%'>
		<tr><th>Sistolica $paS</th><th>Diastolica $paD</th><tr>
		</table>";

		$ret['val'] = $paS . '/' . $paD;
		$ret['inf'] = $infPA;


		$ret['log'] = 'calculado';
	} else {
		$ret['log'] = 'no params';
	}
	return $ret;
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
