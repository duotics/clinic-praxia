<?php
if (!isset($_SESSION)) session_start();
define('_JEXEC', 1); // Este define una constante
ini_set('error_reporting', E_ALL);
$root = __DIR__;
$rootP = dirname(__DIR__, 1);
require $root . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include("config/config.php");

$db         =   new App\Core\Database;
$Auth       =   new App\Core\Auth;

$vD = FALSE;
$LOG = null;
$LOGd = null;
