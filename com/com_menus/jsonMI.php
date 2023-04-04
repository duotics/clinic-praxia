<?php require('../../init.php');
$term=$_POST['id'];
$qry=sprintf('SELECT * FROM tbl_menus_items WHERE men_idc=%s', SSQL($term,'int'));//detRow('tbl_user','cli_doc',$_REQUEST['term']);
$RS=mysqli_query(conn,$qry);
$dRS=mysqli_fetch_assoc($RS);
$TR=mysqli_num_rows($RS);
$tiendas = array();
$tiendas[0]['id'] = '0';
$tiendas[0]['literal'] = '- Principal - ';
if($TR>0){
	$cont=1;
	do{
		$tiendas[$cont]['id'] = $dRS['men_id'];
		$tiendas[$cont]['literal'] = $dRS['men_nombre'];
		$cont++;
	}while($dRS=mysqli_fetch_assoc($RS));
}
mysqli_free_result($RS);
echo json_encode($tiendas);
?>