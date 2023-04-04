<?php require_once('../../init.php');
$query = sprintf('SELECT * FROM db_indicaciones WHERE id=%s',
SSQL($_REQUEST['term'],'text'));
$RSjson = mysqli_query(conn,$query) or die(mysqli_error(conn));
$row = mysqli_fetch_assoc($RSjson);
$datos[] = array(
	'id' => $row['id'],
	'des' => $row['des']
);
echo json_encode($datos);
?>