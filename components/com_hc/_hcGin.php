<?php

use App\Models\PacienteGIN;

$mPacGIN = new PacienteGIN;
$mPacGIN->setID($ids);
$mPacGIN->det();
$dPacGIN = $mPacGIN->det;
?>

<div class="row gy-3 mb-4 pb-4 border-bottom">
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Menarca</label>
    <input type="text" name="gin_men" id="gin_men" value="<?php echo $dPacGIN['gin_men'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Primera Menstruación</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Gestaciones</label>
    <input type="text" name="gin_ges" id="gin_ges" value="<?php echo $dPacGIN['gin_ges'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Numero de Gestaciones</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Vaginal</label>
    <input type="text" name="gin_pnor" id="gin_pnor" value="<?php echo $dPacGIN['gin_pnor'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Partos normales</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Cesareas</label>
    <input type="text" name="gin_pces" id="gin_pces" value="<?php echo $dPacGIN['gin_pces'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Cesareas Realizadas</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Vivos</label>
    <input type="text" name="gin_hviv" id="gin_hviv" value="<?php echo $dPacGIN['gin_hviv'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Hijos nacidos vivos</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Muertos</label>
    <input type="text" name="gin_hmue" id="gin_hmue" value="<?php echo $dPacGIN['gin_hmue'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Hijos nacidos muertos</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">Abortos</label>
    <input type="text" name="gin_abo" id="gin_abo" value="<?php echo $dPacGIN['gin_abo'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Cantidad de Abortos</div>
  </div>
</div>
<!-- -->
<div class="row gy-3 pb-4">
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">FUM</label>
    <input type="text" name="gin_fun" id="gin_fun" value="<?php echo $dPacGIN['gin_fun'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Fecha de última menstruación</div>
  </div>
  <div class="col-sm-3">
    <label for="gin_men" class="form-label">CM</label>
    <input type="text" name="gin_cicm" id="gin_cicm" value="<?php echo $dPacGIN['gin_cicm'] ?>" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" placeholder="0">
    <div class="form-text">Ciclo Menstrual</div>
  </div>
  <div class="col-sm-6">
    <label for="gin_men" class="form-label">Observaciones</label>
    <textarea name="gin_obs" id="gin_obs" data-rel="gin" data-id="<?php echo $idRT ?>" class="form-control setDB" rows="4"><?php echo $dPacGIN['gin_obs'] ?></textarea>
  </div>
</div>