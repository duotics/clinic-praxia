<?php
$mCir = new \App\Models\Cirugia;
$lCir = $mCir->getAllCirCon($idc, $idp);
?>
<div class="panel panel-primary">
  <div class="panel-heading">
    <i class="fa fa-medkit fa-lg"></i> CIRUGIAS
    <a href="<?php echo route['c'] ?>com_cirugia/cirugiaForm.php?idp=<?php echo $idp ?>&idc=<?php echo $idc ?>" class="btn btn-default btn-xs fancybox fancybox.iframe fancyreload"> NUEVO <i class="fa fa-plus-circle fa-lg"></i> </a>
  </div>
  <div class="panel-body">

    <?php if ($lCir) {
      $lCirCont = count($lCir);
      $classlast = TRUE;
      $classtr;
    ?>
      <div>
        <table class="table table-striped table-bordered table-condensed">
          <thead>
            <tr>
              <th>ID</th>
              <th>Diagnostico</th>
              <th colspan="2">Cirugia Realizada</th>
              <th>Protocolo</th>
              <th>Evolucion</th>
              <th>Multimedia</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($lCir as $dRSc) { ?>
              <?php
              $idRowCir = md5($dRSc['id_cir']);
              $accBtn = md5("DELc");
              $btnDel = "<a href='{$RAIZc}com_cirugia/actions.php?idr={$idRowCir}&acc={$accBtn}&url={$urlc}' class='btn btn-danger btn-xs fancybox fancybox.iframe fancyclose'>{$cfg['b']['del']}</a>";
              $btnEdit = "<a href='{$RAIZc}com_cirugia/cirugiaForm.php?idr={$idRowCir}' class='btn btn-primary btn-xs fancybox fancybox.iframe fancyreload'>{$cfg['b']['edit']}</a>";
              $typexam = fnc_datatyp($dRSc['typ_cod'] ?? null);
              $typexam = $typexam['typ_val'] ?? null;
              if ($classlast == TRUE) {
                $classlast = FALSE;
                $classtr = 'class="warning"';
              } else {
                $classtr = '';
              } ?>
              <tr <?php echo $classtr ?>>
                <td><?php echo $dRSc['id_cir'] ?></td>
                <td><?php echo $dRSc['diagnostico'] ?></td>
                <td><?php if ($dRSc['fechar']) { ?><abbr title="<?php echo $dRSc['fechar'] ?>"><i class="fa fa-calendar"></i></abbr><?php } ?></td>
                <td><?php echo $dRSc['cirugiar'] ?></td>
                <td>
                  <div class="readmore"><?php echo $dRSc['protocolo'] ?></div>
                </td>
                <td><?php echo $dRSc['evolucion'] ?></td>
                <td><?php echo totRowsTab('db_cirugias_media', 'id_cir', $dRSc['id_cir']) ?></td>
                <td>
                  <div class="btn-group">
                    <?php echo $btnEdit . $btnDel ?>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>'; ?>

  </div>
  <div class="panel-footer">Resultados. <?php echo $lCirCont ?? 0 ?></div>
</div>