<?php

use App\Models\Componente;

$mCom = new Componente;
$lCom = $mCom->getAll();
?>
<div class="container">

  <div class="btn-group pull-right">
    <a href="form.php" class="btn btn-primary fancybox.iframe fancyreload"><span class="fa fa-plus"></span> Nuevo</a>
  </div>
  <?php echo genHeader($dM) ?>
  <?php sLOG('g');
  if ($lCom) { ?>

    <table class="table table-hover table-condensed table-bordered datatable">
      <thead>
        <tr>
          <th></th>
          <th>Ref</th>
          <th>Name</th>
          <th>Description</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lCom as $dRSc) {
          $idRow = $dRSc['mod_cod'];
          $idSRow = md5($idRow);
          $btnStat = fncStat('fncts.php', array("ids" => $idSRow, "val" => $dRSc['mod_stat'], "acc" => 'STATUS', "url" => $urlc));
        ?>
          <tr>
            <td class="text-center"><?php echo $btnStat ?></td>
            <td><?php echo $dRSc['mod_ref'] ?></td>
            <td><a href="form.php?ids=<?php echo $idSRow ?>" class="fancybox.iframe fancyreload"><?php echo $dRSc['mod_nom'] ?></a></td>
            <td><?php echo $dRSc['mod_des'] ?></td>
            <td>
              <div class="btn-group">
                <a href="form.php?ids=<?php echo $idSRow ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
                  <span class="fa fa-edit"></span> Edit</a>
                <a href="fncts.php?ids=<?php echo $idSRow ?>&acc=<?php echo md5("DEL") ?>&url=<?php echo $urlc ?>" class="btn btn-danger btn-xs">
                  <span class="fa fa-trash"></span> Del</a>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else { ?>
    <div class="alert alert-warning">
      <h4><?php echo cfg['t']['list-null'] ?></h4>
    </div>
  <?php } ?>
</div>