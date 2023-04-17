<?php
require('paths.php'); //RUTAS de acceso a lugares del framework

date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL, "es_EC");
setlocale(LC_TIME, "es_EC");

define("cfg", $cfg = startConfigs("cfg"));
define("cfgBg", $cfgBg = startConfigs("cfgBg"));
define("cfgBus", $cfgBus = startConfigs("cfgBus"));

$dateFormat = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

$sys['date'] = date('Y-m-d');
$sys['datet'] = date('Y-m-d H:i:s');
$sys['time'] = date('H:i:s');
$sys['datefull'] = changeDateEnglishToSpanish();
define('sys', $sys);

$dU = $_SESSION['dU'] ?? null;
define('dU', $dU);

$_SESSION['urlp'] = $_SESSION['urlc'] ?? null;
$_SESSION['urlc'] = basename($_SERVER['SCRIPT_FILENAME']); //URL clean Current;
$urlc = $_SESSION['urlc'];
$urlp = $_SESSION['urlp'];
