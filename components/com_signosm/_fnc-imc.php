<?php require('../../init.php');
$vP=false;
$ret=null;
$val['peso']=null;
$val['talla']=null;
if($_REQUEST['peso']) $val['peso']=$_REQUEST['peso'];
if($_REQUEST['talla']) $val['talla']=$_REQUEST['talla'];
if(($val['peso'])&&($val['talla'])){
    $imc=calcIMCm(null,$val['peso'],$val['talla']);
    if($imc['val']){
        $ret['val']=$imc['val'];
        $ret['inf']=$imc['inf'];
        $log=$imc['log'];
        $ret['est']=1;
        $vP=TRUE;
    }else{
        $log='function error no return. '.$imc['log'];
    }
}else{
    $log='no params';
}
$ret['log']=$log;
if($vP){
    $ret['val']=$imc['val'];
    $ret['inf']=$imc['inf'];
    $ret['est']=1;
}else{
    $ret['val']=null;
    $ret['inf']=null;
    $ret['est']=0;
}
echo json_encode(array( "val"=>$ret['val'],"inf"=>$ret['inf'],"log"=>$ret['log']) );
?>