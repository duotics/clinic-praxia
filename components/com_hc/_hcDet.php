<?php

use App\Models\PacienteHC;

$mPacHC = new PacienteHC;
$mPacHC->setID($idsPac);
$mPacHC->det();
$dPacHC = $mPacHC->det;
?>

<div class="border-bottom pb-3 mb-3">
  <div class="row gy-3">
    <div class="col-sm-3">
      <label class="form-label" for="hc_antp">Antecedentes Personales</label>
      <textarea name="hc_antp" id="hc_antp" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_antp'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_antf">Antecedentes Familiares</label>
      <textarea name="hc_antf" id="hc_antf" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_antf'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_antf">Antecedentes Clínicos</label>
      <textarea name="hc_cli" id="hc_cli" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_cli'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_antf">Antecedentes Quirurgicos</label>
      <textarea name="hc_qui" id="hc_qui" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_qui'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_ale">Alergias</label>
      <textarea name="hc_ale" id="hc_ale" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_ale'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_ale">Toma Medicamentos</label>
      <textarea name="hc_tmed" id="hc_tmed" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_tmed'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_hab">Habitos</label>
      <textarea name="hc_hab" id="hc_hab" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_hab'] ?></textarea>
    </div>
    <div class="col-sm-3">
      <label class="form-label" for="hc_hab">Deportes</label>
      <textarea name="hc_depo" id="hc_depo" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB"><?php echo $dPacHC['hc_depo'] ?></textarea>
    </div>
  </div>
</div>
<!--  -->
<div class="mt-3">
  <div class="row">
    <div class="col-md-3">
      <div class="mb-2">
        <label class="col-xs-4 form-label"><strong>FUMA</strong></label>
        <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'SINO'), 'hc_fuma', $dPacHC['hc_fuma'], "form-control input-sm setDB", "data-rel='hc' data-id='$idsPac'") ?>
      </div>
      <div class="mb-2">
        <label for="hc_fumat" class="form-label">Tiempo Fuma (Años)</label>
        <input type="text" name="hc_fumat" id="hc_fumat" value="<?php echo $dPacHC['hc_fumat'] ?>" data-rel="hc" data-id="<?php echo $idsPac ?>" onChange="calcIT()" class="form-control setDB">
      </div>
      <div class="mb-2">
        <label for="hc_fumac" class="form-label">Cantidad Fuma (cigarrillos al día)</label>
        <input type="text" name="hc_fumac" id="hc_fumac" value="<?php echo $dPacHC['hc_fumac'] ?>" data-rel="hc" data-id="<?php echo $idsPac ?>" onChange="calcIT()" class="form-control setDB">
      </div>
      <div class="mb-2">
        <label for="resIT" class="form-label" data-toggle="tooltip" data-placement="left" title="El indice tabaquico sirve para calcular la posibilidad que tiene un fumador de sufrir de EPOC (Enfermedad Pulmonar Obstructiva Crónica) y que la mayoría de las veces es causada por el hecho de consumir tabaco o también de estar expuesto a humo, polvos, etc.">
          Indice Tabaquico
        </label>
        <div id="resIT"></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-3">
        <label for="hc_alco" class="form-label"><strong>ALCOHOL</strong></label>
        <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'SINO'), 'hc_alco', $dPacHC['hc_alco'], "form-control input-sm setDB", "data-rel='hc' data-id='$idsPac'") ?>
      </div>
      <div class="mb-2">
        <label for="hc_alcot" class="form-label">Tiempo Alcohol</label>
        <input type="text" name="hc_alcot" id="hc_alcot" value="<?php echo $dPacHC['hc_alcot'] ?>" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB" onChange="calcIT()">
      </div>
      <div class="mb-2">
        <label for="hc_alcoc" class="form-label">Cantidad Alcohol</label>
        <input type="text" name="hc_alcoc" id="hc_alcoc" value="<?php echo $dPacHC['hc_alcoc'] ?>" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB" onChange="calcIT()">
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-2">
        <label for="hc_drog" class="form-label"><strong>DROGAS</strong></label>
        <?php echo $db->genSelect($db->detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'SINO'), 'hc_drog', $dPacHC['hc_drog'], "form-control input-sm setDB", "data-rel='hc' data-id='$idsPac'") ?>
      </div>
      <div class="mb-2">
        <label for="hc_drogt" class="form-label">Tiempo Drogas</label>
        <input type="text" name="hc_drogt" id="hc_drogt" value="<?php echo $dPacHC['hc_drogt'] ?>" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB" onChange="calcIT()">
      </div>
      <div class="mb-2">
        <label for="hc_drogc" class="form-label">Cantidad Drogas</label>
        <input type="text" name="hc_drogc" id="hc_drogc" value="<?php echo $dPacHC['hc_drogc'] ?>" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB" onChange="calcIT()">
      </div>
    </div>
    <div class="col-md-3">
      <div class="mb-2">
        <label for="hc_obs" class="form-label">Observaciones</label>
        <textarea name="hc_obs" id="hc_obs" data-rel="hc" data-id="<?php echo $idsPac ?>" class="form-control setDB" rows="8"><?php echo $dPacHC['hc_obs'] ?></textarea>
      </div>
    </div>
  </div>
</div>


<script>
  calcIT();

  function calcIT() {
    var pFT = $('#hc_fumat').val();
    var pFC = $('#hc_fumac').val();
    var IT = (pFT / 20) * pFC;
    $('#resIT').removeClass();
    if (IT < 10) {
      $('#resIT').addClass('alert alert-primary');
      $('#resIT').html(IT + ' = Riesgo <strong>Nulo</strong> ');
    } else if ((IT >= 10) && (IT <= 20)) {
      $('#resIT').addClass('alert alert-info');
      $('#resIT').html('<h4>' + IT + ' = Riesgo <strong>MODERADO</strong></h4>* Probabilidad de desarrollar E.P.O.C.');
    } else if ((IT >= 21) && (IT <= 40)) {
      $('#resIT').addClass('alert alert-warning');
      $('#resIT').html('<h4>' + IT + ' = Riesgo <strong>INTENSO</strong></h4>* Probabilidad de desarrollar E.P.O.C.<br>* Probabilidad de desarrollar cáncer de pulmón');
    } else if (IT >= 41) {
      $('#resIT').addClass('alert alert-danger');
      $('#resIT').html('<h4>' + IT + ' = Riesgo <strong>ALTO</strong></h4>* Probabilidad de desarrollar E.P.O.C.<br>* Probabilidad de desarrollar cáncer de pulmón');
    }
  }
</script>