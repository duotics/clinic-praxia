<?php
/*
startConfigs();
$cfg = $_SESSION['conf'];
define("cfg", $cfg);
*/
date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL, "es_ES");
setlocale(LC_TIME, "es_ES");

$dateFormat = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);

$sdate = date('Y-m-d');
$sdatet = date('Y-m-d H:i:s');
$stime = date('H:i:s');
$sdateFull = changeDateEnglishToSpanish();

$sys['date'] = $sdate;
$sys['datet'] = $sdatet;
$sys['time'] = $stime;
$sys['datef'] = $sdateFull;
define('sys', $sys);

$dU = $_SESSION['dU'] ?? null;
define('dU', $dU);

$_SESSION['urlp'] = $_SESSION['urlc'] ?? null;
$_SESSION['urlc'] = basename($_SERVER['SCRIPT_FILENAME']); //URL clean Current;
$urlc = $_SESSION['urlc'];
$urlp = $_SESSION['urlp'];
//TEMA BOOTSTRAP
$bsTheme = $_SESSION['bsTheme'] ?? $_ENV["APP_THEME"] ?? "YETI";

require('paths.php');//RUTAS DEL SISTEMA
