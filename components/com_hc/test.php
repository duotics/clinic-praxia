<?php
function dias_transcurridos($FUM,$FACT){
	$dias = (strtotime($FUM)-strtotime($FACT))/86400;
	$dias = abs($dias); $dias = floor($dias);		
	return $dias;
}
// Ejemplo de uso:
echo dias_transcurridos('2012-08-31','2012-09-11');
// Salida : 17?>