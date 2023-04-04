<?php require_once('../../init.php');
$query = sprintf('SELECT * FROM db_medicamentos WHERE id_form=%s',
SSQL($_REQUEST['term'],'text'));
$RSjson = mysqli_query(conn,$query) or die(mysqli_error(conn));
$row = mysqli_fetch_assoc($RSjson);
$datos[] = array(
	'id' => $row['id_form'],
	'generico' => $row['generico'],
	'comercial' => $row['comercial'],
	'presentacion' => $row['presentacion'],
	'cantidad' => $row['cantidad'],
	'descripcion' => $row['descripcion'],
);
echo json_encode($datos);
?>