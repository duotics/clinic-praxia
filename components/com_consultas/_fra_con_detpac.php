<?php
$dPac_fullnom = $dPac['pac_nom'] . ' ' . $dPac['pac_ape'];
$dPac_edad = edad($dPac['pac_fec']);
$dPac_edadpar = edad($dPac['pac_fecpar']);
$typ_tsan = dTyp($dPac['pac_tipsan']);
$typ_tsanpar = dTyp($dPac['pac_tipsanpar']);
$typ_eciv = dTyp($dPac['pac_estciv']);
$typ_sexo = dTyp($dPac['pac_sexo']);
$typ_tp = dTyp($dPac['pac_tipst']);
//Signos Vitales
$dPacSig = detSigLast($idp);
$IMC = $dPacSig['imc'] ?? null;
$IMC = calcIMC(NULL, $dPacSig['peso'] ?? null, $dPacSig['talla'] ?? null);
?>
<div class="minidPac">
    <table class="table table-condensed cero">
        <tr>
            <td><label title="ID. <?php echo $dPac['pac_cod'] ?>" class="tooltips">Paciente</label></td>
            <td style="font-size:16px;">
                <span title="Ver Ficha" class="tooltips"><a href="<?php echo route['c'] ?>com_pacientes/form.php?id=<?php echo $idp ?>">
                        <span class="label label-primary"><?php echo $idp ?></span> <?php echo $dPac_fullnom ?></a></span>
                <span title="Tipo Paciente" class="label label-default tooltips"><?php echo $typ_tp['typ_val'] ?? null ?></span>
                <span title="Nacimiento. <?php echo $dPac['pac_fec']; ?>" class="label label-default tooltips"><?php echo $dPac_edad ?> años</span>
                <span title="Cédula de Identidad" class="label label-default tooltips"><?php echo $dPac['pac_ced'] ?></span>
            </td>
        </tr>
        <tr>
            <td><label>Detalles</label></td>
            <td>
                <span title="Tipo Sangre" class="label label-default tooltips"><?php echo $typ_tsan['typ_val'] ?? null ?></span>
                <span title="Estado Civil" class="label label-default tooltips"><?php echo $typ_eciv['typ_val'] ?? null ?></span>
                <span title="Sexo" class="label label-default tooltips"><?php echo $typ_sexo['typ_val'] ?? null ?></span>
                <?php if ($dPac['pac_lugp']) { ?>
                    <span title="Procedencia" class="label label-default tooltips">
                        <i class="fa fa-map-marker"></i> <?php echo $dPac['pac_lugp'] ?></span>
                <?php } ?>
                <?php if ($dPac['pac_lugr']) { ?>
                    <span title="Residencia. <?php echo $dPac['pac_dir'] ?>" class="label label-default tooltips">
                        <i class="fa fa-map-marker"></i> <?php echo $dPac['pac_lugr'] ?></span>
                <?php } ?>
                <span title="Ocupación" class="label label-default tooltips"><?php echo $dPac['pac_ocu'] ?></span>
            </td>
        </tr>
        <tr>
            <td><label title="<?php echo $dPacSig['fecha'] ?>" class="tooltips">Signos</label></td>
            <td>
                <span title="Peso" class="badge tooltips">
                    <?php echo $dPacSig['peso'] ?? null ?> Kg.
                </span>
                <span title="Estatura" class="badge tooltips">
                    <?php echo $dPacSig['talla'] ?? null ?> cm.
                </span>
                <span title="IMC" class="badge tooltips">
                    <?php echo $IMC['val'] ?? null ?>
                </span>
                <?php echo $IMC['inf'] ?? null ?>
                <span title="Presion Arterial" class="badge tooltips">
                    <?php echo ($dPacSig['paS'] ?? null) . '/' . ($dPacSig['paD'] ?? null) ?> p.a.
                </span>
                <a href="<?php echo route['c'] ?>com_signos/gestSig.php?ids=<?php echo md5($dPac['pac_cod'] ?? null) ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyMed">
                    <i class="fa fa-check-square-o fa-lg"></i> Registrar
                </a>
            </td>
        </tr>
    </table>
</div>