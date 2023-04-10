<?php

use App\Core\genInterfaceMenu;

$objMenuMain = new genInterfaceMenu("MAINMENU", "nav navbar-nav");
$objMenuConf = new genInterfaceMenu("CONFIGUSER", "NULL", FALSE);
$objMenuUser = new genInterfaceMenu("USERMENU", "NULL", "navbar-nav d-flex");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo route['c'] ?>"><?php echo $_ENV['APP_NAME'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php $objMenuMain->render() ?>
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link">
            <div id="logF"></div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div id="loading"><img src="<?php echo route['i'] ?>struct/loader.gif" /></div>
          </a>
        </li>
        <?php $objMenuConf->render() ?>
      </ul>
      <?php $objMenuUser->render() ?>
    </div>
  </div>
</nav>