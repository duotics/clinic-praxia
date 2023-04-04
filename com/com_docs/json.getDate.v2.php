<?php require_once('../../init.php');

function obtener_dias_letras($fecha, $num)
{
	// Convertir la fecha en formato d/m/Y a un objeto DateTime
	$fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha);

	// Crear un array con los nombres de los días de la semana en español
	$dias = array(
		'Domingo',
		'Lunes',
		'Martes',
		'Miércoles',
		'Jueves',
		'Viernes',
		'Sábado'
	);

	// Crear un array con los nombres de los meses en español
	$meses = array(
		'enero',
		'febrero',
		'marzo',
		'abril',
		'mayo',
		'junio',
		'julio',
		'agosto',
		'septiembre',
		'octubre',
		'noviembre',
		'diciembre'
	);

	// Crear una cadena de texto con los nombres de los días correspondientes
	$dias_letras = '';
	$mes_anterior = '';
	for ($i = 0; $i < $num; $i++) {
		// Obtener el nombre del mes y agregarlo a la cadena si ha cambiado desde el último día
		$mes_actual = $fecha_obj->format('m');
		if ($mes_actual != $mes_anterior) {
			if (!empty($dias_letras)) {
				// Agregar un punto y coma ";" si no es el primer mes
				$dias_letras .= '; ';
			}
			$dias_letras .= $meses[intval($mes_actual) - 1] . ': ';
			$mes_anterior = $mes_actual;
		}

		// Obtener el número de día y el nombre del día correspondiente y agregarlos a la cadena
		$dia = intval($fecha_obj->format('d'));
		$dia_letras = $dias[intval($fecha_obj->format('w'))];
		$dias_letras .= $dia . ' ' . $dia_letras;

		// Mover la fecha al siguiente día
		$fecha_obj->modify('+1 day');
	}

	return $dias_letras;
}

$dat = $_REQUEST;
$fecha = $dat["rFec"] ?? $sdate;
$dias = $dat["rDia"] ?? 1;
$finF = null;

$val = obtener_dias_letras($fecha, $dias);

if ($val) $est = 1;
else $est = 0;
$datos[] = array(
	'est' => $est,
	'val' => $val
);
echo json_encode($datos);
