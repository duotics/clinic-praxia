<?php include("../../init.php");

$sql = "SELECT * FROM dbComponente";
$val = $db->selectAllSQL($sql);

dep($val);
