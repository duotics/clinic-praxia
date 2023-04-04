<?php 
include('../_config.php');
require_once(RAIZ.'Connections/conn.php');
session_start();
$_SESSION['LOG']=NULL;
if(isset($_POST['id_sel'])) $id_sel=$_POST['id_sel'];
else $id_sel=$_GET['id_sel'];
if(isset($_POST['action'])) $action=$_POST['action'];
else $action=$_GET['action'];
//IF MOD USERS SYSTEM
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'USER')){
	$insertGoTo = 'users_list.php';
	if((isset($_POST['form']))&&($_POST['form']=='form_prod')){
		if((isset($action))&&($action=='UPDATE')){
			$qry='UPDATE tbl_productos SET prod_nom="'.$_POST['txt_nom'].'", mar_id="'.$_POST['id_mar_sel'].'", tip_cod="'.$_POST['id_tip_sel'].'", prod_obs="'.$_POST['txt_obs'].'"'.$valueimage_upd.' WHERE prod_id='.$id_sel;
			if(@mysqli_query(conn,$qry)){ $LOG.="Actualizado Correctamente. ID=".$id_sel; $action="UPDATE";}
			else $LOG.='<b>Error al Actualizar</b><br />';
		}
		if((isset($action))&&($action=='INSERT')){
			$qry='INSERT INTO tbl_productos (prod_nom, mar_id, tip_cod, prod_obs, prod_stat'.$valueimage_ins[1].')VALUES("'.$_POST['txt_nom'].'", "'.$_POST['id_mar_sel'].'", "'.$_POST['id_tip_sel'].'", "'.$_POST['txt_obs'].'", "1"'.$valueimage_ins[2].')';
			if(@mysqli_query(conn,$qry)){ $id_sel=@mysqli_insert_id(conn); $LOG.="Creado Correctamente. ID=".$id_sel; $action="UPDATE";
			}else $LOG.='<b>Error al Grabar</b><br />';
		}
		$LOG.=mysqli_error(conn);
		$insertGoTo = 'users_form.php?id_sel='.$id_sel.'&action='.$action;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_usuario WHERE usr_id="'.$id_sel.'"';
		if(@mysqli_query(conn,$qry)) $LOG.="Eliminado Correctamente :: ID = ".$id_sel;
		else $LOG.='<b>No se pudo Eliminar</b><br />';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_usuario SET user_status="'.$stat.'" WHERE usr_id='.$id_sel;
		if(@mysqli_query(conn,$qry)) $LOG.="Status Actualizado:: ID = ".$id_sel;
		else $LOG.='<b>Error al Actualizar Status</b><br />';
	}
	$LOG.=mysqli_error(conn);
}//END IF MOD USERS SYSTEM
$_SESSION['LOG']=$LOG;
if(mysqli_error(conn)) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $insertGoTo));
?>