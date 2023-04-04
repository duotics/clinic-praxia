<?php include("../../init.php");
$goTo = routeM;
$_SESSION['dU'] = NULL;
$_SESSION['Auth'] = NULL;
unset($_SESSION['dU']);
unset($_SESSION['Auth']);
session_destroy();
header("Location: $goTo");
