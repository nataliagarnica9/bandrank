<?php
include_once('config.php');
if (isset($_SESSION["ROL"]) && $_SESSION["ROL"] == 'admin') {
    $usuario = "Administrador";
    $url_inicio = base_url . "pages/administrador/inicio.php";
} elseif (isset($_SESSION["ROL"]) && ($_SESSION["ROL"] == 'jurado' || $_SESSION["ROL"] == 'instructor')) {
    $url_inicio = base_url . "pages/participantes/inicio.php";
    $usuario = $_SESSION["NOMBRE_USUARIO"];
} else {
    $url_inicio = base_url . "inicio.php";
    $usuario = '';
    $boton_home = '';
}
?>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
            </li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                            class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-header">
                    Histories
                </div>
                <div class="search-item">
                    <a href="#">How to hack NASA using CSS</a>
                    <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                                     class="nav-link nav-link-lg message-toggle beep"><i
                        class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Messages
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="<?= base_url ?>dist/images/avatar/avatar-1.png" class="rounded-circle">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Vacío</b>
                            <p>No hay mensajes</p>
                            <div class="time">0</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                                     class="nav-link notification-toggle nav-link-lg"><i
                        class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Template update is available now!
                            <div class="time text-primary">2 Min Ago</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?= base_url ?>dist/images/avatar/avatar-1.png" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hola, <?= $usuario ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Ten un lindo día</div>
                <a href="#" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Perfil
                </a>
                <a href="#" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Cambiar clave
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url ?>autenticacion.php?tipo=logout" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?=$url_inicio?>"><img src="<?= base_url ?>dist/images/bandrank_logotipo.png" alt="Logo de la marca"
                                      width="150"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?=$url_inicio?>">BR</a>
        </div>
        <ul class="sidebar-menu">
            <?php if ($_SESSION["ROL"] == 'admin') : ?>
                <li class="menu-header">CONCURSO</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-drum"></i>
                        <span>Administrar</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link"
                               href="<?= base_url ?>pages/administrador/concurso/concursos.php">Concursos</a>
                        </li>
                        <li><a class="nav-link"
                               href="<?= base_url ?>pages/administrador/bandas/bandas.php">Bandas</a></li>
                        <li><a class="nav-link"
                               href="<?= base_url ?>pages/administrador/categoria/categorias.php">Categorías</a>
                        </li>
                    </ul>
                </li>

                <li class="menu-header">JURADOS</li>
                <li><a class="nav-link" href="<?= base_url ?>pages/administrador/jurados/jurados.php"><i class="fas fa-user-tie"></i> <span>Jurados</span></a>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["ROL"] != 'admin') : ?>
                <li class="menu-header">Inicio</li>
                <li><a class="nav-link" href="<?= base_url ?>pages/participantes/inicio.php"><i class="fas fa-map-marker"></i><span>Página principal</span></a>
                </li>
            <?php endif; ?>

            <li class="menu-header">TIEMPO REAL</li>
            <li><a class="nav-link" href="<?= base_url ?>pages/puntuaciones/puntuaciones.php"><i class="far fa-clock"></i><span>Ver puntuaciones</span></a>
            </li>
            <li><a class="nav-link" href="<?= base_url ?>pages/puntuaciones/resultados.php"><i class="fas fa-chart-bar"></i><span>Ver podio</span></a>
            </li>

            <?php if ($_SESSION["ROL"] == 'admin') : ?>
                <li class="menu-header">CALIFICACIONES</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="far fa-bookmark"></i> <span>Administrar</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link"
                               href="<?= base_url ?>pages/administrador/criteriosEvaluacion/criterios.php">Calificaciones</a>
                        </li>
                        <li><a class="nav-link"
                               href="<?= base_url ?>pages/administrador/penalizacion/penalizacion.php">Penalización</a>
                        </li>
                        <li><a class="nav-link" href="<?= base_url ?>pages/administrador/planilla/planillas.php">Planillas</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="menu-header">CONFIGURACIÓN</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Usuario</span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Perfil</a></li>
                    <li><a href="<?= base_url ?>pages/participantes/cambiarClave.php">Cambiar contraseña</a></li>
                </ul>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <!--<a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>-->
        </div>
    </aside>
</div>