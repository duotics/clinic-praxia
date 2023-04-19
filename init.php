<?php
if (!isset($_SESSION)) session_start(); //SESSION START
define('_JEXEC', 1); // Definir Constante para Verificar ejecución
ini_set('error_reporting', E_ALL); //Init error
$rootM = __DIR__; //Route Main App Folder, path is this file created
$rootP = dirname(__DIR__, 1); //Route Parent Main App Folder, one up level
require $rootM . '/vendor/autoload.php'; //Autoload init
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //Dotenv Init
$dotenv->load(); //Dotenv Loadvard

//Configurations, load system vars and paths vars
include("config/config.php");

//Use Main Models DATABASE, AUTHENTICATION, AUDITHORY
$db         =   new App\Core\Database;
$Auth       =   new App\Core\Auth;
$AUD       =   new App\Core\Audit;

$vD = FALSE; //Verify DEBUG, for show LOG Debug "LOGd"
$LOG = null; //Initialize $LOG
$LOGd = null; //Initialize $LOGd
