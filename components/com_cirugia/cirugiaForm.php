<?php require('../../init.php');

use App\Models\Cirugia;
use App\Models\Paciente;

$mCir = new Cirugia;
$mPac = new Paciente;

$_SESSION['tab']['con'] = 'cCIR';
$acc = $_GET['acc'] ?? $_POST['acc'] ?? null;
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$idc = $_GET['idc'] ?? $_POST['idc'] ?? null;
$idr = $_GET['idr'] ?? $_POST['idr'] ?? null;

$mCir->setID($idr);
$mCir->det();
$detCir = $mCir->det;
if ($detCir) {
  $idp = $detCir['pac_cod'] ?? null;
  $idc = $detCir['con_num'] ?? null;
}
$mPac->setID(md5($idp));
$mPac->det();
$detpac = $mPac->det;
if ($detCir) {
  $idCir = $detCir['id_cir'];
  $lCirMult = $mCir->getAllMedia();
  $acc = md5("UPDc");
  $btnform = '<button type="button" id="vAcc" class="btn btn-success"><i class="fa fa-refresh fa-lg"></i> ACTUALIZAR</button>';
  $detCir_fecr = $detCir['fechar'];
} else {
  $acc = md5("INSc");
  $btnform = '<button type="button" id="vAcc" class="btn btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GRABAR</button>';
}
$css["body"] = 'cero';
include(RAIZf . 'head.php'); ?>
<?php sLOG('g'); ?>
<form action="actions.php" method="post" id="formexam" enctype="multipart/form-data">
  <fieldset>
    <input name="idr" type="hidden" id="idr" value="<?php echo $idr ?>">
    <input name="idp" type="hidden" id="idp" value="<?php echo $idp ?>">
    <input name="idc" type="hidden" id="idc" value="<?php echo $idc ?>">
    <input name="acc" type="hidden" id="acc" value="<?php echo $acc ?>">
    <input name="url" type="hidden" value="<?php echo $urlc ?>">
    <input name="form" type="hidden" id="form" value="<?php echo md5("fCir") ?>">
  </fieldset>
  <nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><i class="fa fa-medkit fa-lg"></i> CIRUGIA</a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a><?php echo $detpac['pac_nom'] . ' ' . $detpac['pac_ape'] ?></a></li>
          <li><a>Consulta: <span class="label label-default"><?php echo $idc ?></span></a></li>
          <li><a><?php echo $detCir['fecha'] ?? null ?></a></li>
        </ul>
        <div class="navbar-right btn-group navbar-btn">
          <?php echo $btnform ?>
          <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
        </div>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">
        <fieldset class="form-horizontal well well-sm">
          <div class="form-group">
            <label class="control-label col-sm-4" for="resultado">Diagnostico</label>
            <div class="col-sm-8">
              <input name="diagnostico" type="text" id="diagnostico" value="<?php echo $detCir['diagnostico'] ?? null ?>" class="form-control" autofocus>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="resultado"><strong>Cirugia Realizada</strong></label>
            <div class="col-sm-8">
              <input name="cirugiar" type="text" id="cirugiar" value="<?php echo $detCir['cirugiar'] ?? null ?>" class="form-control">
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-sm-4" for="fechar"><strong>Fecha Realizada</strong></label>
            <div class="col-sm-8">
              <input type="date" name="fechar" id="fechar" value="<?php echo $detCir_fecr ?? null ?>" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4" for="resultado">Protocolo</label>
            <div class="col-sm-8">
              <textarea name="protocolo" rows="5" class="form-control" id="protocolo" placeholder="Descripcion"><?php echo $detCir['protocolo'] ?? null ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="resultado">Evolucion</label>
            <div class="col-sm-8">
              <input name="evolucion" type="text" id="evolucion" value="<?php echo $detCir['evolucion'] ?? null ?>" class="form-control">
            </div>
          </div>
        </fieldset>
      </div>

      <div class="col-sm-4">
        <div class="well well-sm">
          <?php if ($detCir) { ?>
            <div class="well well-sm" style="background:#FFF">
              <textarea name="dfile" rows="2" class="form-control" id="dfile" placeholder="Descripcion de la Imagen"></textarea>
              <input name="efile[]" id="efile" type="file" onChange="uploadImage();" class="form-control" accept="image/gif, image/jpeg, image/png, image/bmp" multiple />
            </div>
            <?php if ($lCirMult) { ?>
              <div class="row">
                <?php foreach ($lCirMult as $row_RSfc) { ?>
                  <?php
                  $idRow = md5($row_RSfc['ID']);
                  $imgCir = vImg("data/db/cir/", $row_RSfc['FILE']);
                  $accUrl = md5("DELcm");
                  $btnDelPic = "<a href='actions.php?id=$idRow&acc=$accUrl&url=$urlc' class='btn btn-danger btn-xs'>{$cfg['b']['del']}</a>";
                  $btnViewPic = "<a href='{$imgCir['n']}' class='btn btn-primary btn-xs fancybox'>{$cfg['b']['view']}</a>";
                  ?>
                  <div class="col-sm-12">
                    <div class="thumbnail">
                      <img src="<?php echo $imgCir['t'] ?>">
                      <div class="caption">
                        <h3><?php echo $row_RSfc['DES'] ?></h3>
                        <div class="btn-group">
                          <?php echo $btnViewPic . $btnDelPic ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
              <ul class="thumbnails">
              </ul>
            <?php } else echo '<div class="alert alert-warning">No han guardado archivos de esta Cirugia</div>'; ?>
          <?php } else echo '<div class="alert alert-warning"><h4>No se puede cargar archivos</h4>Aun No Se ha Guardado la Cirugia</div>'; ?>
        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  function uploadImage() {
    formexam.submit();
  }
</script>
<?php include(RAIZf . 'footerC.php'); ?>