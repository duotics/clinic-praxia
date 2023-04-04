<?php
define('RAIZ0', $rootP . '/');
define('RAIZ', $root . '/');
define('RAIZa', RAIZ . 'assets/');
define('RAIZi', RAIZ . 'assets/images');
define('RAIZd', RAIZ . 'data/');
define('RAIZc', RAIZ . 'com/');
define('RAIZm', RAIZ . 'mods/');
define('RAIZf', RAIZ . 'frames/');
define('RAIZs', RAIZ . 'system/');
define('RAIZv', RAIZ . 'vendor/');
define('RAIZn', RAIZ . 'node_modules/');

global $RAIZ0, $RAIZ, $RAIZa, $RAIZi, $RAIZc, $RAIZd, $RAIZs, $RAIZv;
$RAIZ0 = $_ENV['APP_URLR'];
$RAIZ = $_ENV['APP_URL'];
$RAIZa = $RAIZ . 'assets/';
$RAIZi = $RAIZ . 'assets/images/';
$RAIZc = $RAIZ . 'com/';
$RAIZd = $RAIZ . 'data/';
$RAIZs = $RAIZ . 'system/';
$RAIZv = $RAIZ . 'vendor/';
$RAIZn = $RAIZ . 'node_modules/';

define('rootR', $rootP . '/');
define('rootM', $root . '/');
define('root', array(
    '0' => rootM,
    'a' => rootM . 'assets/',
    'c' => rootM . 'com/',
    'd' => rootM . 'data/',
    'i' => rootM . 'assets/images/',
    'm' => rootM . 'modulos/',
    'f' => rootM . 'frames/',
    's' => rootM . 'system/',
    'n' => rootM . 'node_modules/',
    'v' => rootM . 'vendor/'
));
//Paths url
define('routeR', $_ENV['APP_URLR']);
define('routeM', $_ENV['APP_URL']);
define('route', array(
    '0' => routeM,
    'a' => routeM . 'assets/',
    'c' => routeM . 'com/',
    'd' => routeM . 'data/',
    'i' => routeM . 'assets/images/',
    'm' => routeM . 'modulos/',
    'f' => routeM . 'frames/',
    's' => routeM . 'system/',
    'n' => routeM . 'node_modules/',
    'v' => routeM . 'vendor/',
));

/*
dep(rootM, "rootM");
dep(root, "root");
dep(routeM, "routeM");
dep(route, "route");
*/
/*
echo '$RAIZ. ' . $RAIZ . '<br>';
echo '$RAIZ0. ' . $RAIZ0 . '<br>';
echo 'RAIZ. ' . RAIZ . '<br>';
echo 'RAIZ0. ' . RAIZ0 . '<br>';
*/