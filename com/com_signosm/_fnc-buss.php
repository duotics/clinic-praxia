<?php require('../../init.php');
$LOG=null;
$idp=null;
$est=0;
$qUBP=sprintf('UPDATE db_busquedas_pac SET est=%s WHERE idp=%s',
    SSQL('1','int'),
    SSQL($idp,'int'),
);
$RS=mysqli_query(conn,$q) or die(mysqli_error(conn));
$dRS=mysqli_fetch_assoc($RS);
$tRS=mysqli_num_rows($RS);
//Verifico si encuentra registro
if($tRS){
    if($_SESSION['sigm']['idp']!=$dRS['idp']){
        $LOG.='Libre.';
        $idp=$dRS['idp'];
        $est=1;
    }else{
        $LOG.='En curso no retorna.';
    }
}else{
    $ret=array( "idp"=>null,"log"=>'No encontrado',"est"=>'0');
}
echo json_encode(array( "idp"=>$idp,"log"=>$LOG,"est"=>$est,"aux"=>$_SESSION['sigm']['idp']));
?>