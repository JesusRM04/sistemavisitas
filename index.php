<!--Hola Mundo-->
<?php
include('./layout/parte1.php') //Llamamos a la parte 1 la cual contiene el navbar y el menú lateral izquierdo

?>
<!-- Contenedor Principal (contiene el contenido de la página) -->
<div class="content-wrapper">
  <!-- Encabezado -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Información del Sistema</h1>
        </div>
        <!-- Fin Primer Columna -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Página Principal</li>
          </ol>
        </div>
        <!-- Fin Segunda Columna -->
      </div>
      <!-- Fin Primera Fila -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- Fin Encabezado -->

  <!-- Contenido Principal -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <!-- Tarjeta Usuarios -->
        <div class="col-lg-3 col-6">
          <div class="small-box" style="background-color: #611232;">
            <div class="inner" style="color: white">
              <h3>N</h3>
              <p style="color: white">Usuarios Registrados</p>
            </div>
            <a href="./usuarios">
              <div class="icon">
                <i class="fas fa-users" style="color: white;"></i>
              </div>
            </a>
            <a href="./usuarios" class="small-box-footer" style="color: white">
              Más detalle
              <i
                class="fas fa-arrow-circle-right"
                style="color: white"></i>
            </a>
          </div>
        </div>

        <!-- Tarjeta Roles -->
        <div class="col-lg-3 col-6">
          <div class="small-box" style="background-color: #b89457; color: white">
            <div class="inner">
              <h3>N</h3>
              <p>Roles Registrados</p>
            </div>
            <a href="./roles">
              <div class="icon">
                <i class="fas fa-address-card" style="color: white"></i>
              </div>
            </a>
            <a href="./roles" class="small-box-footer">
              Más detalle <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Tarjeta Áreas -->
        <div class="col-lg-3 col-6">
          <div class="small-box" style="background-color: #611232; color: white">
            <div class="inner">
              <h3>N</h3>
              <p>Áreas Registradas</p>
            </div>
            <a href="./areas/index.php">
              <div class="icon">
                <i class="fas fa-map" style="color: white;"></i>
              </div>
            </a>
            <a href="./areas/index.php" class="small-box-footer">
              Más detalle <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Tarjeta Visitas -->
        <div class="col-lg-3 col-6">
          <div class="small-box" style="background-color: #b89457; color: white">
            <div class="inner">
              <h3>N</h3>
              <p>Visitas Registradas</p>
            </div>
            <a href="">
              <div class="icon">
                <i class="fas fa-address-book" style="color: white;"></i>
              </div>
            </a>
            <a href="#" class="small-box-footer">
              Más detalle <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- Fin Contenido Principal -->
</div>
<!-- Fin Contenedor Principal -->

<!-- Control Sidebar Derecho -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control Sidebar Contenido -->
  <div class="p-3">
    <h5>Configuración</h5>
    <p>Contenido</p>
  </div>
</aside>
<!-- Fin Control Sidebar Derecho -->

<!--Mandamos a llamar a parte2.php que contiene el footer-->
<?php include ('./layout/parte2.php'); ?>