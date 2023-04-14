<?php
$objPac->PacienteInterfaz_ConsultaNav();
$objCon->ConsultaInterfaz_BotonHistory();
$objCon->ConsultaInterfaz_nav() ?>
<div><?php include("_formLatPac.php") ?></div>
<div class="ms-2 me-2 text-center">
    <?php echo $objCon->objBtnHis ?>
</div>
<div><?php echo $objCon->getobjNavList() ?></div>