<?php require_once('../../init.php');
$idp = $_GET['idp'] ?? $_POST['idp'] ?? null;
$id = $_GET['id'] ?? $_POST['id'] ?? null;
$detRes = detRow('db_fullcalendar', 'id', $id);
if ($detRes) {
  $idp = $detRes['pac_cod'];
  $acc = 'UPD';
  $accBtn = '<button class="btn btn-success navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
  $accBtn .= '<a class="btn btn-danger navbar-btn" href="actions.php?id=' . $id . '&acc=' . md5('DELE') . '"><i class="fa-solid fa-trash"></i></a>';
} else {
  $acc = 'INS';
  $accBtn = '<button class="btn btn-primary navbar-btn"><i class="fa fa-floppy-o fa-lg"></i> GRABAR</button>';
}
$detPac = detRow('db_pacientes', 'pac_cod', $idp);
$detPac_nom = $detPac['pac_nom'] . ' ' . $detPac['pac_ape'];
$qrylr = sprintf(
  'SELECT * FROM db_fullcalendar WHERE pac_cod=%s ORDER BY id DESC',
  SSQL($idp, 'int')
);
$RSlr = mysqli_query(conn, $qrylr) or die(mysqli_error(conn));
$row_RSlr = mysqli_fetch_assoc($RSlr);
$tr_RSlr = mysqli_num_rows($RSlr);
$cssBody = 'cero';
include(root['f'] . 'head.php'); ?>
<div class="container">
  <div class="page-header">
    <h1>Reservar Cita <small><?php echo $detPac_nom ?>
        <span class="label label-info"><?php echo $detPac['pac_cod']; ?></span></small></h1>
  </div>
  <?php sLOG('g') ?>
  <div class="row">
    <div class="col-sm-7">
      <form action="actions.php" method="post">
        <fieldset>
          <input name="id" type="hidden" id="id" value="<?php echo $id ?>">
          <input name="acc" type="hidden" id="acc" value="<?php echo md5($acc) ?>">
          <input name="form" type="hidden" id="form" value="AGE">
          <input name="pac_cod" type="hidden" id="pac_cod" value="<?php echo $idp ?>">
        </fieldset>
        <nav class="navbar navbar-default navbar-inverse" role="navigation">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">RESERVAS</a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#"><?php echo $id ?></a></li>
              <li><a href="#"><?php echo $datefc ?></a></li>
            </ul>
            <div class="btn-group pull-right">
              <?php echo $accBtn ?>
              <a href="<?php echo $_SESSION['urlc'] ?>?idp=<?php echo $idp ?>" class="btn btn-default navbar-btn "><i class="fa fa-plus"></i></a>
            </div>
          </div><!-- /.navbar-collapse -->
        </nav>
        <div class="row">
          <div class="col-sm-5">
            <fieldset>
              <div class="form-group">
                <label for="fechai" class="control-label">Fecha Inicio</label>
                <input name="fechai" type="date" class="form-control" id="fechai" value="<?php echo $detRes['fechai'] ?>" placeholder="Fecha Inicio" required>
              </div>
              <div class="form-group">
                <label for="horai" class="control-label">Hora Inicio</label>
                <input name="horai" type="time" class="form-control" id="horai" value="<?php echo $detRes['horai'] ?>" placeholder="Hora Inicio">
              </div>
              <div class="form-group">
                <label for="fechaf" class="control-label">Fecha Fin</label>
                <input name="fechaf" type="date" class="form-control" id="fechaf" value="<?php echo $detRes['fechaf'] ?>" placeholder="Email" required>
              </div>
              <div class="form-group">
                <label for="horaf" class="control-label">Hora Fin</label>
                <input name="horaf" type="time" class="form-control" id="horaf" value="<?php echo $detRes['horaf'] ?>" placeholder="Email">
              </div>
            </fieldset>
          </div>
          <div class="col-sm-7">
            <fieldset class="well form-horizontal">
              <div class="form-group">
                <label for="horaf" class="col-sm-3 control-label">Tipo Visita</label>
                <div class="col-sm-9">
                  <?php genSelect('typ_cod', detRowGSel('db_types', 'typ_cod', 'typ_val', 'typ_ref', 'TIPVIS'), $detRes['typ_cod'], ' form-control '); ?>
                </div>
              </div>
              <div class="form-group">
                <label for="horaf" class="col-sm-5 control-label">Observaciones</label>
                <div class="col-sm-7">
                  <textarea name="obs" id="obs" class="form-control" rows="4"><?php echo $detRes['obs'] ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="horaf" class="col-sm-3 control-label">Estado</label>
                <div class="col-sm-9">
                  <table width="200">
                    <tr>
                      <td><label>
                          <input type="radio" name="est" value="1" id="est_0" <?php if ($detRes['est'] == '1') echo ' checked ' ?>>
                          Pendiente</label></td>
                    </tr>
                    <tr>
                      <td><label>
                          <input type="radio" name="est" value="2" id="est_1" <?php if ($detRes['est'] == '2') echo ' checked ' ?>>
                          Atendido</label></td>
                    </tr>
                    <tr>
                      <td><label>
                          <input type="radio" name="est" value="0" id="est_2" <?php if ($detRes['est'] == '0') echo " checked " ?>>
                          Eliminar</label></td>
                    </tr>
                  </table>
                </div>
              </div>

            </fieldset>
          </div>
        </div>
      </form>
    </div>
    <div class="col-sm-5">
      <?php if ($tr_RSlr > 0) { ?>
        <div class="panel panel-info">
          <div class="panel-heading">Historial Reservas del Paciente</div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Obs</th>
                <th>Estado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php do { ?>
                <?php
                $btnAcc = NULL;
                $valEst = NULL;
                $detTyp = detRow('db_types', 'typ_cod', $row_RSlr['typ_cod']);
                $detTyp_val = $detTyp['typ_val'];
                $estado = $row_RSlr['est'];
                if ($estado == 0) {
                  $valEst = '<span class="label label-danger">Anulado</span>';
                } else if ($estado == 1) {
                  $valEst = '<span class="label label-default">Pendiente</span>';
                  $btnAcc = '<a href="reserva_form.php?idp=' . $row_RSlr['pac_cod'] . '&id=' . $row_RSlr['id'] . '" class="btn btn-info btn-xs">
						<i class="fa fa-edit"></i></a>';
                  $btnAcc .= '<a href="actions.php?id=' . $row_RSlr['id'] . '&acc=' . md5('DELEL') . '" class="btn btn-danger btn-xs">
						<i class="fa-solid fa-trash"></i></a>';
                } else if ($estado == 2) {
                  $valEst = '<span class="label label-success">Atendido</span>';
                } else {
                  $valEst = '<span class="label label-warning">Error</span>';
                }
                ?>
                <tr>
                  <td><?php echo $row_RSlr['id'] ?></td>
                  <td><?php echo $row_RSlr['fechai'] ?></td>
                  <td><?php echo $row_RSlr['horai'] ?></td>
                  <td><?php echo $detTyp_val ?></td>
                  <td><?php echo $row_RSlr['obs'] ?></td>
                  <td><?php echo $valEst ?></td>
                  <td><?php echo $btnAcc ?></td>
                </tr>
              <?php } while ($row_RSlr = mysqli_fetch_assoc($RSlr)); ?>
            </tbody>
          </table>
          <div class="panel-footer">Registros. <?php echo $tr_RSlr ?></div>
        </div>
      <?php } else { ?>
        <div class="alert alert-warning">
          <h4>Sin Historial de Reservas</h4>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php include(root['f'] . 'footer.php'); ?>