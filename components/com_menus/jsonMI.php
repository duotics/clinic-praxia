<?php require('../../init.php');
$id=null;
if(isset($_REQUEST['id'])) $id=$_REQUEST['id'];
$qry=sprintf('SELECT * FROM dbMenuItem WHERE idMenu=%s', SSQL($id,'int'));//detRow('tbl_user','cli_doc',$_REQUEST['term']);
$RS=mysqli_query($conn,$qry);
$dRS=mysqli_fetch_assoc($RS);
$TR=mysqli_num_rows($RS);
$tiendas = array();
$tiendas[0]['id'] = '0';
$tiendas[0]['literal'] = '- Principal - ';
if($TR>0){
	$cont=1;
	do{
		$tiendas[$cont]['id'] = $dRS['idMItem'];
		$tiendas[$cont]['literal'] = $dRS['nomMItem'];
		$cont++;
	}while($dRS=mysqli_fetch_assoc($RS));
}
mysqli_free_result($RS);
echo json_encode($tiendas);
?>