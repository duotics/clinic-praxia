<?php
//Muestra información formateada
function edadOld($edad)
{
	if ($edad) {
		list($Y, $m, $d) = explode("-", $edad);
		return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
	} else return '-';
}
// Calcula la edad (formato: año/mes/dia)
function edad($edad)
{
	$ret = null;
	if ($edad) {
		$born = new DateTime($edad);
		$now = new DateTime(date("Y-m-d"));
		$diff = $now->diff($born);
		$ret['y'] = $diff->format("%y");
		$ret['yF'] = "$ret[y] años";
		$ret['m'] = $diff->format("%M");
		$ret['d'] = $diff->format("%d");
		$ret['full'] = "$ret[y] años, $ret[m] meses, $ret[d] dias";
	}
	return $ret;
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

function calcIMC($pesoKG = NULL, $talla = NULL)
{
	$IMC = null;
	$ret = null;
	if (($talla > 0) && ($pesoKG > 0)) {
		$talla = $talla / 100;
		$IMC = $pesoKG / ($talla * $talla);
		if ($IMC) {
			if (($IMC > 0) && ($IMC < 18)) {
				$ret = array("IMC" => $IMC, "min" => "Peso Bajo", "full" => "<span class='badge bg-danger'>Peso Bajo</span>", "css" => "bg-danger");
				//'<span class="label label-danger">Peso Bajo</span>';
			}
			if (($IMC >= 18) && ($IMC < 25)) {
				$ret = array("IMC" => $IMC, "min" => "Normal", "full" => "<span class='badge bg-info'>Normal</span>", "css" => "bg-info");
				//$infIMC='<span class="label label-info">Normal</span>';
			}
			if (($IMC >= 25) && ($IMC < 30)) {
				$ret = array("IMC" => $IMC, "min" => "Sobrepeso", "full" => "<span class='badge bg-success'>Sobrepeso</span>", "css" => "bg-success");
				//$infIMC='<span class="label label-success">Sobrepeso</span>';
			}
			if (($IMC >= 30) && ($IMC < 35)) {
				$ret = array("IMC" => $IMC, "min" => "Obesidad", "full" => "<span class='badge bg-warning'>Obesidad</span>", "css" => "bg-warning");
				//$infIMC='<span class="label label-warning">Obesidad I</span>';
			}
			if (($IMC >= 35) && ($IMC < 40)) {
				$ret = array("IMC" => $IMC, "min" => "Obesidad Severa", "full" => "<span class='badge bg-danger'>Obesidad Severa</span>", "css" => "bg-danger");
				//$infIMC='<span class="label label-warning">Obesidad II</span>';
			}
			if ($IMC >= 40) {
				$ret = array("IMC" => $IMC, "min" => "Obesidad Morbida", "full" => "<span class='badge bg-danger'>Obesidad Morbida</span>", "css" => "bg-danger");
				//$infIMC='<span class="label label-danger"> Obesidad III</span>';
			}
		}
	}
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

function edadC($dateBorn)
{
	$ret = NULL;
	if ($dateBorn) {
		$dateAct = $GLOBALS['sdate']; // separamos en partes las fechas 
		$array_nacimiento = explode("-", $dateBorn);
		$array_actual = explode("-", $dateAct);
		$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
		$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
		$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 
		//ajuste de posible negativo en $días 
		if ($dias < 0) {
			--$meses;
			//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
			switch ($array_actual[1]) {
				case 1:
					$dias_mes_anterior = 31;
					break;
				case 2:
					$dias_mes_anterior = 31;
					break;
				case 3:
					if (bisiesto($array_actual[0])) {
						$dias_mes_anterior = 29;
						break;
					} else {
						$dias_mes_anterior = 28;
						break;
					}
				case 4:
					$dias_mes_anterior = 31;
					break;
				case 5:
					$dias_mes_anterior = 30;
					break;
				case 6:
					$dias_mes_anterior = 31;
					break;
				case 7:
					$dias_mes_anterior = 30;
					break;
				case 8:
					$dias_mes_anterior = 31;
					break;
				case 9:
					$dias_mes_anterior = 31;
					break;
				case 10:
					$dias_mes_anterior = 30;
					break;
				case 11:
					$dias_mes_anterior = 31;
					break;
				case 12:
					$dias_mes_anterior = 30;
					break;
			}
			$dias = $dias + $dias_mes_anterior;
		}
		//ajuste de posible negativo en $meses 
		if ($meses < 0) {
			--$anos;
			$meses = $meses + 12;
		}
		$ret = $anos . " años <br> " . $meses . " meses <br> " . $dias . " días ";
	} else $ret;
	return ($ret);
}

function bisiesto($anio_actual)
{
	$bisiesto = false;
	//probamos si el mes de febrero del año actual tiene 29 días 
	if (checkdate(2, 29, $anio_actual)) {
		$bisiesto = true;
	}
	return $bisiesto;
}
