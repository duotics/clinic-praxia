<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainMenu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $RAIZc ?>com_index/"><?php echo $_ENV['APP_CLI'] ?></a>
    </div>
    <div class="collapse navbar-collapse" id="mainMenu">
      <?php echo genMenu('MAINMENU', 'nav navbar-nav') ?>
      <ul class="nav navbar-nav navbar-right">
        <li><a>
            <div id="logF"></div>
          </a></li>
        <li><a href="#">
            <div id="loading"><img src="<?php echo $RAIZa ?>images/struct/loader.gif" /></div>
          </a></li>
        <?php echo genMenu('CONFIGUSER', 'NULL', FALSE) ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $dU['USER'] ?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $RAIZc ?>com_usersystem/user_perfil.php">Informacion Usuario</a></li>
            <li><a href="<?php echo $RAIZc ?>com_usersystem/changePass.php" class="fancybox fancybox.iframe fancyreload">Cambiar Contraseña</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $RAIZ ?>logout.php">Salir</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>