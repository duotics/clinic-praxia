<?php require('../../init.php');
$vP=false;
$ret=null;
$val['paS']=null;
$val['paD']=null;
if($_REQUEST['paS']) $val['paS']=$_REQUEST['paS'];
if($_REQUEST['paD']) $val['paD']=$_REQUEST['paD'];

if((($val['paS'])&&(isset($val['paS'])))&&(($val['paD'])&&(isset($val['paD'])))){
    $pa=calcPAm($val['paS'],$val['paD']);
    //var_dump($pa);
    if($pa['val']){
        $ret['val']=$pa['val'];
        $ret['inf']=$pa['inf'];
        $log=$pa['log'];
        $ret['est']=1;
        $vP=TRUE;
    }else{
        $log='function error no return. '.$pa['log'];
    }
}else{
    $log='no params';
}
$ret['log']=$log;
if($vP){
    $ret['val']=$pa['val'];
    $ret['inf']=$pa['inf'];
    $ret['est']=1;
}else{
    $ret['val']=null;
    $ret['inf']=null;
    $ret['est']=0;
}
echo json_encode(array( "val"=>$ret['val'],"inf"=>$ret['inf'],"log"=>$ret['log'],"est"=>$ret['est']) );
?>