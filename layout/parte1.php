<!--En este layout se despliega la parte del encabezado:
    * Navbar
    * Menú Lateral Izquierdo

    ****Estilos Botones y Cards****
    * Color Dorado #b89457
    * Color Guinda #611232 
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inicio</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />

  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" />

  <!-- Libreria Sweetallert2-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- navbar links parte izquierda -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contacto</a>
        </li>
      </ul>

      <!-- navbar links parte derecha -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Buscador -->
        <li class="nav-item">
          <a
            class="nav-link"
            data-widget="navbar-search"
            href="#"
            role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input
                  class="form-control form-control-navbar"
                  type="search"
                  placeholder="Buscar"
                  aria-label="Search" />
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button
                    class="btn btn-navbar"
                    type="button"
                    data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <!-- Mensajes Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img
                  src=""
                  alt="User Avatar"
                  class="img-size-50 mr-3 img-circle" />
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted">
                    <i class="far fa-clock mr-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img
                  src=""
                  alt="User Avatar"
                  class="img-size-50 img-circle mr-3" />
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted">
                    <i class="far fa-clock mr-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img
                  src=""
                  alt="User Avatar"
                  class="img-size-50 img-circle mr-3" />
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted">
                    <i class="far fa-clock mr-1"></i> 4 Hours Ago
                  </p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Marcar mensajes como leídos</a>
          </div>
        </li>
        <!-- Notificaciones Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">N</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">N Notificaciones</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 Nuevos Mensajes
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 Solicitudes
              <span class="float-right text-muted text-sm">12 horas</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 Nuevos Reportes
              <span class="float-right text-muted text-sm">2 días</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">Ver todas las notifications</a>
          </div>
        </li>
        <!-- Pantalla Completa -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- Fin Navbar -->

    <!-- Menú Lateral Principal (izquierdo) Contenido (Apartados) -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Logo -->
      <a
        href="<?php echo $URL; ?>"
        class="brand-link">
        <img
          src="<?php echo $URL; ?>/public/images/infoteclogo.png"
          alt="Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8" />
        <span class="brand-text font-weight-light"><b>INFOTEC</b></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Panel de Usuario (opcional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img
              src="<?php echo $URL; ?>/public/images/user.png"
              class="img-circle elevation-2"
              alt="User Image" />
          </div>
          <div class="info">
            <a href="#" class="d-block"><b style="font-size: 12px;"><?php echo $nombres_sesion; ?></b></a>
          </div>
        </div>

        <!-- Buscador -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input
              class="form-control form-control-sidebar"
              type="search"
              placeholder="Search"
              aria-label="Search" />
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false">
            <!-- Apartado Usuarios -->
            <?php if ($rol_sesion == 'ADMINISTRADOR') { ?>
              <li class="nav-item">
                <a href="#" class="nav-link active" style="background-color: #611232;">
                  <i class="nav-icon fas fa-users" style="color: white"></i>
                  <p style="color: white">
                    Usuarios
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/usuarios" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de Usuarios</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/usuarios/create.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Creación de Usuarios</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

            <!-- Apartado Roles -->
            <?php if ($rol_sesion == 'ADMINISTRADOR') { ?>
              <li class="nav-item">
                <a href="#" class="nav-link active " style="background-color: #b89457;">
                  <i class="nav-icon fas fa-address-card"></i>
                  <p>
                    Roles
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/roles" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de Roles</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/roles/create.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Creación de Roles</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

            <!-- Apartado Áreas -->
            <?php if ($rol_sesion == 'ADMINISTRADOR') { ?>
              <li class="nav-item">
                <a href="#" class="nav-link active" style="background-color: #611232;">
                  <i class="nav-icon fas fa-map"></i>
                  <p>
                    Áreas
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/areas/index.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de Áreas</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

            <!-- Apartado Visitas -->
            <li class="nav-item">
              <a href="#" class="nav-link active" style="background-color: #b89457;">
                <i class="nav-icon fas fa-address-book"></i>
                <p>
                  Visitas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listado de Visitas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Creación de Visita</p>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Apartado Delegados -->
            <?php if ($rol_sesion == 'ADMINISTRADOR') { ?>
              <li class="nav-item">
                <a href="#" class="nav-link active" style="background-color: #611232;">
                  <i class="nav-icon fas fa-user-tie"></i>
                  <p>
                    Delegados
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/delegados" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de Delegados</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo $URL; ?>/delegados/create.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Creación de Delegados</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>

            <!-- Cerrar Sesión -->
            <li class="nav-item">
              <a href="<?php echo $URL; ?>/app/controllers/login/cerrar_sesion.php"
                class="nav-link"
                style="background-color: <?php echo ($rol_sesion == 'ADMINISTRADOR') ? '#b89457' : '#611232'; ?>;">
                <i class="nav-icon fas fa-door-closed" style="color: white;"></i>
                <p style="color: white;">
                  Cerrar Sesión
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- Fin Sidebar Menu -->
      </div>
      <!-- Fin Sidebar -->
    </aside>
    <!-- Fin Menú Lateral Principal -->