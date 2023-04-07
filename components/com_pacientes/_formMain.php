<!-- PAC NAMES -->
<div class="row mb-3">
    <div class="col">
        <input name="pac_ape" type="text" required class="form-control form-control-lg" id="pac_ape" value="<?php echo $dPac['pac_ape'] ?? null ?>" placeholder="Apellidos Completos" />
    </div>
    <div class="col">
        <input name="pac_nom" type="text" required class="form-control form-control-lg" id="pac_nom" value="<?php echo $dPac['pac_nom'] ?? null ?>" placeholder="Nombres Completos" />
    </div>
</div>
<!-- PAC DATA -->
<div class="row mb-2">
    <div class="col-md-3 text-center">
        <?php if ($dPac) { ?>
            <a href="<?php echo $img['n'] ?>" data-fancybox>
                <img class="img-thumbnail img-fluid" src="<?php echo $img['t'] ?>">
            </a>
            <br>
            <a href="pacImg/pacImg.php?idp=<?php echo $ids ?>" class="btn btn-light btn-sm btn-block" data-fancybox>
                <i class="fa fa-camera fa-lg"></i> Cargar
            </a>
        <?php } else { ?>
            <a class="btn btn-light disabled"><i class="fa fa-picture-o fa-3x"></i><br>Foto</a>
        <?php } ?>
    </div>
    <div class="col-md-9">
        <!--BEG Fieldset-->
        <fieldset>
            <div class="row mb-2">
                <label class="col-sm-4 col-form-label">Registrado</label>
                <div class="col-sm-8">
                    <input name="pac_reg" type="text" class="form-control input-sm" value="<?php echo $dPac['pac_reg'] ?? null ?>" disabled>
                </div>
            </div>
            <div class="row mb-2">
                <label for="pac_nac" class="col-sm-4 col-form-label">Nacionalidad</label>
                <div class="col-sm-8">
                    <?php echo $db->genSelect($db->detRowGSel('dbPais', 'idPais', 'nomPais', '1', '1'), 'pac_nac', $dPac['pac_nac'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='{$ids}'"); ?>
                </div>
            </div>
            <div class="row mb-2">
                <label for="pac_ced" class="col-sm-4 col-form-label">Identificacion</label>
                <div class="col-sm-8">
                    <input name="pac_ced" type="text" class="form-control setDB" data-id="<?php echo $ids ?>" data-rel="pac" id="pac_ced" value="<?php echo $dPac['pac_ced'] ?? null ?>" placeholder="Cedula / RUC / Pasaporte">
                </div>
            </div>
            <div class="row mb-2">
                <label for="pac_fec" class="col-sm-4 col-form-label">Nacimiento</label>
                <div class="col-sm-4">
                    <input name="pac_fec" id="pac_fec" value="<?php echo $dPac['pac_fec'] ?? null ?>" data-id="<?php echo $ids ?>" data-rel="pac" type="date" class="form-control setDB" placeholder="Fecha" onChange="getDataVal(null,this.value,'FechaToEdad','viewEdad')" />
                </div>
                <div class="col-sm-4">
                    <span class="small" id="viewEdad"><?php echo edadC($dPac['pac_fec'] ?? null) ?></span>
                </div>
            </div>
        </fieldset>
        <!--END Fieldset-->
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#pac_nac').select2();
    });
</script>