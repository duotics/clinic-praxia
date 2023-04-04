<?php include('../../init.php');
$acc=null;
$accJS=null;
$js=null;
$id=null;
$ids=null;
$idp=null;
$idc=null;
$idd=null;
$url=null;
if(isset($_REQUEST['acc'])) $acc=$_REQUEST['acc'];
if(isset($_REQUEST['accJS'])) $accJS=$_REQUEST['accJS'];
if(isset($_REQUEST['js'])) $js=$_REQUEST['js'];
if(isset($_REQUEST['id'])) $id=$_REQUEST['id'];
if(isset($_REQUEST['ids'])) $ids=$_REQUEST['ids'];
if(isset($_REQUEST['idp'])) $idp=$_REQUEST['idp'];
if(isset($_REQUEST['idc'])) $idc=$_REQUEST['idc'];
if(isset($_REQUEST['idd'])) $idd=$_REQUEST['idd'];
if(isset($_REQUEST['url'])) $url=$_REQUEST['url'];
$data=$_REQUEST;
$vP=FALSE;
$dDoc=detRow('db_documentos','id_doc',$idd);

if($dDoc){
	$idp=$dDoc['pac_cod'];
	$idc=$dDoc['con_num'];
}
mysqli_query(conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query(conn,"BEGIN;"); //Inicia la transaccion

if (isset($data["btnA"])){
  // "Save Changes" clicked
	//$LOG.= 'Action';
} else if (isset($data["btnP"])){
	$accP=TRUE;
	$accJS=TRUE;
} else if (isset($data["btnJ"])){
	//$LOG.= 'Close';
	$accJS=TRUE;
}
if ((isset($data['form'])) && ($data['form'] == md5('fDocs'))){
	$LOGd='form fDocs. <br>'.$acc;
	if($acc==md5('INSd')){
		$LOGd='acc INSd. <br>';
		$qryinsd=sprintf('INSERT INTO db_documentos (pac_cod,con_num,nombre,contenido,fecha,id_df)
		VALUES (%s,%s,%s,%s,%s,%s)',
		SSQL($data['idp'], "int"),
		SSQL($data['idc'], "int"),
		SSQL($data['nombre'], "text"),
		SSQL($data['contenido'], "text"),
		SSQL($sdate, "date"),
		SSQL($data['iddf'], "int"));
		if(mysqli_query(conn,$qryinsd)){
			$vP=TRUE;
			$idd = mysqli_insert_id(conn);
			$LOG.=$cfg['p']['ins-true'];
		}else $LOG.=$cfg['p']['ins-false'].mysqli_error(conn);
	}
	if($acc==md5('UPDd')){
		$qryU=sprintf('UPDATE db_documentos SET nombre=%s,contenido=%s WHERE id_doc=%s',
		SSQL($data['nombre'], "text"),
		SSQL($data['contenido'], "text"),
		SSQL($idd, "int"));
		if(mysqli_query(conn,$qryU)){
			$vP=TRUE;
			$LOG.=$cfg['p']['upd-true'];
		}else $LOG.=$LOG.=$cfg['p']['upd-false'].mysqli_error(conn);
	}
	$url.='?idd='.$idd;
}
if ((isset($acc)) && ($acc == md5('DELd'))){
	$qry=sprintf('DELETE FROM db_documentos WHERE md5(id_doc)=%s LIMIT 1',
	SSQL($ids, "text"));
	$LOGd.=$qry;
	if(mysqli_query(conn,$qry)){
		$vP=TRUE;
		$LOG.=$cfg['p']['del-true'];
	}else $LOG.=$cfg['p']['del-false'].mysqli_error(conn);
}
//VERIFY COMMIT
if($vD==TRUE) $LOG.=$LOGd;
$LOGr['m']=$LOG;
if((!mysqli_error(conn))&&($vP==TRUE)){
	mysqli_query(conn,"COMMIT;");
	$LOGr['t']=$cfg['p']['m-ok'];
	$LOGr['c']=$cfg['p']['c-ok'];
	$LOGr['i']=$RAIZa.$cfg['p']['i-ok'];
}else{
	mysqli_query(conn,"ROLLBACK;");
	$LOGr['t']=$cfg['p']['m-fail'];
	$LOGr['c']=$cfg['p']['c-fail'];
	$LOGr['i']=$RAIZa.$cfg['p']['i-fail']; 
}
$_SESSION['LOG']=$LOGr;
mysqli_query(conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
/**/
if(($accJS==TRUE)||($js==1)){
	$css['body']='cero';
	include(RAIZf.'head.php'); ?>
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
    <iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>
    
    <a class="printerButton btn btn-light btn-sm" data-id="<?php echo $idd ?>" data-rel="<?php echo $RAIZc ?>com_docs/docPrintJS.php">
    <i class="fas fa-print fa-lg"></i></a>
    
	<script type="text/javascript">
	$(document).ready(function(){
		<?php if($accP){ ?>$(".printerButton").trigger("click"); 
		<?php }else{ ?>
		parent.location.reload();
		<?php } ?>
	});
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.jQuery.fancybox.getInstance().close();
	</script>
    <?php include(RAIZf.'footerC.php'); ?>
<?php }else{
	header(sprintf("Location: %s", $url));
}
?>