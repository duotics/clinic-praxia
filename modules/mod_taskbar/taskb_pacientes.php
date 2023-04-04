<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav_taskb">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">PACIENTES</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="nav_taskb">
      <a href="<?php echo $RAIZc ?>com_pacientes/form.php" class="btn btn-primary navbar-btn"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Paciente</a>
      
      <a href="?sBr=+" class="btn btn-primary navbar-btn navbar-right">Total Pacientes <span class="badge"><?php echo fnc_totpac();?></span></a>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>