<?php
/*Load vars to access to sections of architecture: 
const root (array with routes filesystem)
var $route (array with routes url), 
*/
require('paths.php');

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
