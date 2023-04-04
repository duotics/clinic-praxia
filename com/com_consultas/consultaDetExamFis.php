<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <i class="fa fa-stethoscope fa-lg"></i> Examen Fisico
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <fieldset class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-5">Apariencia General</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_agen" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_agen'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Estado Nutricional</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_estn" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_estn'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Mucosas</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_muco" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_muco'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Cavidad Oral</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_cavo" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_cavo'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Conductos Auditivos</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_caud" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_caud'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Fosas Nasales</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_fosn" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_fosn'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Cuello</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_cue" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_cue'] ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">Orofaringe</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control setDB" name="dcon_ef_oro" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_ef_oro'] ?>" />
                        </div>
                    </div>

                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset class="form-horizontal">
                    <legend>TORAX</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-5">INSPECCION</label>
                        <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_ins" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_ins'] ?>" /></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">PERCUCION</label>
                        <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_per" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_per'] ?>" /></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">PALPACION</label>
                        <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_pal" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_pal'] ?>" /></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5">AUSCULTACION</label>
                        <div class="col-sm-7"><input type="text" class="form-control setDB" name="dcon_tor_aus" data-id="<?php echo md5($idc) ?>" data-rel="con" value="<?php echo $detCon['dcon_tor_aus'] ?>" /></div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>