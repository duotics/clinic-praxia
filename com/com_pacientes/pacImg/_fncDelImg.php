<?php include('../../../init.php');
$ids=null;
if(isset($_REQUEST['ids'])) $ids=$_REQUEST['ids'];
$vP=false;
$ret=null;

$dPM=detRow('db_pacientes_media','md5(id)',$ids);
if($dPM){
    $qDPM=sprintf('DELETE FROM db_pacientes_media WHERE md5(id)=%s',
    SSQL($ids,'text'));
    if(mysqli_query(conn,$qDPM)){
        $vP=true;
        $LOG="Media Paciente eliminada correctamente. ".$ids;
    }else{
        $LOG="Error al eliminar Media Paciente".mysqli_error(conn);
    }
}else{
    $LOG="No existe Media Paciente".mysqli_error(conn);
}
if($vP==true){
    $ret['log']=$LOG;
    $ret['success']=true;
}else{
    $ret['log']=$LOG;
    $ret['success']=false;
}
exit(json_encode(['success' => $vP, 'log' => $LOG]));