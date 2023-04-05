<?php include_once('../../init.php');
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$det = detRow('db_documentos', 'id_doc', $id); //fnc_datatrat($id);
$detCon = detRow('db_consultas', 'con_num', $det['con_num']); //fnc_datatrat($id);
//$detpac=detRow('db_pacientes','pac_cod',$detCon['pac_cod']);//dPac($det['pac_cod']);
$dPac = detRow('db_pacientes', 'pac_cod', $detCon['pac_cod']);
$css["body"] = 'cero';
include(root['f'] . 'head.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo route['a'] ?>css/cssPrint_01-02.css" />
<div class="print print-documento">

	<?php
	//if($det[contenido]) $contenido = str_replace('{RAIZ}',$RAIZ,$det[contenido]);
	echo $det["contenido"] //$contenido;
	?>
</div>