<?php include('../../init.php');
//$dM=$Auth->vLogin('PACIENTE');
$url=null;
$acc=null;
$idp=null;
$idh=null;
$urlP=null;
if(isset($_REQUEST['url'])) $url=$_REQUEST['url'];
if(isset($_REQUEST['acc'])) $acc=$_REQUEST['acc'];
if(isset($_REQUEST['idp'])) $idp=$_REQUEST['idp'];
if(isset($_REQUEST['idh'])) $idh=$_REQUEST['idh'];
$data=$_REQUEST;
$vP=FALSE;
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion
if(($data['form'])&&($data['form']==md5('hispac'))){
	switch($acc){
		case md5('INSs');
			$qryI = sprintf("INSERT INTO db_signos (pac_cod,fecha,peso,paS,paD,talla,imc,temp,fc,fr,po2,co2) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
						SSQL($idp, "int"),
						SSQL($sdate, "date"),
						SSQL($data['hpeso'], "text"),
						SSQL($data['hpaS'], "int"),
						SSQL($data['hpaD'], "int"),
						SSQL($data['htalla'], "text"),
						SSQL($data['himc'], "text"),
						SSQL($data['htemp'], "text"),
						SSQL($data['hfc'], "text"),
						SSQL($data['hfr'], "text"),
						SSQL($data['hpo2'], "text"),
						SSQL($data['hco2'], "text"));
						$LOGd.=$qryI;
			if(mysqli_query(conn,$qryI)){
				$vP=TRUE;
				$LOG.=$cfg['p']['ins-true'];
			}else{
				$LOG.=$cfg['p']['ins-false'].mysqli_error(conn);
			}
		break;
		case md5('UPDs');
			$qryU = sprintf("UPDATE db_signos SET 
			peso=%s, paS=%s, paD=%s, talla=%s , imc=%s, temp=%s, fc=%s, fr=%s, po2=%s, co2=%s
			WHERE id=%s LIMIT 1",
						SSQL($data['hpeso'], "text"),
						SSQL($data['hpaS'], "int"),
						SSQL($data['hpaD'], "int"),
						SSQL($data['htalla'], "text"),
						SSQL($data['himc'], "text"),
						SSQL($data['htemp'], "text"),
						SSQL($data['hfc'], "text"),
						SSQL($data['hfr'], "text"),
						SSQL($data['hpo2'], "text"),
						SSQL($data['hco2'], "text"),
						SSQL($idh, "int")
			);
			if(mysqli_query(conn,$qryU)){
				$vP=TRUE;
				$LOG.=$cfg['p']['upd-true'];
			}else{
				$LOG.=$cfg['p']['upd-false'].mysqli_error(conn);
			}
		break;
	}
	$urlP.='?ids='.md5($idp);
}

if(isset($acc)&$acc==md5('delS')){
	$dHis=detRow('db_signos','id',$idh);
	if($dHis){
		$idp=md5($dHis['pac_cod']);
		$qry=sprintf('DELETE FROM db_signos WHERE id=%s LIMIT 1',
				 SSQL($idh,int));
		if(mysqli_query(conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg['p']['del-true'];
		}else{
			$LOG.=$cfg['p']['del-false'].mysqli_error(conn);
		}
		if(!$url) $url='gest_sig.php';
	}else{
		$LOG.=$cfg['p']['sel-false'];
	}
	$urlP.='?ids='.$idp;
}

if($vD==TRUE) $LOG.=$LOGd;

if((!mysqli_error(conn))&&($vP==TRUE)){
	mysqli_query(conn,"COMMIT;");
	$LOGt=$cfg['p']['m-ok'];
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$cfg['p']['i-ok'];
}else{
	mysqli_query(conn,"ROLLBACK;");
	$LOG.=mysqli_error(conn);
	$LOGt=$cfg['p']['m-fail'];
	$LOGc=$cfg['p']['c-fail'];
	$LOGi=$RAIZa.$cfg['p']['i-fail'];
}
mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;
$url.=$urlP;
header(sprintf("Location: %s", $url));
?>