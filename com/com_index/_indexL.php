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
        <div class="panel panel-danger">
            <div class="panel-heading">Consultas Programadas <span class="label label-danger"><?php echo $sdate ?></span></div>
            <div class="panel-body">
                Pendietes <span class="label label-danger"><?php echo count($lRes ?? 0) ?></span>
            </div>
            <?php if ($lRes) { ?>
                <ul class="list-group">
                    <?php foreach ($lRes as $row_RSCr) { ?>
                        <?php
                        $detRes_fec = $row_RSCr['DATEI'];
                        if ($row_RSCr['horai']) {
                            $detRes_hor = date('H:i', strtotime($row_RSCr['TIMEI']));
                            $detHor = '<span class="label label-default">' . $detRes_hor . '</span> ';
                        } else {
                            $detHor = '<span class="label label-default"><i class="fa fa-question-circle fa-lg"></i></span> ';
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
            <div class="panel-body">
                Atendidas <span class="label label-success"><?php echo count($lConH ?? 0) ?></span>
            </div>
            <?php if ($lConH > 0) { ?>
                <ul class="list-group">
                    <?php foreach ($lConH as $row_RSCh) { ?>
                        <?php
                        $detAud = detRow('db_auditoria', 'id_aud', $row_RSCh['AUD']);
                        $detAud_hor = date('H:i', strtotime($detAud['aud_datet']));
                        ?>
                        <li class="list-group-item">
                            <span class="label label-default"><?php echo $detAud_hor ?></span>
                            <span class="label label-info"><?php echo $row_RSCh['IDC'] ?></span>
                            <a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $row_RSCh['IDC'] ?>&idp=<?php echo $row_RSCh['IDP'] ?>">
                                <?php echo $row_RSCh['NOM'] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Consultas Ayer <span class="label label-default"><?php echo $sdateA ?></span></div>
            <div class="panel-body">
                Total Consultas <span class="label label-primary"><?php echo count($lConA ?? 0) ?></span>
            </div>
            <?php if ($lConA > 0) { ?>
                <ul class="list-group">
                    <?php foreach ($lConA as $row_RSCa) { ?>
                        <?php
                        $detAud = detRow('db_auditoria', 'id_aud', $row_RSCa['AUD']);
                        $detAud_hor = date('H:i', strtotime($detAud['aud_datet']));
                        ?>
                        <li class="list-group-item">
                            <span class="label label-default"><?php echo $detAud_hor ?></span>
                            <span class="label label-info"><?php echo $row_RSCa['IDC'] ?></span>
                            <a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $row_RSCa['IDC'] ?>">
                                <?php echo $row_RSCa['NOM'] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>