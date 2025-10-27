<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/visitas/show.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Datos de la Visita</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Visita</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- Apartado para Solicitante -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Solicitante:</label>
                                                            <div style="display: flex">
                                                                <input type="text" class="form-control" value="<?php echo $nombres_sesion; ?>" disabled>
                                                                <input type="text" name="nombre_usuario" value="<?php echo $id_usuario_sesion; ?>" hidden>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Apartado para Área -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Área:</label>
                                                            <input type="text" class="form-control" value="<?php echo $nombre_area; ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Delegado -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Delegado:</label>
                                                            <input type="text" class="form-control" value="<?php echo $nombre_delegado; ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Motivo -->
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="">Motivo:</label>
                                                            <input type="text" class="form-control" value="<?php echo $motivo; ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Estado (oculto) -->
                                                    <div class="col-md-2" >
                                                        <div class="form-group">
                                                            <label for="">Estado:</label>
                                                            <input type="text" name="estado" value="<?php echo $estado; ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <!-- Apartado para Descripción -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Descripción Vehículo (Si Aplica):</label>
                                                            <textarea name="comentario_admin" cols="30" rows="5" class="form-control" disabled><?php echo $comentario_admin; ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <!-- Apartado para Fecha -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Fecha de Visita:</label>
                                                    <input type="text" class="form-control" value="<?php echo $fecha_hora; ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-danger">Volver</a>
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