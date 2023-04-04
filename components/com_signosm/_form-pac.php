<?php
$dPac_edad = edad($dP['pac_fec']);
$dPac_edadpar = edad($dP['pac_fecpar']);
$typ_tsan = dTyp($dP['pac_tipsan']);
$typ_tsanpar = dTyp($dP['pac_tipsanpar']);
$typ_eciv = dTyp($dP['pac_estciv']);
$typ_sexo = dTyp($dP['pac_sexo']);
$typ_tp = dTyp($dP['pac_tipst']);
//Signos Vitales
$dPacSig = detSigLast($idp);
$IMC = $dPacSig['imc'] ?? null;
$IMC = calcIMC(NULL, $dPacSig['peso'] ?? null, $dPacSig['talla'] ?? null);
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="cero">
            <a href="index.php" class="btn btn-primary">SIGNOS VITALES </a>
            <span class="label label-info"><?php echo $idp ?></span>
            <span class="label label-default"><?php echo $dP['pac_nom'] . ' ' . $dP['pac_ape'] ?></span>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-2 col-xs-6 text-center">
                <a href="<?php echo $img['n'] ?>" class="fancybox">
                    <img src="<?php echo $img['t'] ?>" class="img-thumbnail img-responsive " />
                </a>
            </div>
            <div class="col-sm-10 col-xs-6">

                <table class="table table-condensed cero" style="font-size:150%">
                    <tr>
                        <td><label>Detalles</label></td>
                        <td>
                            <span title="Nacimiento. <?php echo $dP['pac_fec']; ?>" class="label label-default tooltips"><?php echo $dPac_edad ?> años</span>
                            <span title="Cédula de Identidad" class="label label-default tooltips"><?php echo $dP['pac_ced'] ?></span>
                            <span title="Tipo Sangre" class="label label-default tooltips"><?php echo $typ_tsan['typ_val'] ?? null ?></span>
                            <span title="Estado Civil" class="label label-default tooltips"><?php echo $typ_eciv['typ_val'] ?? null ?></span>
                            <span title="Sexo" class="label label-default tooltips"><?php echo $typ_sexo['typ_val'] ?? null ?></span>
                            <?php if ($dP['pac_lugp']) { ?>
                                <span title="Procedencia" class="label label-default tooltips">
                                    <i class="fa fa-map-marker"></i> <?php echo $dP['pac_lugp'] ?></span>
                            <?php } ?>
                            <?php if ($dP['pac_lugr']) { ?>
                                <span title="Residencia. <?php echo $dP['pac_dir'] ?>" class="label label-default tooltips">
                                    <i class="fa fa-map-marker"></i> <?php echo $dP['pac_lugr'] ?></span>
                            <?php } ?>
                            <span title="Ocupación" class="label label-default tooltips"><?php echo $dP['pac_ocu'] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label title="<?php echo $dPacSig['fecha'] ?>" class="tooltips">Signos</label></td>
                        <td>
                            <?php if ($dPacSig) { ?>
                                <span title="Fecha Registro" class="label label-default tooltips"><?php echo $dPacSig['fecha'] ?></span>
                                <span title="Peso" class="label label-default tooltips"><?php echo $dPacSig['peso'] ?> Kg.</span>
                                <span title="Estatura" class="label label-default tooltips"><?php echo $dPacSig['talla'] ?> cm.</span>
                                <?php echo $IMC['inf'] ?>
                                <?php if ($dPacSig['temp']) { ?><span title="Temperatura" class="label label-default tooltips"><?php echo $dPacSig['temp'] ?> °C</span> <?php } ?>
                                <?php if ($dPacSig['paS'] && $dPacSig['paD']) { ?><span title="Presion Arterial" class="label label-default tooltips"><?php echo $dPacSig['paS'] . '/' . $dPacSig['paD'] ?> p.a.</span> <?php } ?>
                                <?php if ($dPacSig['fc']) { ?><span title="Frecuencia Cardiaca" class="label label-default tooltips"><?php echo $dPacSig['fc'] ?> f.c.</span> <?php } ?>
                                <?php if ($dPacSig['fr']) { ?><span title="Frecuencia Respiratoria" class="label label-default tooltips"><?php echo $dPacSig['fr'] ?> f.r.</span> <?php } ?>
                                <?php if ($dPacSig['po2']) { ?><span title="pO2" class="label label-default tooltips"><?php echo $dPacSig['po2'] ?> pO2</span> <?php } ?>
                                <?php if ($dPacSig['co2']) { ?><span title="cO2" class="label label-default tooltips"><?php echo $dPacSig['co2'] ?> cO2</span> <?php } ?>
                            <?php } else { ?>
                                <span class="label label-default">No hay historial de signos vitales</span>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>