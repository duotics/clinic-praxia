<!--BEG fieldset PAC TYPES-->
<fieldset class="">
    <div class="row mb-3">
        <label class="col-md-4 col-form-label" for="pac_tipsan">Tipo Sangre</label>
        <div class="col-md-8">
            <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPSAN'), 'pac_tipsan', $dPac['pac_tipsan'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$ids'") ?>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-4 col-form-label" for="pac_estciv">Estado Civil</label>
        <div class="col-md-8">
            <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'ESTCIV'), 'pac_estciv', $dPac['pac_estciv'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$ids'") ?>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-4 col-form-label" for="pac_sexo">Género</label>
        <div class="col-md-8">
            <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'SEXO'), 'pac_sexo', $dPac['pac_sexo'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$ids'") ?>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-md-4 col-form-label" for="pac_raza">Raza</label>
        <div class="col-md-8">
            <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'RAZA'), 'pac_raza', $dPac['pac_raza'] ?? null, ' form-control input-sm setDB', "data-rel='pac' data-id='$ids'") ?>
        </div>
    </div>
</fieldset>
<!--BEG fieldset PAC TYPES-->