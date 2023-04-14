<?php include("../../init.php");

$sql = "SELECT * FROM dbComponenteS";
$val = $db->selectSQL($sql);

dep($val);
