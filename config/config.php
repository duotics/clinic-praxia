<?php
/*Load vars to access to sections of architecture: 
const root (array with routes filesystem)
var $route (array with routes url), 
*/
require('paths.php');

// Define la constante para el entorno (puedes cambiar 'development' por 'production' en el servidor de producción)
$environment = getenv('APP_ENV');
// Establecer la ruta al archivo de registro de errores
$logFilePath = __DIR__ . '/log/errors.log';

/// Configurar el manejo de errores según el entorno
if ($environment === 'PROD') {
    // En entorno de producción, ocultar los errores y advertencias
    error_reporting(E_ERROR);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', $logFilePath);
} else {
    // En entorno de desarrollo, mostrar todos los errores y advertencias
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    ini_set('log_errors', 'On');
    ini_set('error_log', $logFilePath);
}

//SET DEFAULT TIME AND LANGUAGE
date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL, "es_EC");
setlocale(LC_TIME, "es_EC");

//LOAD CONFIGURACIONS
define("cfg", $cfg = startConfigs("cfg"));
define("cfgBg", $cfgBg = startConfigs("cfgBg"));
define("cfgBus", $cfgBus = startConfigs("cfgBus"));

//VARS FOR DATE AND TIME
$dateFormat = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
$sys['date'] = date('Y-m-d');
$sys['datet'] = date('Y-m-d H:i:s');
$sys['time'] = date('H:i:s');
$sys['datefull'] = changeDateEnglishToSpanish();
define('sys', $sys);

//VARS FOR USER SESSION
$dU = $_SESSION['dU'] ?? null;
define('dU', $dU);

//VARS FOR SAVE URL ACTUAL AND PREVIOUS
$_SESSION['urlp'] = $_SESSION['urlc'] ?? null;
$_SESSION['urlc'] = basename($_SERVER['SCRIPT_FILENAME']); //URL clean Current;
$urlc = $_SESSION['urlc'];
$urlp = $_SESSION['urlp'];