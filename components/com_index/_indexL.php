<?php

use App\Models\Agendamiento;
use App\Models\Consulta;

$mCon = new Consulta;
$mRes = new Agendamiento;

//Fecha Ayer
$sdateA = strtotime('-1 day', strtotime($sdate));
$sdateA = date('Y-m-j', $sdateA);
//FECHAS HOY INICIO AL FIN
$sdatet_ini = $sdate . ' 00:00:00';
$sdatet_fin = $sdate . ' 23:59:59';

$sdatetA_ini = $sdateA . ' 00:00:00';
$sdatetA_fin = $sdateA . ' 23:59:59';

//CONSULTAS RESERVAS
$lRes = $mRes->getResBeetweenDates($sdate, $sdate);
//CONSULTAS HOY
$lConH = $mCon->getConsBeetweenDates($sdatet_ini, $sdatet_fin);
//CONSULTAS AYER
$lConA = $mCon->getConsBeetweenDates($sdatetA_ini, $sdatetA_fin);
?>
<div class="row">
    <div class="col-sm-6">
        <div class="card border-primary mb-3">
            <h5 class="card-header bg-primary text-light">Visitas Hoy <span class="badge bg-light float-end"><?php echo $sdate ?></span></h5>
            <div class="card-body">
                Programadas <span class="badge bg-warning"><?php echo count($lRes ?? 0) ?></span>
            </div>
            <?php if ($lRes) { ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($lRes as $row_RSCr) { ?>
                        <?php
                        $detRes_fec = $row_RSCr['DATEI'];
                        if ($row_RSCr['horai']) {
                            $detRes_hor = date('H:i', strtotime($row_RSCr['TIMEI']));
                            $detHor = '<span class="badge bg-light">' . $detRes_hor . '</span> ';
                        } else {
                            $detHor = '<span class="badge bg-light"><i class="fa fa-question-circle fa-lg"></i></span> ';
                        }
                        $detTyp = detRow('db_types', 'typ_cod', $row_RSCr['typ_cod']);
                        if ($detTyp) $detTyp_nom = ' / ' . $detTyp['typ_val'];
                        if ($row_RSCr['NOM']) {
                            $det_tit = '<a href="' . $RAIZc . 'com_consultas/form.php?idp=' . $row_RSCr['IDP'] . '&idr=' . $row_RSCr['ID'] . '">';
                            $det_tit .= $row_RSCr['NOM'] . $detTyp_nom;
                            $det_tit .= '</a>';
                        } else {
                            $det_tit = $row_RSCr['OBS'] . $detTyp_nom;
                        }
                        ?>
                        <li class="list-group-item">
                            <?php echo $detHor ?>
                            <?php echo $det_tit ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
            <div class="card-body bg-light">
                Atendidas <span class="badge bg-primary"><?php echo count($lConH ?? 0) ?></span>
            </div>
            <?php if ($lConH > 0) { ?>
                <table class="table table-sm"></table>
                <?php foreach ($lConH as $row_RSCh) { ?>
                    <?php
                    $detAud = $AUD->detAud($row_RSCh['AUD']);
                    $detAud_hor = date('H:i', strtotime($detAud['aud_datet']));
                    ?>
                    <tr>
                        <td>
                            <span class="badge bg-light"><?php echo $detAud_hor ?></span>
                        </td>
                        <td>
                            <span class="badg bg-info"><?php echo $row_RSCh['IDC'] ?></span>
                        </td>
                        <td>
                            <a href="<?php echo route['c'] ?>com_consultas/form.php?idc=<?php echo $row_RSCh['IDC'] ?>&idp=<?php echo $row_RSCh['IDP'] ?>">
                                <?php echo $row_RSCh['NOM'] ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card border-info mb-3">
            <h5 class="card-header bg-info text-light">Consultas Ayer <span class="badge bg-light float-end"><?php echo $sdateA ?></span></h5>
            <div class="card-body bg-light">
                Total Consultas <span class="badge bg-info"><?php echo count($lConA ?? 0) ?></span>
            </div>
            <?php if ($lConA > 0) { ?>
                <table class="table table-sm m-0 table-striped">
                    <?php foreach ($lConA as $row_RSCa) { ?>
                        <?php
                        $detAud_hor = $AUD->detAudTime($row_RSCa['AUD']);///$db->detRow('db_auditoria', null, 'id_aud', $row_RSCa['AUD']);
                        ?>
                        <tr>
                            <td>
                                <span class="badge bg-light"><?php echo $detAud_hor ?></span>
                            </td>
                            <td>
                                <span class="badge bg-info"><?php echo $row_RSCa['IDC'] ?></span>
                            </td>
                            <td>
                                <a href="<?php echo route['c'] ?>com_consultas/form.php?idc=<?php echo $row_RSCa['IDC'] ?>" class="text-decoration-none">
                                    <?php echo $row_RSCa['NOM'] ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>
</div>