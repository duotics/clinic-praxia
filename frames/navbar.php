<nav class="navbar navbar-expand-lg navbar-dark bg-primary pt-1 pb-1">
    <div class="container-fluid">
        <a class="navbar-brand wow animate__ animate__fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;">Rendición Cuentas
            <span class="badge bg-light"><?php echo $dU['emp'] ?? null ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeadUser" aria-controls="navbarHeadUser">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarHeadUser">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 wow animate__ animate__fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo routeM ?>main/"><i class="fa-solid fa-house"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-gear"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-users fa-fw fa-lg"></i> Usuarios</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user fa-fw fa-lg"></i> Empresas</a></li>
                        <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user fa-fw fa-lg"></i> Direcciones</a></li>
                        <li><a class="dropdown-item" href="#">
                                <i class="fa-solid fa-user fa-fw fa-lg"></i> Secretarias</a></li>
                        <li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-solid fa-user fa-fw fa-lg"></i> <?php echo $dU['user'] ?? null ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Cambiar contraseña</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo routeM . "salir/" ?>">
                                <i class="fa-solid fa-right-from-bracket fa-fw fa-lg"></i> Salir
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>