<div class="card">
    <div class="card-header">Historial Recetas</div>
    <?php if ($listadoTratamientosAnteriores) { ?>
        <table class="table table-condensed">
            <?php foreach ($listadoTratamientosAnteriores as $dRS) { ?>
                <?php
                $listTratAntDetMed = $mTrat->listTratamientosDetalle($dRS['tid'], 'M');
                $listTratAntDetInd = $mTrat->listTratamientosDetalle($dRS['tid'], 'I');
                $resDiag = NULL;
                $mCon->setID(md5($dRS['con_num']));
                $listConsDiag = $mCon->getAllDiag(2);
                if ($listConsDiag > 0) {
                    foreach ($listConsDiag as $dRSld) {
                        $resDiag .= "<span class='btn btn-default btn-xs'>{$dRSld['NOM']}</span>";
                    }
                }
                $fecConAnt = DateTime::createFromFormat('Y-m-d', $dRS['fecha']);
                $fecConAnt = $fecConAnt->format('d \d\e F \d\e Y');
                $fecConAnt = changeDateEnglishToSpanish($fecConAnt);
                ?>
                <tr class="info">
                    <td colspan="2" class="">
                        <span class="btn btn-info btn-xs"><?php echo $fecConAnt ?></span>
                        <?php echo $resDiag ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php if ($listTratAntDetMed) { ?>
                            <table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
                                <tbody>
                                    <?php foreach ($listTratAntDetMed as $dRStl) { ?>
                                        <?php $detTdet_med = $dRStl['generico'] . ' ( ' . $dRStl['comercial'] . ' )'; ?>
                                        <tr>
                                            <td><?php echo $detTdet_med ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else echo '<div>No hay Medicamentos Prescritos</div>' ?>
                    </td>
                    <td>
                        <?php if ($listTratAntDetInd) { ?>
                            <table class="table table-bordered" style="font-size:0.8em; margin-bottom:0px;">
                                <tbody>
                                    <?php foreach ($listTratAntDetInd as $dRStli) { ?>
                                        <tr>
                                            <td><?php echo $dRStli['indicacion'] ?></td>
                                        <?php } ?>
                                </tbody>
                            </table>
                        <?php } else echo '<div>No hay Indicaciones</div>' ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="card-body">
            <p>No hay recetas anteriores</p>
        </div>
    <?php } ?>
</div>