<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Iniciar Sesión</title>

    <!-- Google Font: Source Sans Pro -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />

    <!-- Theme style -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"
    />

    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />

    <!-- icheck bootstrap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css"
    />

    <!-- Libreria Sweetallert2-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <!-- /.login-logo -->

      <?php
    session_start();
    if(isset($_SESSION['mensaje'])){
        $respuesta = $_SESSION['mensaje']; ?>
      <script>
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "<?php echo $respuesta;?>",
          showConfirmButton: false,
          timer: 1500,
        });
      </script>
      <?php
    }
    ?>

      <center>
        <img
          src="../public/images/infoteclogo.png"
          alt=""
          width="150px"
          height="160px"
        />
      </center>
      <br />
      <div class="card card-outline card-secondary">
        <div class="card-header text-center">
          <a class="login-box-msg" style="color: black"
            ><b>Aguascalientes</b></a
          >
        </div>
        <div class="card-body">
          <p class="login-box-msg" style="color: black">Ingrese sus Datos</p>

          <form action="../app/controllers/login/ingreso.php" method="post">
            <div class="input-group mb-3">
              <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Email"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                name="password_user"
                class="form-control"
                placeholder="Password"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <hr />
            <div class="row">
              <!-- /.col -->
              <div class="col-12">
                <button type="submit" class="btn btn-secondary btn-block">
                  Ingresar
                </button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  </body>
</html>
