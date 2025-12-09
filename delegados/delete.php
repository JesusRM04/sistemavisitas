<?php
include('../app/config.php');
include('../layout/sesion.php');


// 🔒 PROTEGER PÁGINA
protegerPagina('delegados', 'eliminar');  // o 'ver', 'editar', 'eliminar' según corresponda

include('../layout/parte1.php');

include('../app/controllers/delegados/show_delegado.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Eliminar Delegado</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">¿Está Seguro de Eliminar al Delegado?</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/delegados/delete_delegado.php" method="post">
                                        <input type="text" name="id_delegado" value="<?php echo $id_delegado_get; ?>" hidden>
                                        <div class="form-group">
                                            <!--Apartado Nombres de Delegado-->
                                            <label for="">Nombre</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <input type="text" name="nombres" class="form-control" value="<?php echo $nombres; ?>" disabled>
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
                                                <input type="email" name="correo" class="form-control" value="<?php echo $email; ?>" disabled>
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
                                                <input type="number" name="extension" class="form-control" value="<?php echo $ext; ?>" disabled>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Volver</a>
                                            <button class="btn btn-danger">Eliminar</button>
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