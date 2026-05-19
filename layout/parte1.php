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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" />

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css" />

  <!-- Libreria Sweetallert2-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <!-- izquierda -->
      <ul class="navbar-nav">
          <li class="nav-item">
              <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                  <i class="fas fa-bars"></i>
              </a>
          </li>

          <li class="nav-item d-none d-sm-inline-block">
              <a href="#" class="nav-link">Inicio</a>
          </li>
      </ul>

      <!-- derecha -->
      <ul class="navbar-nav ml-auto">

          <!-- Pantalla completa -->
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <?php
                // Obtener módulos según permisos del usuario
                $menu_items = $permisos->getMenuItems();
                $color_toggle = true; // Alternar colores
                
                foreach ($menu_items as $item):
                    $color = $color_toggle ? '#611232' : '#b89457';
                    $color_toggle = !$color_toggle;
                    
                    $puede_crear = $item['puede_crear'];
                    $nombre_modulo = $item['nombre_modulo'];
                    
                    // 🔥 EXCLUIR ÁREAS Y REPORTES DE TENER SUBMENÚ "CREAR"
                    $mostrar_crear = $puede_crear && 
                                    !in_array($nombre_modulo, ['areas', 'reportes']);
                ?>
                
                <li class="nav-item">
                    <a href="#" class="nav-link active" style="background-color: <?php echo $color; ?>;">
                        <i class="nav-icon <?php echo $item['icono']; ?>" style="color: white"></i>
                        <p style="color: white">
                            <?php echo ucfirst($nombre_modulo); ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- ENLACE PRINCIPAL: Listado -->
                        <li class="nav-item">
                            <a href="<?php echo $URL . $item['ruta']; ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    <?php 
                                    // Nombres personalizados según módulo
                                    if ($nombre_modulo == 'visitas') {
                                        echo 'Visitas Pendientes';
                                    } elseif ($nombre_modulo == 'reportes') {
                                        echo 'Reportes de Visitas';
                                    } else {
                                        echo 'Listado de ' . ucfirst($nombre_modulo);
                                    }
                                    ?>
                                </p>
                            </a>
                        </li>
                        
                        <!-- 🆕 VISITAS APROBADAS (solo si es módulo de visitas) -->
                        <?php if ($nombre_modulo == 'visitas'): ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/visitas/aprobadas.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Visitas Aprobadas</p>
                            </a>
                        </li>
                        <?php endif; ?>

                        <!-- 🆕 VISITAS APROBADAS (solo si es módulo de visitas) -->
                        <?php if ($nombre_modulo == 'visitas'): ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL; ?>/visitas/vencidas.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Visitas vencidas</p>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <!-- ENLACE CREAR (solo si tiene permiso Y no es áreas ni reportes) -->
                        <?php if ($mostrar_crear): ?>
                        <li class="nav-item">
                            <a href="<?php echo $URL . $item['ruta']; ?>/create.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Crear <?php echo ucfirst($nombre_modulo); ?></p>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                
                <?php endforeach; ?>
                <?php
                $color_cerrar = $color_toggle ? '#611232' : '#b89457';
                ?>
                <!-- Cerrar Sesión -->
                <li class="nav-item">
                    <a href="<?php echo $URL; ?>/app/controllers/login/cerrar_sesion.php" class="nav-link" style="background-color:<?php echo $color_cerrar; ?>;">
                        <i class="nav-icon fas fa-door-closed" style="color: white;"></i>
                        <p style="color: white;">Cerrar Sesión</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Fin Sidebar Menu -->
      </div>
      <!-- Fin Sidebar -->
    </aside>
    <!-- Fin Menú Lateral Principal -->