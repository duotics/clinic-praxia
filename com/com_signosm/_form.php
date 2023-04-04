<?php
$idp = null;
$ids = null;
$auto = null;
$idp = $_GET['idp'] ?? null;
$ids = $_GET['ids'] ?? null;
$auto = $_GET['auto'] ?? null;
if ($idp) $dP = detRow('db_pacientes', 'pac_cod', $idp);
if ($ids) {
  $dS = detRow('db_signos', 'id', $ids);
  if ($dS) {
    $dP = detRow('db_pacientes', 'pac_cod', $dS['pac_cod']);
    $idp = $dP['pac_cod'];
  }
}
$_SESSION['sigm']['auto'] = 'si';
/*
if($auto=='no'){
  $_SESSION['sigm']['auto']='no';
  $logAuto= 'no auto';
}else{
  $_SESSION['sigm']['auto']='si';
  $logAuto= 'si auto';
}
*/
if ($idp) { //Tengo Paciente, puedo seguir con el proceso
  $_SESSION['sigm']['idp'] = $idp;

  if (isset($dS)) {
    $acc = md5('UPDs');
    $btnAcc = '<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> ACTUALIZAR</button>';
  } else {
    $acc = md5('INSs');
    $btnAcc = '<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> GRABAR</button>';
    $dSA = detSigLast($idp); //Previous data signs $dPacSig=detSigLast($idp);
    $dS['peso'] = $dSA['peso'] ?? null;
    $dS['talla'] = $dSA['talla'] ?? null;
  }
  $btnNew = '<a href="' . $urlc . '?idp=' . $idp . '" class="btn btn-default"><i class="fas fa-file"></i> Nuevo</a>';
}
?>
<?php if ($dP) { ?>
  <?php $img = vImg("data/db/pac/", lastImgPac($idp)); ?>
  <?php include('_form-pac.php') ?>
  <div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Registro</a></li>
      <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Historial</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active well" id="home">
        <?php include('_form-reg.php') ?>
      </div>
      <div role="tabpanel" class="tab-pane" id="profile">
        <?php include('_form-his.php') ?>
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class="alert alert-warning">
    <h4>Paciente No Existe</h4>
    <a href="index.php" class="btn btn-primary">Buscar Pacientes</a>
  </div>
<?php } ?>
<?php echo $logAuto ?? null ?>
<script type="text/javascript" src="js-0.2.js"></script>