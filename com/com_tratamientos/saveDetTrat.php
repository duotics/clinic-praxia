<?php require('../../init.php');
//=vParam('column');
$id=$_GET['id'] ?? $_POST['id'] ?? null;
$col=vParam('column',$_GET['column'],$_POST['column']);
$val=vParam('editval',$_GET['editval'],$_POST['editval']);
$qryU=sprintf('UPDATE db_tratamientos_detalle SET %s=%s WHERE id=%s',
			 SSQL($col,''),
			 SSQL($val,'text'),
			 SSQL($id,'int'));
mysqli_query(conn,$qryU);
?>