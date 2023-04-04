<form method="post" action="_acc.php">
        <input name="idp" type="hidden" value="<?php echo $idp ?>">
        <input name="ids" type="hidden" value="<?php echo $ids ?>">
        <input name="form" type="hidden" value="<?php echo md5("hispac") ?>">
        <input name="url" type="hidden" value="<?php echo $urlc ?>">
        <input name="acc" type="hidden" value="<?php echo $acc ?>">
            <fieldset >
                <div class="row">
                    <div class="col-sm-9">
                        <fieldset class="form-horizontal">
                        <div class="form-group">
                            <label for="hpeso" class="col-sm-4 control-label">Fecha Registro</span></label>
                            <div class="col-sm-8">
                                <input class="form-control" type="text" placeholder="<?php echo $sdate ?>" readonly>
                            </div>
                        </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-3">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <?php echo $btnAcc ?>
                            </div>
                            <div class="btn-group" role="group">
                                <?php echo $btnNew ?>
                            </div>
                        </div>

                    </div>
                </div>
            </fieldset>
            <fieldset class="form-horizontal">
            <!--PESO / TALLA / IMC-->
            <div class="row">
                <div class="col-sm-9">
                <div class="form-group form-group-lg">
                    <label for="hpeso" class="col-sm-4 control-label">PESO <span class="label label-primary">kg.</span></label>
                    <div class="col-sm-8">
                        <input name="hpeso" id="hpeso" type="number" step="any" class="form-control" placeholder="Peso en Kilogramos" value="<?php echo $dS['peso']?>">
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label for="htalla" class="col-sm-4 control-label">TALLA <span class="label label-primary">cm.</span></label>
                    <div class="col-sm-8">
                        <input name="htalla" id="htalla" type="number" step="any" class="form-control" placeholder="Talla en Centímetros" value="<?php echo $dS['talla']?>">
                    </div>
                </div>
                </div>
                <div class="col-sm-3">
                    <div id="vIMC"></div>
                </div>
            </div>
            <!--TEMP / PRESION-->
            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group form-group-lg">
                        <label for="htemp" class="col-sm-4 control-label">TEMPERATURA <span class="label label-primary">°c</span></label>
                        <div class="col-sm-8">
                            <input list="htempL" name="htemp" type="number" min="35.0" max="43.1" step="0.1" class="form-control" id="htemp" placeholder="Temperatura en Grados centígrados" value="<?php echo $dS['temp'] ?? null ?>">
                            <?php echo genDataListNum('htempL','35.1','43.1','0.1');?>
                        </div>
                    </div>
                    <div class="form-group form-group-lg">
                        <label for="hpa" class="col-xs-12 col-sm-4 col-md-4 control-label">Presión Arterial <span class="label label-primary">S/D</span></label>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <input list="hpaSL" name="hpaS" id="hpaS" type="number" min="90" max="250" step="1" class="hpa form-control" placeholder="Presión Sistolica" value="<?php echo $dS['paS'] ?? null ?>">
                            <?php echo genDataListNum('hpaSL','100','220',5);?>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4">
                            <input list="hpaDL" name="hpaD" id="hpaD" type="number" min="50" max="150" step="1" class="hpa form-control" placeholder="Presión Diastólica" value="<?php echo $dS['paD'] ?? null ?>">
                            <?php echo genDataListNum('hpaDL','60','120',5);?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div id="vPA"></div>
                </div>
            </div>

            <!--FRECUENCIA CARD / RESP / PO2 / CO2 -->

            <div class="form-group form-group-lg">
                <label for="hfc" class="col-sm-3 control-label">Frecuencia Cardiaca</label>
                <div class="col-sm-9">
                    <input type="number" name="hfc" id="hfc" class="form-control" placeholder="0" value="<?php echo $dS['fc'] ?? null ?>">
                </div>
            </div>

            <div class="form-group form-group-lg">
                <label for="hfr" class="col-sm-3 control-label">Frecuencia Respiratoria</label>
                <div class="col-sm-9">
                    <input type="number" name="hfr" id="hfr" class="form-control" placeholder="0" value="<?php echo $dS['fr'] ?? null ?>">
                </div>
            </div>

            <div class="form-group form-group-lg">
                <label for="hpo2" class="col-sm-3 control-label">Saturación de Oxigeno</label>
                <div class="col-sm-9">
                    <input type="number" name="hpo2" id="hpo2" class="form-control" placeholder="0" value="<?php echo $dS['po2'] ?? null ?>">
                </div>
            </div>

            <div class="form-group form-group-lg">
                <label for="hco2" class="col-sm-3 control-label">CO2</label>
                <div class="col-sm-9">
                    <input type="number" name="hco2" id="hco2" class="form-control" placeholder="0" value="<?php echo $dS['co2'] ?? null ?>">
                </div>
            </div>

            <!--END VITAL SIGNS -->
            </fieldset>
    </form>