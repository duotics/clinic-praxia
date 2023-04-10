<?php $contVis = $db->totRowsTab("db_consultas", "pac_cod", $idsPac) ?? null; ?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" data-id="<?php echo $idsPac ?>">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Historial de visitas <span class="badge bg-primary badge-pill"><?php echo $contVis ?></span></h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div id="fraHistCont"></div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $canvaLC = $('#offcanvasExample');
    $canvaLC.on('shown.bs.offcanvas', () => {
      var idp = $canvaLC.attr("data-id");
      $("#fraHistCont").load("_formCentHisList.php", {
        kp: idp
      });
    })
  });
</script>