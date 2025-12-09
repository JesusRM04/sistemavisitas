<?php
include('../app/config.php');
include('../layout/sesion.php');


// 🔒 PROTEGER PÁGINA
protegerPagina('delegados', 'editar');  // o 'ver', 'editar', 'eliminar' según corresponda

include('../layout/parte1.php');

include('../app/controllers/delegados/update_delegado.php');


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualizar Datos del Delegado</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">INGRESE LOS NUEVOS DATOS DEL DELEGADO</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="../app/controllers/delegados/update.php" method="post">
                                        <input type="text" name="id_delegado" value="<?php echo $id_delegado_get; ?>" hidden>
                                        <!--Apartado Nombres del Delegado-->
                                        <div class="form-group">
                                            <label for="">Nombre</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="nombre" class="form-control" value="<?php echo $nombres; ?>" required>
                                            </div>
                                        </div>
                                        <!--Apartado Correo de Delegado-->
                                        <div class="form-group">
                                            <label for="">Correo</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="email" name="correo" class="form-control" value="<?php echo $email; ?>" required>
                                            </div>
                                        </div>
                                        <!--Apartado Extension de Telefono-->
                                        <div class="form-group">
                                            <label for="">Extension de Tel.</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="number" name="extension" class="form-control" value="<?php echo $ext; ?>" required>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-danger">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>