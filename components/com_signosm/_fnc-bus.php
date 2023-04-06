<?php //coding
require('../../init.php');
$LOG=null;
$idp=null;
$est=0;
if($_SESSION['sigm']['auto']=='si'){
    $q=sprintf('select * from db_pacientes_bus WHERE fec=%s AND est=%s ORDER BY id DESC LIMIT 1',
        SSQL($sdate,'text'),
        SSQL('0','int'));
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
        $LOG.='No records';
    }
}else{
    $LOG.='No find, auto disabled';
}
echo json_encode(array( "idp"=>$idp,"log"=>$LOG,"est"=>$est,"aux"=>$_SESSION['sigm']['idp']));
?>