<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/visitas/listado_de_visitas.php');
include('../app/controllers/usuarios/listado_de_usuarios.php');
include('../app/controllers/areas/listado_de_areas.php');
include('../app/controllers/delegados/listado_de_delegados.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de Visita</h1>
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
                            <h3 class="card-title">Llene los Datos con Cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="../app/controllers/visitas/create.php" method="post" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-md-9">
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
                                                            <div style="display: flex">
                                                                <select name="nombre_area" id="" class="form-control" required>
                                                                    <option value="" disabled selected>Seleccionar…</option>
                                                                    <?php
                                                                    foreach ($areas_datos as $areas_dato) { ?>
                                                                        <option value="<?php echo $areas_dato['id_area']; ?>">
                                                                            <?php echo $areas_dato['nombre_area']; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Apartado para Delegado -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Delegado</label>
                                                            <div style="display: flex">
                                                                <select name="nombre_delegado" id="" class="form-control" required>
                                                                    <option value="" disabled selected>Seleccionar…</option>
                                                                    <?php
                                                                    foreach ($delegados_datos as $delegados_dato) { ?>
                                                                        <option value="<?php echo $delegados_dato['id_delegado']; ?>">
                                                                            <?php echo $delegados_dato['nombres']; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Institución -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Institución de Procedencia:</label>
                                                            <input type="text" name="institucion" class="form-control" placeholder="Ej: Universidad Autónoma, Empresa XYZ, etc." required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Motivo -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Motivo:</label>
                                                            <textarea name="motivo" id="" cols="30" rows="2" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Apartado para Estado (oculto) -->
                                                    <div class="col-md-8" hidden>
                                                        <div class="form-group">
                                                            <label for="">Estado:</label>
                                                            <input type="text" name="estado" value="PENDIENTE" hidden>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <!-- Apartado para Descripción -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Descripción Vehículo (Si Aplica):</label>
                                                            <textarea name="comentario_admin" id="" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-3">
                                                <!-- Apartado para Fecha -->
                                                <div class="form-group">
                                                    <label for="">Fecha de Visita:</label>
                                                    <input type="date"
                                                        name="fecha_visita"
                                                        id="fecha_ingreso"
                                                        class="form-control"
                                                        required>
                                                    <small class="text-danger" style="display:none;" id="errorFecha">
                                                        Ingrese una Fecha Válida
                                                    </small>
                                                </div>

                                                <!-- Apartado para Hora -->
                                                <div class="form-group">
                                                    <label for="">Hora de Visita:</label>
                                                    <input type="time"
                                                        name="hora_visita"
                                                        id="hora_visita"
                                                        class="form-control"
                                                        required>
                                                    <small class="text-muted">Formato 24 horas</small>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">Registrar Visita</button>
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

<!-- Script para validar fecha en el formulario -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputFecha = document.getElementById('fecha_ingreso');
        const errorFecha = document.getElementById('errorFecha');

        // Establecer fecha mínima (hoy)
        const hoy = new Date().toISOString().split('T')[0];
        inputFecha.setAttribute('min', hoy);

        // Validar al cambiar la fecha
        inputFecha.addEventListener('change', function() {
            const fechaSeleccionada = new Date(this.value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0);

            if (fechaSeleccionada < fechaActual) {
                errorFecha.style.display = 'block';
                this.value = '';
            } else {
                errorFecha.style.display = 'none';
            }
        });

        // Validar al enviar el formulario
        inputFecha.form.addEventListener('submit', function(e) {
            const fechaSeleccionada = new Date(inputFecha.value);
            const fechaActual = new Date();
            fechaActual.setHours(0, 0, 0, 0);

            if (fechaSeleccionada < fechaActual) {
                e.preventDefault();
                errorFecha.style.display = 'block';
                inputFecha.focus();
            }
        });
    });
</script>