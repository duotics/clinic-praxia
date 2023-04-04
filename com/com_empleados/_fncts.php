<?php include('../_config.php');
require_once(RAIZ.'/Connections/conn.php');
session_start();
$_SESSION['LOG']=NULL;
if(!($_FILES['userfile']['name'])) $resultado.="";
else{
	$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZ.'images/db/emp/';
	$param_file['pre']='emp';
	$aux_grab=uploadfile($param_file, $_FILES['userfile']);
	if($aux_grab[1]==1){$resultado.=$aux_grab[0];}
	else{
		$valueimageemp_upd=' ,emp_img="'.$aux_grab[2].'"';
		$valueimageemp_ins[1]=" ,emp_img";
		$valueimageemp_ins[2]=' ,"'.$aux_grab[2].'"';
	}
}
if ((isset($_POST["action_form"])) && ($_POST["action_form"] == "INSERT"))
{
	$queryins='INSERT INTO db_empleados(emp_ced,emp_nom,emp_ape,emp_dir,emp_tel1,emp_tel2,typ_cod,emp_img) VALUES("'.$_POST['txt_ced_emp'].'","'.$_POST['txt_nom_emp'].'","'.$_POST['txt_ape_emp'].'","'.$_POST['txt_dir_emp'].'","'.$_POST['txt_tel1_emp'].'","'.$_POST['txt_tel2_emp'].'","'.$_POST['txt_tip_emp'].'"'.$valueimageemp_ins[2].')';
if (@mysqli_query(conn,$queryins)){ $frm_emp_cod = @mysqli_insert_id(conn);
		$LOG.='Empleado Creado: INSERT ID:'.$frm_emp_cod.'. '.$_POST['txt_nom_emp'].' '.$_POST['txt_ape_emp'].'<br />';
	}else
		$LOG.='Error al Insertar';
	$insertGoTo = 'empleados_form.php?id_emp='.$frm_emp_cod.'&action_form=UPDATE';
}	
if ((isset($_POST["action_form"])) && ($_POST["action_form"] == "UPDATE"))
{
	$queryupd='UPDATE db_empleados SET emp_nom="'.$_POST['txt_nom_emp'].'", emp_ape="'.$_POST['txt_ape_emp'].'", emp_ced="'.$_POST['txt_ced_emp'].'", emp_dir="'.$_POST['txt_dir_emp'].'", emp_tel1="'.$_POST['txt_tel1_emp'].'", emp_tel2="'.$_POST['txt_tel2_emp'].'", typ_cod="'.$_POST['txt_tip_emp'].'"'.$valueimageemp_upd.' WHERE emp_cod="'.$_POST['txt_cod_emp'].'"';	
	if (@mysqli_query(conn,$queryupd))
		$LOG.='<b>Empleado Actualizado :: '.$_POST['txt_nom_emp'].' '.$_POST['txt_ape_emp'].'</b><br />';
	else
		$LOG.='Error al Actualizar';
	$insertGoTo = 'empleados_form.php?id_emp='.$_POST['txt_cod_emp'].'&action_form=UPDATE';
}	
$LOG.=mysqli_error(conn);
$_SESSION['LOG']=$LOG;
if(mysqli_error(conn)) $_SESSION['LOGr']="E";
header(sprintf("Location: %s", $insertGoTo));
?>