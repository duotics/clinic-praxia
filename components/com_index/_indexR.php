<div class="panel panel-default">
    <div class="panel-heading">Resumen</div>
    <?php
    $TR_Con = $db->totRowsTab('db_consultas', '1', '1');
    $TR_RepObs = $db->totRowsTab('db_rep_obs', '1', '1');
    $TR_RepEco = $db->totRowsTab('db_rep_eco', '1', '1');
    $TR_Trat = $db->totRowsTab('db_tratamientos', '1', '1');
    $TR_Exa = $db->totRowsTab('db_examenes', '1', '1');
    $TR_Cir = $db->totRowsTab('db_cirugias', '1', '1');
    $TR_Pac = $db->totRowsTab('db_pacientes', '1', '1');
    $TR_Doc = $db->totRowsTab('db_documentos', '1', '1');
    $TR_Sig = $db->totRowsTab('db_signos', '1', '1');
    $TR_Med = $db->totRowsTab('db_medicamentos', '1', '1');
    $TR_Ind = $db->totRowsTab('db_indicaciones', '1', '1');
    $TR_Diag = $db->totRowsTab('db_diagnosticos', '1', '1');
    ?>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="#">Pacientes</a>
            <span class="badge"><?php echo $TR_Pac ?></span>
        </li>
        <li class="list-group-item">
            <a href="#">Consultas</a>
            <span class="badge"><?php echo $TR_Con ?></span>
        </li>
        <li class="list-group-item">
            <a href="#">Recetas</a>
            <span class="badge"><?php echo $TR_Trat ?></span>
        </li>

        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_examen/">Examenes</a>
            <span class="badge"><?php echo $TR_Exa ?></span>
        </li>
        <li class="list-group-item">
            <a href="#">Documentos</a>
            <span class="badge"><?php echo $TR_Doc ?></span>
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_cirugia/">Cirugias</a>
            <span class="badge"><?php echo $TR_Cir ?></span>
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_signos/">Signos</a>
            <span class="badge"><?php echo $TR_Sig ?></span>
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_diagnostic/gest_diag.php">Diagnósticos</a>
            <span class="badge"><?php echo $TR_Diag ?></span>
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_tratamientos/gest_medicamentos.php">Medicamentos</a>
            <span class="badge"><?php echo $TR_Med ?></span>
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_tratamientos/gest_indicaciones.php">Indicaciones</a>
            <span class="badge"><?php echo $TR_Ind ?></span>
        </li>
    </ul>
</div>