<?php
$param['idmc']['v'] = $_GET['idmc'] ?? $_POST['idmc'] ?? null;
$TR = totRowsTab('tbl_menus_items', '1', '1');
if ($TR > 0) {
  $pages = new Paginator;
  $pages->items_total = $TR;
  $pages->mid_range = 8;
  $pages->paginate();
  if ($param['idmc']['v']) $param['idmc']['q'] = 'AND men_idc=' . $param['idmc']['v'];
  $query_RSd = sprintf(
    'SELECT * FROM  tbl_menus_items WHERE 1=1 %s ORDER BY men_padre ASC, men_id ASC, men_orden ASC ' . $pages->limit,
    SSQL($param['idmc']['q'] ?? null, '')
  );
  $RSd = mysqli_query(conn, $query_RSd) or die(mysqli_error(conn));
  $dRSd = mysqli_fetch_assoc($RSd);
  $totalRows_RSd = mysqli_num_rows($RSd);
}
$btnCont = '<a href="index.php" class="btn btn-default"><span class="fa fa-eye"></span> Gestionar Contenedores</a>';
$btnNew = '<a href="formItems.php" class="btn btn-primary fancybox.iframe fancyreload"><span class="fa fa-plus fa-lg"></span> Nuevo</a>';

?>
<div class="container">
  <?php echo genHeader($dM, 'page-header', null, $btnCont . $btnNew) ?>

  <?php sLOG('g'); ?>
  <div class="well well-sm">
    <form class="form-inline">
      <span class="label label-default">Filtros</span>
      <div class="form-group">
        <label for="exampleInputName2">Menu Contenedor</label>
        <?php genSelect('idmc', detRowGSel('tbl_menus', 'id', 'nom', 'stat', '1'), $param['idmc'], 'form-control input-sm'); ?>
      </div>
      <button type="submit" class="btn btn-default btn-xs">Consultar</button>
    </form>
  </div>
  <?php if ($totalRows_RSd > 0) { ?>
    <div class="table-responsive">
      <table class="table table-hover table-condensed table-bordered" id="itm_table">
        <thead>
          <tr>
            <th>ID</th>
            <th></th>
            <th>MENU</th>
            <th>Padre</th>
            <th>Nombre</th>
            <th>Link</th>
            <th>Titulo</th>
            <th>Icon</th>
            <th>Orden</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php do {
            $det_id = $dRSd['men_id'];
            $detMC = detRow('tbl_menus', 'id', $dRSd['men_idc']);
            //if($det_parent_id==0) $css_tr='info'; else unset($css_tr);
            $detMP = detRow('tbl_menus_items', 'men_id', $dRSd['men_padre']);
            $btnStat = fncStat('fncts.php', array("id" => $det_id, "val" => $dRSd['men_stat'], "acc" => md5('STmi'), "url" => $_SESSION['urlc']));
          ?>
            <tr class="<?php echo $css_tr ?>">
              <td><?php echo $det_id ?></td>
              <td><?php echo $btnStat ?></td>
              <td><span class="label label-info"><?php echo $detMC['nom'] ?></span></td>
              <td><?php echo $detMP['men_nombre'] ?? null ?></td>
              <td><?php echo $dRSd['men_nombre'] ?></td>
              <td><?php echo $dRSd['men_link'] ?></td>
              <td><?php echo $dRSd['men_tit'] ?></td>
              <td><i class="<?php echo $dRSd['men_icon'] ?>"></i></td>
              <td><?php echo $dRSd['men_orden'] ?></td>
              <td>
                <div class="btn-group">
                  <a href="formItems.php?id=<?php echo $det_id ?>" class="btn btn-primary btn-xs fancybox.iframe fancyreload">
                    <i class="fa fa-edit"></i> Edit</a>
                  <a href="fncts.php?id=<?php echo $det_id ?>&acc=DELMI" class="btn btn-danger btn-xs fancybox.iframe fancyreload">
                    <i class="fa fa-trash"></i> Del</a>
                </div>
              </td>
            </tr>
          <?php } while ($dRSd = mysqli_fetch_assoc($RSd)); ?>
        </tbody>
      </table>
    </div>
    <div class="well well-sm">
      <div class="row">
        <div class="col-md-2"><span class="label label-default"><strong><?php echo $TR ?></strong> Resultados</span></div>
        <div class="col-md-6">
          <ul class="pagination cero"><?php echo $pages->display_pages(); ?></ul>
        </div>
        <div class="col-md-4"><?php echo '<div>' . $pages->display_items_per_page() . "</div>"; ?></div>
      </div>
    </div>
  <?php } else {
    echo '<div class="alert alert-warning"><h4>Not Found Items !</h4></div>';
  } ?>
</div>

</html>