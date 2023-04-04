<?php include_once('../../init.php');
$detDoc=detRow('db_documentos','id_doc',$id);
$detPac=detRow('db_pacientes','pac_cod',$detDoc['pac_cod']);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
$detPac_edad=edad($detPac['pac_fec']);
$dettrat_fecha=date_ame2euro($detDoc['fecha']);
?>
<?php $setTitle='DOCUMENTO: '.$detDoc['nombre']?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="5mm">
<page_header>
	<?php include(RAIZf.'fra_print_header_gen.php') ?>
</page_header>
<page_footer>
	<?php include(RAIZf.'fra_print_footer_gen.php') ?>
</page_footer>

<div style="margin-top:40px;">
<?php echo $detDoc['contenido'] ?>
</div>
</page>