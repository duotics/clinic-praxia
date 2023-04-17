<?php

use App\Models\Agendamiento;
use App\Models\Consulta;

$mCon = new Consulta;
$mRes = new Agendamiento;

//Fecha Ayer
$sdateA = strtotime('-1 day', strtotime(sys['date']));
$sdateA = date('Y-m-j', $sdateA);
//FECHAS HOY INICIO AL FIN
$sdatet_ini = sys['date'] . ' 00:00:00';
$sdatet_fin = sys['date'] . ' 23:59:59';

$sdatetA_ini = sys['date'] . ' 00:00:00';
$sdatetA_fin = sys['date'] . ' 23:59:59';

//CONSULTAS RESERVAS
$lRes = $mRes->getResBeetweenDates(sys['date'], sys['date']);
//CONSULTAS HOY
$lConH = $mCon->getConsBeetweenDates($sdatet_ini, $sdatet_fin);
//CONSULTAS AYER
$lConA = $mCon->getConsBeetweenDates($sdatetA_ini, $sdatetA_fin);
?>
<div class="row">
    <div class="col-sm-6">
        <div class="card border-primary mb-3">
            <h5 class="card-header bg-primary text-light">Visitas Hoy <span class="badge bg-light float-end"><?php echo sys['date'] ?></span></h5>
            <div class="card-body">
                Programadas <span class="badge bg-warning"><?php echo count($lRes ?? 0) ?></span>
            </div>
            <?php if ($lRes) { ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($lRes as $row_RSCr) { ?>
                        <?php
                        $detRes_fec = $row_RSCr['DATEI'];
                        if ($row_RSCr['TIMEI']) {
                            $detRes_hor = date('H:i', strtotime($row_RSCr['TIMEI']));
                            $detHor = '<span class="badge bg-light">' . $detRes_hor . '</span> ';
                        } else {
                            $detHor = '<span class="badge bg-light"><i class="fa fa-question-circle fa-lg"></i></span> ';
                        }
                        if ($row_RSCr['NOM']) {
                            $detTit = "<a href='" . route['c'] . "'com_consultas/form.php?idp={$row_RSCr['IDP']}&idr={$row_RSCr['ID']}'>
                            {$row_RSCr['NOM']}";
                            if ($row_RSCr['TYPE']) $detTit .= "| {$row_RSCr['TYPE']}";
                            $detTit .= "</a>";
                        } else {
                            $detTit = "{$row_RSCr['OBS']} ";
                            if ($row_RSCr['TYPE']) $detTit .= "| {$row_RSCr['TYPE']}";
                        }
                        ?>
                        <li class="list-group-item">
                            <?php echo $detHor ?>
                            <?php echo $detTit ?>
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
                        $detAud_hor = $AUD->detAudTime($row_RSCa['AUD']); ///$db->detRow('db_auditoria', null, 'id_aud', $row_RSCa['AUD']);
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