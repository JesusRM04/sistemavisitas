<!--Hola Mundo-->
<?php
include('./app/config.php');
include ('layout/sesion.php');

include('./layout/parte1.php'); //Llamamos a la parte 1 la cual contiene el navbar y el menú lateral izquierdo

//include ('app/controllers/usuarios/listado_de_usuarios.php');
include ('app/controllers/roles/listado_de_roles.php');
//include ('app/controllers/categorias/listado_de_categoria.php');
//include ('app/controllers/almacen/listado_de_productos.php');
//include ('app/controllers/proveedores/listado_de_proveedores.php');
//include ('app/controllers/compras/listado_de_compras.php');
//include ('app/controllers/ventas/listado_de_ventas.php');
//include ('app/controllers/clientes/listado_de_clientes.php');
?>
<!-- Contenedor Principal (contiene el contenido de la página) -->
<div class="content-wrapper">
  <!-- Encabezado -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4 class="m-0"><?php echo $rol_sesion; ?></h4>
        </div>
        <!-- Fin Primer Columna -->
        
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
              <?php
              $contador_de_roles = 0;
              foreach ($roles_datos as $roles_dato) {
                $contador_de_roles = $contador_de_roles + 1;
              }
              ?>
              <h3><?php echo $contador_de_roles;?></h3>
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
<?php include('./layout/parte2.php'); ?>