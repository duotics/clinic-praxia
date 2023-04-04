<?php
$id = null;
if (isset($_REQUEST['id'])) $id = $_REQUEST['id'];
$dPac = detRow('db_pacientes', 'pac_cod', $id);
$dPac_sexo = detRow('db_types', 'typ_cod', $dPac['pac_sexo']);
$qryLC = sprintf(
    "SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num DESC",
    SSQL($id, 'int')
);

$RSlc = mysqli_query(conn, $qryLC); //detRowGSel('db_consultas','con_num','con_num','pac_cod',$id,TRUE,'con_num','ASC');
$dRSlc = mysqli_fetch_assoc($RSlc);
$tRSlc = mysqli_num_rows($RSlc);
?>

<div id="repPrint" style="margin-top:40px">
    <?php echo genHeader($dM, 'header', null, null, null, null, 'h4') ?>
    <table class='table' style="font-size:12px">
        <tr>
            <td>Nombres</td>
            <td><?php echo $dPac['pac_ape'] . ' ' . $dPac['pac_nom'] ?></td>
            <td>Cedula</td>
            <td><?php echo $dPac['pac_ced'] ?></td>
        </tr>
        <tr>
            <td colspan="4">Ficha <?php echo $id ?> | Fecha Nacimiento <?php echo $dPac['pac_fec'] ?> | Sexo <?php echo $dPac_sexo['typ_val'] ?></td>
        </tr>
    </table>
    <?php if ($tRSlc > 0) { ?>

        <?php do { ?>
            <table class="table table-striped table-bordered" style="font-size:11px">
                <col style="width: 20%" class="col1">
                <col style="width: 20%">
                <col>

                <tr class="info" style="background:#eee">
                    <th>Fecha Visita</th>
                    <th>Tipo de Visita</th>
                    <th>Motivo de Consulta</th>
                </tr>
                <?php
                $dCon_tipcon = detRow('db_types', 'typ_cod', $dRSlc['con_typvis']);
                ?>
                <tr>
                    <td><?php echo $dRSlc['con_fec'] ?></td>
                    <td><?php echo $dCon_tipcon['typ_val'] ?></td>
                    <td><?php echo $dRSlc['dcon_mot'] ?></td>
                </tr>
                <!-- DIAGS / RECETAS -->
                <?php
                //DIAGNOSTICOS
                $qLD = sprintf(
                    'SELECT * FROM db_consultas_diagostico WHERE con_num=%s ORDER BY id ASC LIMIT 3',
                    SSQL($dRSlc['con_num'], 'int')
                );
                $RSld = mysqli_query(conn, $qLD);
                $dRSld = mysqli_fetch_assoc($RSld);
                $tRSld = mysqli_num_rows($RSld);
                $resDiag = null;
                if ($tRSld > 0) {
                    do {
                        if ($dRSld['id_diag'] > 1) {
                            $dDiag = detRow('db_diagnosticos', 'id_diag', $dRSld['id_diag']);
                            $dDiag_cod = $dDiag['codigo'] . '-';
                            $dDiag_nom = $dDiag['nombre'];
                        } else {
                            $dDiag_cod = NULL;
                            $dDiag_nom = $dRSld['obs'];
                        }
                        //$resDiag.='<tr>';
                        $resDiag .= $dDiag_cod . ' ' . $dDiag_nom . ' | ';
                        //$resDiag.='</tr>';
                    } while ($dRSld = mysqli_fetch_assoc($RSld));
                    //$resDiag.='</table>';
                }
                //RECETAS
                $qryConLst = sprintf(
                    'SELECT * FROM db_tratamientos WHERE con_num=%s ORDER BY tid DESC',
                    SSQL($dRSlc['con_num'], 'int')
                );
                $RSt = mysqli_query(conn, $qryConLst);
                $dRSt = mysqli_fetch_assoc($RSt);
                $trRSt = mysqli_num_rows($RSt);
                $resTrat = null;
                if ($trRSt > 0) {
                    do {
                        //$resTrat.='<ul>';
                        $qrytl = 'SELECT * FROM db_tratamientos_detalle WHERE tid=' . $dRSt['tid'] . ' AND tip="M" ORDER BY id ASC';
                        $RStl = mysqli_query(conn, $qrytl);
                        $dRStl = mysqli_fetch_assoc($RStl);
                        $trRStl = mysqli_num_rows($RStl);
                        if ($trRStl > 0) {
                            //$resTrat.='<li>';
                            do {
                                $resTrat .= $dRStl['generico'] . ' ' . $dRStl['comercial'] . ' | ';
                            } while ($dRStl = mysqli_fetch_assoc($RStl));
                            //$resTrat.='</li>';
                        }
                        //$resTrat.='</ul>';
                    } while ($dRSt = mysqli_fetch_assoc($RSt));
                }
                //EXAMENES
                $qry = sprintf(
                    'SELECT * FROM db_examenes WHERE con_num=%s ORDER BY id_exa DESC',
                    SSQL($dRSlc['con_num'], 'int')
                );
                $RSe = mysqli_query(conn, $qry);
                $dRSe = mysqli_fetch_assoc($RSe);
                $trRSe = mysqli_num_rows($RSe);
                $resExa = null;
                if ($trRSe > 0) {
                    do {
                        $dEF = detRow('db_examenes_format', 'id', $dRSe['id_ef']);
                        $tEFD = totRowsTab('db_examenes_det', 'ide', $dRSe['id_exa']);
                        //Total de Examenes con esta consulta
                        //$tECG=totRowsTab('db_examenes','con_num',$dRSe['con_num']);
                        $ExaResGen = NULL;
                        $btnPEC = NULL;
                        $vPEC = FALSE;
                        if ($tEFD > 0) {
                            $qryLTEF = sprintf(
                                'SELECT * FROM db_examenes_det WHERE ide=%s',
                                SSQL($dRSe['id_exa'], 'int')
                            );
                            $RSltef = mysqli_query(conn, $qryLTEF);
                            $dRSltef = mysqli_fetch_assoc($RSltef);
                            $tRSltef = mysqli_num_rows($RSltef);

                            do {
                                $detEFN = detRow('db_examenes_format_det', 'id', $dRSltef["idefd"]);
                                $resExa .= $detEFN['nom'] . ' | ';
                            } while ($dRSltef = mysqli_fetch_assoc($RSltef));
                        } else {
                            $resExa .= $dEF['nom'] . ' | ';
                        }
                    } while ($dRSe = mysqli_fetch_assoc($RSe));
                }
                //
                ?>
                <?php if ($tRSld > 0) { ?>
                    <tr>
                        <th>Diagnosticos</th>
                        <td colspan="2"><?php echo $resDiag ?></td>
                    </tr>
                <?php } ?>
                <?php if ($trRSt > 0) { ?>
                    <tr>
                        <th>Recetas</th>
                        <td colspan="2"><?php echo $resTrat ?></td>
                    </tr>
                <?php } ?>
                <?php if ($trRSe > 0) { ?>
                    <tr>
                        <th>Examenes</th>
                        <td colspan="2"><?php echo $resExa ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } while ($dRSlc = mysqli_fetch_assoc($RSlc)) ?>

</div>
<?php } else { ?>
    <div class="alert alert-info">
        <h4>No hay resultados de visitas</h4>
    </div>
<?php } ?>
<iframe id="loaderFrame" style="width: 0px; height: 0px; display: none;"></iframe>