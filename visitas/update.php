<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/usuarios/listado_de_usuarios.php');
include('../app/controllers/delegados/listado_de_delegados.php');
include('../app/controllers/areas/listado_de_areas.php');
include('../app/controllers/visitas/show.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualizar Visita</h1>
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
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <form action="../app/controllers/visitas/update.php" method="post">
                                        <input type="text" value="<?php echo $id_visita_get; ?>" name="id_visita" hidden>

                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <!-- Apartado para Solicitante -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Solicitante:</label>
                                                            <div style="display: flex">
                                                                <input type="text" class="form-control" value="<?php echo $nombres_sesion; ?>" disabled>
                                                                <input type="text" name="id_usuario" value="<?php echo $id_usuario_sesion; ?>" hidden>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Área -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Área:</label>
                                                            <div style="display: flex">
                                                                <select name="id_area" class="form-control" required>
                                                                    <?php
                                                                    foreach ($areas_datos as $area_dato) {
                                                                        $nombre_area_tabla = $area_dato['nombre_area'];
                                                                        $id_area_tabla = $area_dato['id_area']; ?>
                                                                        <option value="<?php echo $id_area_tabla; ?>" <?php if ($nombre_area_tabla == $nombre_area) { ?> selected="selected" <?php } ?>>
                                                                            <?php echo $nombre_area_tabla; ?>
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
                                                                <select name="id_delegado" id="" class="form-control" required>
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
                                                    <!-- Apartado para Motivo -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Motivo:</label>
                                                            <input type="text" name="motivo" value="<?php echo $motivo; ?>" class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <!-- Apartado para Estado -->
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="">Estado:</label>
                                                            <input type="text" class="form-control" value="<?php echo $estado; ?>" disabled>
                                                            <input type="text" name="estado" value="PENDIENTE" hidden>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Apartado para Comentarios/Descripción -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="">Descripción Vehículo (Si Aplica):</label>
                                                            <textarea name="comentario_admin" cols="30" rows="5" class="form-control"><?php echo $comentario_admin; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Apartado para Fecha -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Fecha de Visita:</label>
                                                    <input type="date" id="fecha_ingreso" name="fecha_hora" value="<?php echo date('Y-m-d', strtotime($fecha_hora)); ?>" class="form-control" required>
                                                    <small id="errorFecha" style="color: red; display: none;">La fecha no puede ser anterior a hoy</small>

                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            const inputFecha = document.getElementById('fecha_ingreso');
                                                            const errorFecha = document.getElementById('errorFecha');

                                                            // Establecer fecha mínima (hoy)
                                                            const hoy = new Date();
                                                            const fechaMinima = hoy.toISOString().split('T')[0];
                                                            inputFecha.setAttribute('min', fechaMinima);

                                                            // Función para comparar solo fechas (sin hora)
                                                            function compararFechas(fecha1String, fecha2String) {
                                                                return fecha1String < fecha2String;
                                                            }

                                                            // Validar al cambiar la fecha
                                                            inputFecha.addEventListener('change', function() {
                                                                if (compararFechas(this.value, fechaMinima)) {
                                                                    errorFecha.style.display = 'block';
                                                                    this.value = '';
                                                                } else {
                                                                    errorFecha.style.display = 'none';
                                                                }
                                                            });

                                                            // Validar al enviar el formulario
                                                            inputFecha.form.addEventListener('submit', function(e) {
                                                                if (compararFechas(inputFecha.value, fechaMinima)) {
                                                                    e.preventDefault();
                                                                    errorFecha.style.display = 'block';
                                                                    inputFecha.focus();
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="<?php echo ($estado == 'APROBADO') ? 'aprobadas.php' : 'index.php'; ?>" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Actualizar Visita</button>
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