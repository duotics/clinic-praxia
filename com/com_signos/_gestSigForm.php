<?php
$dSig = null;
$btnNew = "<a href='$urlc?ids=$ids' class='btn btn-light btn-block'>{$cfg['i']['new']} {$cfg['b']['new']}</a>";
if ($idh) {
    $dSig = detRow('db_signos', 'id', $idh);
}
if (isset($dSig)) {
    $acc = md5('UPDs');
    $btnAcc = '<button type="submit" class="btn btn-success btn-block">' . $cfg['btn']['updI'] . ' ' . $cfg['btn']['updT'] . '</button>';
} else {
    $acc = md5('INSs');
    $btnAcc = '<button type="submit" class="btn btn-primary btn-block">' . $cfg['btn']['insI'] . ' ' . $cfg['btn']['insT'] . '</button>';
} //END Verifico si manipulo un registro
$btnNew = '<a href="' . $urlc . '?ids=' . $ids . '" class="btn btn-default btn-block">' . $cfg['btn']['newI'] . $cfg['btn']['newT'] . '</a>';
?>
<form method="post" action="_acc.php">
    <fieldset>
        <input name="idp" type="hidden" id="id" value="<?php echo $idp ?>">
        <input name="idh" type="hidden" id="idh" value="<?php echo $idh ?>">
        <input name="form" type="hidden" id="form" value="<?php echo md5('hispac') ?>">
        <input name="acc" type="hidden" value="<?php echo $acc ?>">
        <input name="url" type="hidden" value="<?php echo $urlc ?>">
    </fieldset>
    <div class="card p-2 mb-2">
        <div class="row">
            <div class="col-md-10">
                <!--<fieldset class="form-inline">-->
                <div class="form-row">
                    <div class="form-group row col-md-4 col-sm-12">
                        <label class="col-sm-5 col-form-label">Peso <small class="label label-default">kilogramos</small></label>
                        <div class="col-sm-7">
                            <input name="hpeso" type="number" step="any" class="form-control form-control-sm" placeholder="Peso en Kilogramos" value="<?php echo $dSig['peso'] ?? null ?>">
                        </div>
                    </div>
                    <div class="form-group row col-md-4">
                        <label class="col-sm-5 col-form-label">Talla <small class="label label-default">centimetros</small></label>
                        <div class="col-sm-7">
                            <input name="htalla" type="number" step="any" class="form-control form-control-sm" placeholder="Talla en centímetros" value="<?php echo $dSig['talla'] ?? null ?>">
                        </div>
                    </div>
                    <div class="form-group row col-md-4">
                        <label class="col-sm-5 col-form-label">I.M.C.</label>
                        <div class="col-sm-7">
                            <input name="himc" type="number" step="any" class="form-control form-control-sm" placeholder="Indice de Masa Corporal" value="<?php echo $dSig['imc'] ?? null ?>">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group row col-md-4 col-sm-12">
                        <label class="col-sm-5 col-form-label">Temperatura</label>
                        <div class="col-sm-7">
                            <input name="htemp" type="text" class="form-control form-control-sm" placeholder="0,00" value="<?php echo $dSig['temp'] ?? null ?>">
                        </div>
                    </div>
                    <div class="form-group row col-md-4">
                        <label class="col-sm-4 col-form-label">Presión Arterial</label>
                        <div class="col-sm-4">
                            <input name="hpaS" type="text" class="form-control form-control-sm" placeholder="Sistólica" value="<?php echo $dSig['paS'] ?? null ?>">
                        </div>
                        <div class="col-sm-4">
                            <input name="hpaD" type="text" class="form-control form-control-sm" placeholder="Diastólica" value="<?php echo $dSig['paD'] ?? null ?>">
                        </div>
                    </div>
                    <div class="form-group row col-md-4">
                        <label class="col-sm-5 col-form-label">Frecuencia Cardiaca</label>
                        <div class="col-sm-7">
                            <input name="hfc" type="text" class="form-control form-control-sm" placeholder="0" value="<?php echo $dSig['fc'] ?? null ?>">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group row col-md-4 col-sm-12">
                        <label class="col-sm-5 col-form-label">Frecuencia Respiratoria</label>
                        <div class="col-sm-7">
                            <input name="hfr" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig['fr'] ?? null ?? null ?>">
                        </div>
                    </div>
                    <div class="form-group row col-md-4">
                        <label class="col-sm-5 col-form-label">Saturación de Oxigeno</label>
                        <div class="col-sm-7">
                            <input name="hpo2" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig['po2'] ?? null ?? null ?>">
                        </div>
                    </div>
                    <div class="form-group row col-md-4">
                        <label class="col-sm-5 col-form-label">CO2</label>
                        <div class="col-sm-7">
                            <input name="hco2" type="text" class="form-control input-sm" placeholder="0" value="<?php echo $dSig['co2'] ?? null ?>">
                        </div>
                    </div>
                </div>
                <!--</fieldset>-->
            </div>
            <div class="col-md-2"><?php echo $btnAcc ?><?php echo $btnNew ?></div>
        </div>
    </div>
</form>