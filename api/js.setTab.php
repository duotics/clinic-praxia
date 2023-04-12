<?php require('../../init.php');
$val = $_REQUEST['val'] ?? null;
$mod = $_REQUEST['mod'] ?? '';
$_SESSION['tab'][$mod] = $val;
