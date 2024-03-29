<?php

use App\Core\genInterfaceMenu;

$objMenuMain = new genInterfaceMenu("MAINMENU", "nav navbar-nav");
$objMenuConf = new genInterfaceMenu("CONFIGUSER", "NULL", FALSE);
$objMenuUser = new genInterfaceMenu("USERMENU", "navbar-nav d-flex");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo route['c'] ?>"><?php echo $_ENV['APP_NAME'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenuMain" aria-controls="navMenuMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenuMain">
      <?php $objMenuMain->render() ?>
      <ul class="navbar-nav me-auto">

        <?php $objMenuConf->render() ?>
        <li class="nav-item">
          <a class="nav-link">
            <div id="logF"></div>
          </a>
        </li>
      </ul>
      <?php $objMenuUser->render() ?>
    </div>
  </div>
</nav>