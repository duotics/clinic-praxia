<?php include('../../init.php');
$datefc = $_GET['datefc'] ?? $_POST['datefc'] ?? null; //start
$datefe = $_GET['datefe'] ?? $_POST['datefe'] ?? null; //end
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$detRes = detRow('db_fullcalendar', 'id', $id);
if ($detRes) {
  $acc = 'UPD';
  $accBtn = '<button class="btn btn-success navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
  $accBtn .= '<a class="btn btn-danger navbar-btn" href="actions.php?id=' . $id . '&acc=' . md5('DELE') . '"><i class="fa-solid fa-trash"></i> ELIMINAR</a>';
  $dfc_fechai = $detRes['fechai'];
  $dfc_horai = $detRes['horai'];
  $dfc_fechaf = $detRes['fechaf'];
  $dfc_horaf = $detRes['horaf'];
} else {
  $acc = 'INS';
  $accBtn = '<button class="btn btn-primary navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> GRABAR</button>';
  $dfc = explode("T", $datefc ?? "");
  $dfe = explode("T", $datefe ?? "");
  $dfc_fechai = $dfc[0] ?? null;
  $dfc_horai = $dfc[1] ?? null;
  $dfc_fechaf = $dfe[0] ?? null;
  $dfc_horaf = $dfe[1] ?? null;
  if (!$datefe) {
    $dfc_fechaf = $dfc[0];
    if ($dfc_horai) {
      $dfc_horaf = strtotime('+30 mins', strtotime($dfc_horai));
      $dfc_horaf = date('H:i:s', $dfc_horaf);
    }
  }
}
$qryLP = sprintf('SELECT pac_cod as sID, CONCAT(pac_nom," ",pac_ape) as sVAL FROM db_pacientes');
$RSLP = mysqli_query(conn, $qryLP);
$css['body'] = 'cero';
include(RAIZf . 'head.php');
?>
<?php sLOG('g') ?>
<form action="actions.php" method="post">
  <fieldset>
    <input name="id" type="hidden" id="id" value="<?php echo $id ?>">
    <input name="acc" type="hidden" id="acc" value="<?php echo md5($acc) ?>">
    <input name="url" type="hidden" id="url" value="<?php echo $urlc ?>">
    <input name="form" type="hidden" id="form" value="AGE">
  </fieldset>
  <nav class="navbar navbar-default navbar-inverse" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <a class="navbar-brand" href="#">RESERVAS</a>
      </div>

      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $id ?></a></li>
        <li><a href="#"><?php echo $datefc ?></a></li>
      </ul>
      <div class="btn-group pull-right">
        <?php echo $accBtn ?>
        <a href="<?php echo $urlc ?>" class="btn btn-default navbar-btn "><i class="fa fa-plus"></i> Nuevo</a>
      </div>

    </div><!-- /.container-fluid -->
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Datos Inicio</h3>
          </div>
          <div class="panel-body">
            <fieldset class="">
              <div class="form-group">
                <label for="fechai" class="control-label">Fecha</label>
                <input name="fechai" type="date" class="form-control" id="fechai" value="<?php echo $dfc_fechai ?>" placeholder="Fecha Inicio">
              </div>
              <div class="form-group">
                <label for="horai" class="control-label">Hora</label>
                <input name="horai" type="time" class="form-control" id="horai" value="<?php echo $dfc_horai ?>" placeholder="Hora Inicio">
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Datos Fin</h3>
          </div>
          <div class="panel-body">
            <fieldset class="">
              <div class="form-group">
                <label for="fechaf" class="control-label">Fecha</label>
                <input name="fechaf" type="date" class="form-control" id="fechaf" value="<?php echo $dfc_fechaf ?>" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="horaf" class="control-label">Hora</label>
                <input name="horaf" type="time" class="form-control" id="horaf" value="<?php echo $dfc_horaf ?>" placeholder="Email">
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <fieldset class="well form-horizontal">
          <div class="form-group">
            <label for="horaf" class="col-sm-3 control-label">Paciente</label>
            <div class="col-sm-9">
              <?php genSelect('pac_cod', $RSLP, $detRes['pac_cod'] ?? null, ' form-control '); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="horaf" class="col-sm-3 control-label">Tipo Visita</label>
            <div class="col-sm-9">
              <?php genSelect('typ_cod', detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPVIS'), $detRes['typ_cod'] ?? null, ' form-control '); ?>
            </div>
          </div>
          <div class="form-group">
            <label for="horaf" class="col-sm-3 control-label">Observaciones</label>
            <div class="col-sm-9">
              <textarea name="obs" id="obs" class="form-control"><?php echo $detRes['obs'] ?? null ?></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="horaf" class="col-sm-3 control-label">Estado</label>
            <div class="col-sm-9">
              <table width="200">
                <tr>
                  <td><label>
                      <input type="radio" name="est" value="1" id="est_0" <?php if (isset($detRes['est']) && $detRes['est'] == '1') echo ' checked ' ?>>
                      Pendiente</label></td>
                </tr>
                <tr>
                  <td><label>
                      <input type="radio" name="est" value="2" id="est_1" <?php if (isset($detRes['est']) && $detRes['est'] == '2') echo ' checked ' ?>>
                      Atendido</label></td>
                </tr>
                <tr>
                  <td><label>
                      <input type="radio" name="est" value="0" id="est_2" <?php if (isset($detRes['est']) && $detRes['est'] == '0') echo " checked " ?>>
                      Eliminar</label></td>
                </tr>
              </table>
            </div>
          </div>

        </fieldset>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript" src="js/js.js"></script>
<?php include(RAIZf . 'footer.php') ?>